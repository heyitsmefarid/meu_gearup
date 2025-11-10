<?php
session_start();
require '../db_connect.php';
$conn = connectDB();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Fetch assigned jobs for the current mechanic with customer name
$stmt = $conn->prepare("
  SELECT 
    r.repair_id, 
    r.vehicle_model, 
    r.service_type, 
    r.issue_description, 
    r.repair_status, 
    r.repair_date, 
    r.total_cost, 
    r.updated_at,
    u.first_name AS customer_fname,
    u.last_name AS customer_lname
  FROM repair_tbl r
  LEFT JOIN user_tbl u ON r.user_id = u.user_id
  WHERE r.assigned_to = ?
  ORDER BY r.repair_date DESC
");
$stmt->execute([$user_id]);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assigned Jobs | Mechanic</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="jobs.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .btn-complete {
      background: #4CAF50;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      transition: background 0.3s;
    }
    .btn-complete:hover {
      background: #3e8e41;
    }
    .btn-disabled {
      background: gray;
      cursor: not-allowed;
    }
  </style>
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
        <a href="index.php"><i class="ri-dashboard-line"></i> Dashboard</a>
        <a href="jobs.php" class="active"><i class="ri-settings-2-line"></i> Assigned Jobs</a>
        <a href="repairs.php"><i class="ri-tools-line"></i> Ongoing Repairs</a>
        <a href="completed.php"><i class="ri-check-double-line"></i> Completed Tasks</a>
        <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
      </nav>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content fade-up">
    <div class="topbar">
      <h2><i class="ri-briefcase-line"></i> Assigned Jobs</h2>
      <div class="avatar">
        <img src="https://cdn-icons-png.flaticon.com/512/1995/1995574.png" alt="Mechanic Avatar">
      </div>
    </div>

    <section class="dashboard-section fade-in">
      <div class="table-header">
        <h3 class="section-title"><i class="ri-settings-2-line"></i> Your Assigned Jobs</h3>
        <button class="btn-refresh" onclick="location.reload()"><i class="ri-refresh-line"></i> Refresh</button>
      </div>

      <div class="table-container">
        <?php if (count($jobs) > 0): ?>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Vehicle Model</th>
                <th>Service Type</th>
                <th>Issue</th>
                <th>Status</th>
                <th>Repair Date</th>
                <th>Total Cost</th>
                <th>Last Updated</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($jobs as $job): ?>
                <tr>
                  <td><?= htmlspecialchars($job['repair_id']) ?></td>
                  <td><?= htmlspecialchars($job['customer_fname'] . ' ' . $job['customer_lname']) ?></td>
                  <td><?= htmlspecialchars($job['vehicle_model']) ?></td>
                  <td><?= htmlspecialchars($job['service_type']) ?></td>
                  <td><?= htmlspecialchars($job['issue_description']) ?></td>
                  <td><span class="status <?= strtolower(str_replace(' ', '_', $job['repair_status'])) ?>"><?= htmlspecialchars($job['repair_status']) ?></span></td>
                  <td><?= htmlspecialchars($job['repair_date']) ?></td>
                  <td>₱<?= number_format($job['total_cost'], 2) ?></td>
                  <td><?= htmlspecialchars($job['updated_at']) ?></td>
                  <td>
                    <?php if (strtolower($job['repair_status']) !== 'completed'): ?>
                      <button class="btn-complete" onclick="markCompleted(<?= $job['repair_id'] ?>)">Mark as Complete</button>
                    <?php else: ?>
                      <button class="btn-complete btn-disabled" disabled>Completed</button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="empty">
            <i class="ri-emotion-sad-line"></i>
            <p>No assigned jobs yet. Please check back later!</p>
          </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <script>
  // SweetAlert + AJAX update
  function markCompleted(repairId) {
    Swal.fire({
      title: "Confirm Completion",
      text: "Are you sure you want to mark this repair as completed?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, complete it!",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("../backend/update_status.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "repair_id=" + repairId
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire("Success!", "The repair has been marked as completed.", "success")
              .then(() => location.reload());
          } else {
            Swal.fire("Error", data.message || "Something went wrong.", "error");
          }
        });
      }
    });
  }
  </script>
</body>
</html>
