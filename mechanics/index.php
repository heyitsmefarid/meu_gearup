<?php
session_start();
require_once '../functions.php';
$conn = connectDB();

// Get the logged-in mechanic's user_id
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch mechanic dashboard data
$activeJobs = $conn->query("SELECT COUNT(*) FROM repair_tbl WHERE assigned_to = $user_id AND repair_status = 'In Progress'")->fetchColumn();
$pendingJobs = $conn->query("SELECT COUNT(*) FROM repair_tbl WHERE assigned_to = $user_id AND repair_status = 'Pending'")->fetchColumn();
$completedJobs = $conn->query("SELECT COUNT(*) FROM repair_tbl WHERE assigned_to = $user_id AND repair_status = 'Completed'")->fetchColumn();
$totalAssigned = $conn->query("SELECT COUNT(*) FROM repair_tbl WHERE assigned_to = $user_id")->fetchColumn();

// Fetch mechanic info
$stmt = $conn->prepare("SELECT first_name, last_name, email, role FROM user_tbl WHERE user_id = ?");
$stmt->execute([$user_id]);
$mechanic = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mechanic Dashboard | MEU GearUp</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div>
      <div class="logo">
             <i class="ri-motorbike-line"></i>
      <span>MEU GearUp</span>
        </div>

      <nav class="menu">
        <a href="index.php" class="active"><i class="ri-dashboard-line"></i> Dashboard</a>
        <a href="jobs.php"><i class="ri-settings-2-line"></i> Assigned Jobs</a>
        <a href="repairs.php"><i class="ri-tools-line"></i> Ongoing Repairs</a>
        <a href="completed.php"><i class="ri-check-double-line"></i> Completed Tasks</a>
      
        <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
      </nav>
    </div>

  
  </aside>

  <!-- Main Content -->
  <!-- Main Content -->
  <main class="main-content fade-up">
    <div class="topbar fade-in">
      <h2>Welcome back, <span><?= htmlspecialchars($mechanic['first_name'] ?? 'Mechanic') ?></span> 👋</h2>
     
    </div>

    <!-- Overview Section -->
    <section class="dashboard">
      <div class="section-header">
        <h3><i class="ri-dashboard-line"></i> Dashboard Overview</h3>
        <p class="subtitle">Here’s an overview of your mechanic activities and system insights.</p>
      </div>

      <div class="card-grid">
        <div class="dashboard-card fade-in delay-1">
          <div class="icon-circle blue"><i class="ri-tools-fill"></i></div>
          <div class="card-info">
            <h4>Active Repairs</h4>
            <p class="stat-number"><?= $activeJobs ?></p>
          </div>
        </div>

        <div class="dashboard-card fade-in delay-2">
          <div class="icon-circle yellow"><i class="ri-time-line"></i></div>
          <div class="card-info">
            <h4>Pending Jobs</h4>
            <p class="stat-number"><?= $pendingJobs ?></p>
          </div>
        </div>

        <div class="dashboard-card fade-in delay-3">
          <div class="icon-circle green"><i class="ri-checkbox-circle-line"></i></div>
          <div class="card-info">
            <h4>Completed Services</h4>
            <p class="stat-number"><?= $completedJobs ?></p>
          </div>
        </div>

        <div class="dashboard-card fade-in delay-4">
          <div class="icon-circle purple"><i class="ri-briefcase-line"></i></div>
          <div class="card-info">
            <h4>Total Assigned</h4>
            <p class="stat-number"><?= $totalAssigned ?></p>
          </div>
        </div>
      </div>
    </section>

    <!-- Mechanic Info -->
    <section class="info-section fade-up">
      <h3 class="section-title"><i class="ri-user-settings-line"></i> Your Information</h3>
      <div class="info-card fade-in">
        <div class="info-content">
          <p><strong>Name:</strong> <?= htmlspecialchars(($mechanic['first_name'] ?? '') . ' ' . ($mechanic['last_name'] ?? '')) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($mechanic['email'] ?? '') ?></p>
          <p><strong>Role:</strong> <?= htmlspecialchars($mechanic['role'] ?? 'Mechanic') ?></p>
        </div>
        <div class="gear-illustration">
          <i class="ri-settings-5-fill rotating"></i>
        </div>
      </div>
    </section>
  </main>


  <!-- Dark Mode Toggle -->
  <script>
  (function(){
    const themeToggle = document.querySelector('.theme-toggle');
    const sun = document.getElementById('theme-sun');
    const moon = document.getElementById('theme-moon');
    const body = document.body;
    const STORAGE_KEY = 'meu_theme';

    const saved = localStorage.getItem(STORAGE_KEY);
    if(saved === 'dark') body.classList.add('dark');

    const updateIcons = () => {
      sun.style.opacity = body.classList.contains('dark') ? '1' : '0.4';
      moon.style.opacity = body.classList.contains('dark') ? '0.4' : '1';
    };
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
