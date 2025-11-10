<?php
session_start();
require '../db_connect.php';
$conn = connectDB();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Fetch completed repairs for this mechanic
$stmt = $conn->prepare("
  SELECT repair_id, vehicle_model, service_type, issue_description, repair_date, total_cost, repair_status
  FROM repair_tbl
  WHERE assigned_to = ? AND repair_status = 'Completed'
  ORDER BY repair_date DESC
");
$stmt->execute([$user_id]);
$repairs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Completed Repairs | Mechanic Dashboard</title>

  <!-- icons -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

  <!-- your CSS (keeps the MEU theme you supplied) -->
  <link rel="stylesheet" href="completed.css">
</head>
<body>
  <!-- SIDEBAR (matches the CSS expectations) -->
  <aside class="sidebar" id="sidebar">
    <div>
      <div class="logo">
        <i class="ri-tools-line"></i>
        <span>MEU GearUp</span>
      </div>

      <nav class="menu">
        <a href="index.php"><i class="ri-dashboard-line"></i> Dashboard</a>
        <a href="jobs.php"><i class="ri-briefcase-line"></i> Assigned Jobs</a>
        <a href="repairs.php"><i class="ri-tools-line"></i> Ongoing Repairs</a>
        <a href="completed.php" class="active"><i class="ri-check-double-line"></i> Completed</a>
        <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
      </nav>
    </div>

    
  </aside>

  <!-- MAIN CONTENT wrapper expected by your CSS -->
  <div class="main-content">
    <main>
      <header class="page-header fade-in">
        <h2><i class="ri-check-double-line"></i> Completed Repairs</h2>

        <!-- small mobile toggle shown only on small screens (CSS already handles layout) -->
        <div style="display:flex;gap:.5rem;align-items:center;">
          <button class="btn-refresh" onclick="location.reload()">
            <i class="ri-refresh-line"></i> Refresh
          </button>

          <!-- mobile sidebar toggle -->
          <button id="btnToggleSidebar" style="margin-left:8px; background:transparent; border:none; color:inherit; cursor:pointer;">
            <i class="ri-menu-line" style="font-size:1.3rem;"></i>
          </button>
        </div>
      </header>

      <?php if (count($repairs) > 0): ?>
        <div class="repair-grid fade-up">
          <?php foreach ($repairs as $repair): ?>
            <article class="repair-card slide-up" aria-labelledby="repair-<?= htmlspecialchars($repair['repair_id']) ?>">
              <div class="repair-header" style="display:flex;align-items:center;gap:.75rem;margin-bottom:10px;">
                <i class="ri-car-line"></i>
                <h3 id="repair-<?= htmlspecialchars($repair['repair_id']) ?>"><?= htmlspecialchars($repair['vehicle_model']) ?></h3>
              </div>

              <div class="repair-body">
                <p><strong>Service Type:</strong> <?= htmlspecialchars($repair['service_type']) ?></p>
                <p><strong>Issue:</strong> <?= nl2br(htmlspecialchars($repair['issue_description'] ?? '—')) ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($repair['repair_date']) ?></p>
                <p><strong>Cost:</strong> ₱<?= htmlspecialchars(number_format($repair['total_cost'], 2)) ?></p>

              </div>

              <div class="status-label completed" aria-hidden="true">
                <i class="ri-checkbox-circle-line"></i> <?= htmlspecialchars($repair['repair_status']) ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="empty fade-up">
          <i class="ri-emotion-happy-line"></i>
          <p>No completed repairs yet.</p>
        </div>
      <?php endif; ?>
    </main>
  </div>

  <!-- Small JS: theme toggle + sidebar toggle (keeps state in localStorage) -->
  <script>
    (function(){
      const body = document.body;
      const STORAGE_KEY = 'meu_theme';
      const saved = localStorage.getItem(STORAGE_KEY);
      if (saved === 'dark') body.classList.add('dark');

      // theme icons
      const sun = document.getElementById('theme-sun');
      const moon = document.getElementById('theme-moon');
      function updateIcons() {
        if (body.classList.contains('dark')) {
          sun.style.opacity = '1';
          moon.style.opacity = '0.4';
        } else {
          sun.style.opacity = '0.4';
          moon.style.opacity = '1';
        }
      }
      updateIcons();

      document.getElementById('themeToggle').addEventListener('click', () => {
        body.classList.toggle('dark');
        localStorage.setItem(STORAGE_KEY, body.classList.contains('dark') ? 'dark' : 'light');
        updateIcons();
      });

      // mobile sidebar toggle
      const sidebar = document.getElementById('sidebar');
      const btnToggle = document.getElementById('btnToggleSidebar');
      btnToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
    })();
  </script>
</body>
</html>
