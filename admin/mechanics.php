<?php
session_start();
require_once '../db_connect.php';
$conn = connectDB();

// ✅ Fetch all mechanics from user_tbl
$mechanics = [];
try {
    $stmt = $conn->prepare("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name FROM user_tbl WHERE role = 'Mechanic'");
    $stmt->execute();
    $mechanics = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching mechanics: " . $e->getMessage());
}

// ✅ Fetch all repair bookings (Pending, In Progress, etc.)
$repairs = [];
try {
    $stmt = $conn->query("SELECT r.*, u.first_name, u.last_name 
                          FROM repair_tbl r 
                          JOIN user_tbl u ON r.user_id = u.user_id 
                          ORDER BY r.created_at DESC");
    $repairs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching repair bookings: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assign to Mechanics | MEU Admin</title>
  <link rel="stylesheet" href="mechanics.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="fas fa-wrench"></i>
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
          <a href="mechanics.php" class = "active" >Assign to Mechanics (Repair / Maintenance)</a>
            <a href="emergency.php">Emergency Assign</a>
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
      <a href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a>
      <br>
      <br>
      <br>
      <br>
  </nav>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <header class="header">
      <h1><i class="fas fa-screwdriver-wrench"></i> Assign Repair / Maintenance Tasks to Mechanics</h1>
    </header>

    <!-- Assigned Tasks Table -->
    <section class="table-container">
      <h2><i class="fas fa-list-check"></i> Pending and Active Repairs</h2>
      <table>
        <thead>
          <tr>
            <th>Customer</th>
            <th>Vehicle Model</th>
            <th>Service Type</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Assign Mechanic</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($repairs)): ?>
            <tr><td colspan="7">No repair bookings yet.</td></tr>
          <?php else: ?>
            <?php foreach ($repairs as $repair): ?>
              <tr>
                <td><?= htmlspecialchars($repair['first_name'] . ' ' . $repair['last_name']) ?></td>
                <td><?= htmlspecialchars($repair['vehicle_model']) ?></td>
                <td><?= htmlspecialchars($repair['service_type']) ?></td>
                <td><?= htmlspecialchars($repair['repair_date']) ?></td>
                <td><?= htmlspecialchars($repair['repair_time']) ?></td>
                <td><span class="status <?= strtolower($repair['repair_status']) ?>"><?= htmlspecialchars($repair['repair_status']) ?></span></td>
                <td>
                  <form class="assignForm">
                    <input type="hidden" name="repair_id" value="<?= $repair['repair_id'] ?>">
                    <select name="mechanic_id" required>
                      <option value="">Select Mechanic</option>
                      <?php foreach ($mechanics as $m): ?>
                        <option value="<?= $m['user_id'] ?>" <?= ($repair['assigned_to'] == $m['user_id']) ? 'selected' : '' ?>>
                          <?= htmlspecialchars($m['name']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn-assign"><i class="fas fa-check"></i></button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>

  <script>
  // Dropdown animation
  document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      btn.classList.toggle('active');
      const content = btn.nextElementSibling;
      content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + 'px';
    });
  });

  // Assign mechanic via AJAX
  document.querySelectorAll('.assignForm').forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      const response = await fetch('../backend/assign.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      Swal.fire({
        icon: result.status,
        title: result.status === 'success' ? 'Assigned!' : 'Error!',
        text: result.message,
        confirmButtonColor: '#1e40af'
      }).then(() => {
        if (result.status === 'success') location.reload();
      });
    });
  });
  </script>

</body>
</html>
