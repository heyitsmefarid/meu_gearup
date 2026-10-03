"""
Builds the static portfolio version of MEU GearUp into dist/ (what Vercel hosts).

Every page is rendered through local PHP + MySQL, logged in as each role, and
saved as plain HTML. Links to .php pages are rewritten to .html, and dist/demo.js
stops forms and saves (there is no server behind the demo).

Run from this folder with Laragon's MySQL running, after changing any page:
    python build_static.py
"""
import os
import re
import shutil
import socket
import subprocess
import tempfile
import time
import urllib.error
import urllib.request
from pathlib import Path

ROOT = Path(__file__).resolve().parent
DIST = ROOT / "dist"
PHP = Path(r"C:\laragon\bin\php\php-8.2.27-Win32-vs16-x64\php.exe")

# Which account each dashboard folder is rendered as (user_id from user_tbl).
ROLES = {
    "admin": (2, "Admin"),
    "mechanics": (4, "Mechanic"),
    "supplier": (3, "Supplier"),
    "user": (1, "Customer"),
}
PUBLIC_PAGES = ["index.php", "login/index.php"]

SKIP_DIRS = {".git", ".vercel", "dist", "api", "backend", "phpmailer", "node_modules"}
STATIC_EXTS = {".css", ".js", ".html", ".png", ".jpg", ".jpeg", ".webp", ".gif", ".svg",
               ".ico", ".woff", ".woff2", ".ttf", ".eot", ".otf", ".map"}

PHP_LINK = re.compile(r"(?<=[\w\-])\.php(?=[\"'`?#)\s\\])")

DEMO_JS = """// Portfolio demo: there is no server behind these pages, so nothing can be saved.
(function () {
  var MESSAGE = 'This is a portfolio demo without a server, so nothing can be saved.';

  function notify(text) {
    if (window.Swal) {
      Swal.fire({ icon: 'info', title: 'Demo only', text: text });
    } else {
      alert(text);
    }
  }

  // Capture phase on window runs before the page's own submit handlers.
  window.addEventListener('submit', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    notify(e.target.id === 'b-form'
      ? 'Sign-in is turned off in this demo. Use the "View as" buttons to open a dashboard.'
      : MESSAGE);
  }, true);

  var realFetch = window.fetch;
  window.fetch = function (input, init) {
    var url = typeof input === 'string' ? input : (input && input.url) || '';
    var method = ((init && init.method) || (input && input.method) || 'GET').toUpperCase();
    if (method === 'GET' || method === 'HEAD') {
      return realFetch.apply(this, arguments);
    }
    if (url.indexOf('logout_process') !== -1) {
      // Let the logout page finish and return to the homepage.
      return Promise.resolve(new Response(''));
    }
    notify(MESSAGE);
    return new Promise(function () {}); // never settles, so the page shows no error
  };
})();
"""

# Pinned to the top of the login page so it shows on both the sign-in and sign-up side.
DEMO_ROLES_STYLE = """<style>
  .demo-roles { position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;
                margin: 0; font-size: 13px; color: #6b7a99; text-align: center; white-space: nowrap; }
  .demo-roles a { display: inline-block; margin-left: 4px; padding: 6px 12px; border-radius: 20px;
                  background: #4B70E2; color: #f9f9f9; font-weight: 700; text-decoration: none; }
</style>
"""

DEMO_ROLES_HTML = """<p class="demo-roles">Portfolio demo &middot; view as
        <a href="../admin/index.html">Admin</a>
        <a href="../mechanics/index.html">Mechanic</a>
        <a href="../supplier/index.html">Supplier</a>
        <a href="../user/index.html">Customer</a>
    </p>
    """
LOGIN_MAIN = '<div class="main">'


def free_port():
    with socket.socket() as s:
        s.bind(("127.0.0.1", 0))
        return s.getsockname()[1]


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, *args, **kwargs):
        return None


def fetch(port, page, session_id):
    req = urllib.request.Request(f"http://127.0.0.1:{port}/{page}")
    if session_id:
        req.add_header("Cookie", f"PHPSESSID={session_id}")
    opener = urllib.request.build_opener(NoRedirect)
    try:
        with opener.open(req) as res:
            return res.status, res.read().decode("utf-8")
    except urllib.error.HTTPError as e:
        return e.code, e.headers.get("Location", "")


def add_demo_script(html, page):
    depth = page.count("/")
    tag = f'<script src="{"../" * depth}demo.js"></script>\n'
    idx = html.lower().rfind("</body>")
    return html + tag if idx == -1 else html[:idx] + tag + html[idx:]


def main():
    # Empty dist/ rather than deleting it, so a folder open in Explorer doesn't block the build.
    DIST.mkdir(exist_ok=True)
    for child in DIST.iterdir():
        shutil.rmtree(child) if child.is_dir() else child.unlink()

    work = Path(tempfile.mkdtemp(prefix="meu_static_"))
    sessions = work / "sessions"
    sessions.mkdir()
    error_log = work / "php_errors.log"
    for folder, (user_id, role) in ROLES.items():
        (sessions / f"sess_demo{folder}").write_text(
            f'user_id|i:{user_id};role|s:{len(role)}:"{role}";', encoding="utf-8")

    port = free_port()
    server = subprocess.Popen(
        [str(PHP), "-d", "extension=pdo_mysql", "-d", "output_buffering=4096",
         "-d", f"session.save_path={sessions}", "-d", "display_errors=0",
         "-d", "log_errors=1", "-d", f"error_log={error_log}",
         "-S", f"127.0.0.1:{port}", "-t", str(ROOT)],
        cwd=ROOT, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    try:
        for _ in range(50):
            try:
                socket.create_connection(("127.0.0.1", port), timeout=0.2).close()
                break
            except OSError:
                time.sleep(0.1)

        pages = [(p, None) for p in PUBLIC_PAGES]
        for folder in ROLES:
            pages += [(f"{folder}/{f.name}", f"demo{folder}") for f in sorted((ROOT / folder).glob("*.php"))]

        for page, session_id in pages:
            status, body = fetch(port, page, session_id)
            if status != 200:
                print(f"SKIPPED {page}: HTTP {status} {body}")
                continue
            html = add_demo_script(PHP_LINK.sub(".html", body), page)
            if page == "login/index.php":
                html = html.replace("</head>", DEMO_ROLES_STYLE + "</head>", 1)
                html = html.replace(LOGIN_MAIN, DEMO_ROLES_HTML + LOGIN_MAIN, 1)
            out = DIST / Path(page).with_suffix(".html")
            out.parent.mkdir(parents=True, exist_ok=True)
            out.write_text(html, encoding="utf-8")
            print(f"rendered {page}")
    finally:
        server.terminate()
        server.wait()

    for dirpath, dirnames, filenames in os.walk(ROOT):
        dirnames[:] = [d for d in dirnames if d not in SKIP_DIRS]
        for name in filenames:
            src = Path(dirpath) / name
            if src.suffix.lower() not in STATIC_EXTS:
                continue
            rel = src.relative_to(ROOT)
            dst = DIST / rel
            dst.parent.mkdir(parents=True, exist_ok=True)
            if src.suffix in (".js", ".html") and "vendor" not in rel.parts:
                dst.write_text(PHP_LINK.sub(".html", src.read_text(encoding="utf-8")), encoding="utf-8")
            else:
                shutil.copy2(src, dst)

    (DIST / "demo.js").write_text(DEMO_JS, encoding="utf-8")

    errors = error_log.read_text(encoding="utf-8") if error_log.exists() else ""
    shutil.rmtree(work, ignore_errors=True)
    if errors:
        print("\nPHP warnings/errors while rendering:\n" + errors)
    print(f"\nDone: {DIST}")


if __name__ == "__main__":
    main()
