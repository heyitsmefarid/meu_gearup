<?php
session_start();
require '../db_connect.php';
$conn = connectDB();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Fetch ongoing repairs assigned to this mechanic (include customer name)
$stmt = $conn->prepare("
  SELECT 
    r.repair_id, 
    r.vehicle_model, 
    r.service_type, 
    r.issue_description, 
    r.repair_date, 
    r.total_cost, 
    r.repair_status,
    u.first_name AS customer_fname,
    u.last_name AS customer_lname
  FROM repair_tbl r
  LEFT JOIN user_tbl u ON r.user_id = u.user_id
  WHERE r.assigned_to = ? AND r.repair_status = 'In Progress'
  ORDER BY r.repair_date DESC
");
$stmt->execute([$user_id]);
$repairs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ongoing Repairs | Mechanic Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="repairs.css">
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
        <a href="jobs.php"><i class="ri-briefcase-line"></i> Assigned Jobs</a>
        <a href="repairs.php" class="active"><i class="ri-tools-line"></i> Ongoing Repairs</a>
        <a href="completed.php"><i class="ri-check-double-line"></i> Completed Tasks</a>
        <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
      </nav>
    </div>
  </aside>

  <!-- Main Section -->
  <main>
    <header class="page-header fade-in">
      <h2><i class="ri-tools-line"></i> Ongoing Repairs</h2>
      <button class="btn-refresh" onclick="location.reload()">
        <i class="ri-refresh-line"></i> Refresh
      </button>
    </header>

    <?php if (count($repairs) > 0): ?>
      <div class="repair-grid fade-up">
        <?php foreach ($repairs as $repair): ?>
          <div class="repair-card slide-up">
            <div class="repair-header">
              <h3><i class="ri-car-line"></i> <?= htmlspecialchars($repair['vehicle_model']) ?></h3>
            </div>

            <div class="repair-body">
              <p><strong>Customer:</strong> <?= htmlspecialchars($repair['customer_fname'] . ' ' . $repair['customer_lname']) ?></p>
              <p><strong>Service Type:</strong> <?= htmlspecialchars($repair['service_type']) ?></p>
              <p><strong>Issue:</strong> <?= htmlspecialchars($repair['issue_description']) ?></p>
              <p><strong>Date:</strong> <?= htmlspecialchars($repair['repair_date']) ?></p>
              <p><strong>Cost:</strong> ₱<?= htmlspecialchars(number_format($repair['total_cost'], 2)) ?></p>
            </div>

            <div class="status-tag">
              <i class="ri-loader-4-line spin"></i> <?= htmlspecialchars($repair['repair_status']) ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty fade-up">
        <i class="ri-emotion-sad-line"></i>
        <p>No ongoing repairs found.</p>
      </div>
    <?php endif; ?>
  </main>

</body>
</html>
