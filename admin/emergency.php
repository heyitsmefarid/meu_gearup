<?php
require '../db_connect.php';
$conn = connectDB();
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

// Fetch all emergency requests
$stmt = $conn->query("
  SELECT e.emergency_id, e.issue, e.location, e.latitude, e.longitude, e.status, e.created_at,
         u.first_name, u.last_name
  FROM emergency_tbl e
  LEFT JOIN user_tbl u ON e.user_id = u.user_id
  ORDER BY e.created_at DESC
");
$emergencies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all available mechanics
$mechs = $conn->query("SELECT user_id, first_name, last_name FROM user_tbl WHERE role = 'Mechanic'")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emergency Requests | Admin</title>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="branch.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .map-iframe { width: 100%; height: 220px; border: none; border-radius: 10px; }
    .assign-btn { background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; }
    .assign-btn:hover { background: #0056b3; }
    .status-badge { padding: 4px 10px; border-radius: 6px; color: white; font-weight: 600; }
    .Pending { background: #ff9800; }
    .In\ Progress { background: #2196f3; }
    .Resolved { background: #4caf50; }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="fas fa-tools"></i>
      <span>MEU Admin</span>
    </div>

   <nav class="menu">
      <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>

      <!-- Multi-Branch Control Panel -->
      <div class="dropdown">
        <button class="dropdown-btn"><i class="fas fa-building"></i> Multi-Branch Control <i class="fas fa-chevron-down"></i></button>
        <div class="dropdown-content">
          <a href="view.php">View All Branches</a>
         
          <a href="performance.php">View Branch Performance</a>
        </div>
      </div>

      <!-- Manage Users -->
      <div class="dropdown">
        <button class="dropdown-btn"><i class="fas fa-users"></i> Manage Users <i class="fas fa-chevron-down"></i></button>
        <div class="dropdown-content">
          <a href="user.php">View User Details</a>
          <a href="roles.php">Manage Roles (Supplier, Mechanic)</a>
        </div>
      </div>

      <!-- Manage Inventory -->
      <div class="dropdown">
        <button class="dropdown-btn"><i class="fas fa-boxes-stacked"></i> Manage Inventory <i class="fas fa-chevron-down"></i></button>
        <div class="dropdown-content">
          <a href="items.php">Add / Update / Delete Items</a>
          <a href="stock.php">View Stock Levels (per Branch)</a>
          <a href="transfer.php">Transfer Items Between Branches</a>
        </div>
      </div>

      <!-- Assign Requests -->
      <div class="dropdown">
        <button class="dropdown-btn"><i class="fas fa-tasks"></i> Assign Requests <i class="fas fa-chevron-down"></i></button>
        <div class="dropdown-content">
          <a href="suppliers.php">Assign to Suppliers (Parts / Materials)</a>
          <a href="mechanics.php">Assign to Mechanics (Repair / Maintenance)</a>
        </div>
      </div>

      <!-- Monitor Progress -->
      <div class="dropdown">
        <button class="dropdown-btn"><i class="fas fa-chart-line"></i> Monitor Progress <i class="fas fa-chevron-down"></i></button>
        <div class="dropdown-content">
          <a href="updates.php">View Supplier Updates</a>
          <a href="rewards.php">View Mechanic Reports</a>
        </div>
      </div>

      <!-- POS -->
      <div class="dropdown">
        <button class="dropdown-btn"><i class="fas fa-cash-register"></i> Point of Sale (POS) <i class="fas fa-chevron-down"></i></button>
        <div class="dropdown-content">
          <a href="branch_sales.php">Sales (per Branch)</a>
          <a href="transactions.php">View Transactions / Receipts</a>
          <a href="payments.php">Manage Discounts / Payments</a>
          <a href="summary.php">Daily Sales Summary</a>
        </div>
      </div>

      <!-- Reports & Analytics -->
      <div class="dropdown">
        <button class="dropdown-btn"><i class="fas fa-chart-pie"></i> Reports & Analytics <i class="fas fa-chevron-down"></i></button>
        <div class="dropdown-content">
          <a href="inventory.php">Inventory Reports (per Branch / Overall)</a>
          <a href="task.php">Task Completion Reports</a>
          <a href="activity_logs.php">User Activity Logs</a>
          <a href="mechanics_report.php">Mechanics Repair Reports</a>
          <a href="sales_report.php">Sales Reports (Branch / Consolidated)</a>
        </div>
      </div>
  <a href="response.php"><i class="fas fa-envelope"></i> Inquiries</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
      <br>
      <br>
      <br>
      <br>
  </nav>
  </aside>
  <!-- Main Content -->
  <main class="main-content fade-up">
    <div class="topbar">
      <h2><i class="ri-alert-line"></i> Emergency Requests</h2>
    </div>

    <section class="dashboard-section fade-in">
      <?php if (count($emergencies) > 0): ?>
        <?php foreach ($emergencies as $em): ?>
          <div class="card fade-in">
            <h3><i class="ri-error-warning-line"></i> Request #<?= $em['emergency_id'] ?> 
              <span class="status-badge <?= str_replace(' ', '\\ ', $em['status']) ?>"><?= $em['status'] ?></span>
            </h3>
            <p><strong>Reported by:</strong> <?= htmlspecialchars($em['first_name'].' '.$em['last_name']) ?></p>
            <p><strong>Issue:</strong> <?= htmlspecialchars($em['issue']) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($em['location']) ?></p>
            <?php if ($em['latitude'] && $em['longitude']): ?>
              <iframe class="map-iframe"
                src="https://maps.google.com/maps?q=<?= $em['latitude'] ?>,<?= $em['longitude'] ?>&z=15&output=embed">
              </iframe>
            <?php endif; ?>

            <?php if ($em['status'] === 'Pending'): ?>
              <form class="assign-form" onsubmit="assignMechanic(event, <?= $em['emergency_id'] ?>)">
                <label>Select Mechanic:</label>
                <select name="mechanic_id" required>
                  <option value="">-- Choose Mechanic --</option>
                  <?php foreach ($mechs as $m): ?>
                    <option value="<?= $m['user_id'] ?>"><?= $m['first_name'].' '.$m['last_name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <button type="submit" class="assign-btn">Assign</button>
              </form>
            <?php else: ?>
              <p><strong>Status:</strong> <?= htmlspecialchars($em['status']) ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty">
          <i class="ri-emotion-sad-line"></i>
          <p>No emergency requests yet.</p>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <script>
  // Assign Mechanic via AJAX
    document.querySelectorAll('.dropdown-btn').forEach(button => {
      button.addEventListener('click', () => {
        button.classList.toggle('active');
        const dropdownContent = button.nextElementSibling;
        dropdownContent.style.maxHeight = dropdownContent.style.maxHeight ? null : dropdownContent.scrollHeight + "px";
      });
    });
  function assignMechanic(event, emergencyId) {
    event.preventDefault();
    const form = event.target;
    const mechanicId = form.mechanic_id.value;

    Swal.fire({
      title: "Confirm Assignment",
      text: "Assign this emergency to the selected mechanic?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, assign",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("../backend/assign_emergency.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "emergency_id=" + emergencyId + "&mechanic_id=" + mechanicId
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire("Success!", "Mechanic assigned successfully.", "success")
              .then(() => location.reload());
          } else {
            Swal.fire("Error", data.message || "Failed to assign.", "error");
          }
        });
      }
    });
  }
  </script>
</body>
</html>
