<?php
require '../db_connect.php';
$conn = connectDB();
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Fetch completed repairs for this user (remarks removed)
$stmt = $conn->prepare("
  SELECT 
    r.repair_id,
    r.service_type,
    r.repair_date,
    r.repair_time,
    r.issue_description,
    r.repair_status,
    r.updated_at,
    u.first_name AS mechanic_fname,
    u.last_name AS mechanic_lname
  FROM repair_tbl r
  LEFT JOIN user_tbl u ON r.assigned_to = u.user_id
  WHERE r.user_id = ? AND r.repair_status = 'Completed'
  ORDER BY r.updated_at DESC
");
$stmt->execute([$user_id]);
$repairs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Repairs | MEU GearUp</title>

  <!-- Styles -->
  <link rel="stylesheet" href="repairs.css">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div>
      <div class="logo">
        <i class="ri-tools-line"></i>
        <span>MEU GearUp</span>
      </div>

      <nav class="menu">
        <a href="index.php"><i class="ri-dashboard-line"></i> Dashboard</a>
        <a href="book.php"><i class="fa-solid fa-wrench"></i> Book Services</a>
        <a href="browse.php"><i class="ri-shopping-bag-3-line"></i> Browse Parts</a>
        <a href="repairs.php" class="active"><i class="ri-tools-line"></i> My Repairs</a>
        <a href="emergency.php"><i class="ri-map-pin-line"></i> Roadside Request</a>
        <a href="inquiry.php"><i class="ri-message-3-line"></i> Inquiries</a>
        <a href="profile.php"><i class="ri-user-line"></i> Profile</a>
        <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
      </nav>
    </div>

    <!-- Theme Toggle -->
    <div class="theme-toggle" aria-hidden="false" role="button" title="Toggle Theme">
      <i class="ri-sun-line" id="theme-sun"></i>
      <i class="ri-moon-line" id="theme-moon"></i>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <div class="topbar">
      <h2>My <span>Repairs</span></h2>
      <div class="avatar">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User Avatar">
      </div>
    </div>

    <section class="repairs-section fade-up">
      <h3><i class="ri-check-double-line"></i> Successful Repair Services</h3>
      <p class="subtitle">Here are your recently completed service requests.</p>

      <div class="repairs-grid">
        <?php if (count($repairs) > 0): ?>
          <?php foreach ($repairs as $repair): ?>
            <div class="repair-card fade-in">
              <div class="icon"><i class="ri-tools-line"></i></div>
              <h4><?= htmlspecialchars($repair['service_type']) ?></h4>
              <p><strong>Date Completed:</strong> <?= date("F j, Y", strtotime($repair['updated_at'])) ?></p>
              <p><strong>Time:</strong> <?= htmlspecialchars($repair['repair_time']) ?></p>
              <p><strong>Mechanic:</strong> <?= htmlspecialchars($repair['mechanic_fname'] . ' ' . $repair['mechanic_lname']) ?></p>
              <span class="status completed"><?= htmlspecialchars($repair['repair_status']) ?></span>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="no-repairs">
            <i class="ri-emotion-sad-line"></i>
            <p>You don't have any completed repairs yet.</p>
          </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <!-- Theme Toggle Script -->
  <script>
  (function(){
    const themeToggle = document.querySelector('.theme-toggle');
    const sun = document.getElementById('theme-sun');
    const moon = document.getElementById('theme-moon');
    const body = document.body;
    const STORAGE_KEY = 'meu_theme';

    const saved = localStorage.getItem(STORAGE_KEY);
    if(saved === 'dark') body.classList.add('dark');
    if(saved === 'light') body.classList.remove('dark');

    function updateIcons() {
      if(body.classList.contains('dark')) {
        sun.style.opacity = '1';
        moon.style.opacity = '0.4';
      } else {
        sun.style.opacity = '0.4';
        moon.style.opacity = '1';
      }
    }
    updateIcons();

    themeToggle.addEventListener('click', () => {
      body.classList.toggle('dark');
      localStorage.setItem(STORAGE_KEY, body.classList.contains('dark') ? 'dark' : 'light');
      updateIcons();
    });
  })();
  </script>
</body>
</html>
