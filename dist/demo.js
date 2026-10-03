// Portfolio demo: there is no server behind these pages, so nothing can be saved.
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
