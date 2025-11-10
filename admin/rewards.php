<?php
session_start();

// 🧮 Sample mechanic data (replace later with DB fetch)
$mechanics = [
  ["id" => 1, "name" => "John Cruz", "branch" => "Main Branch", "completed" => 37],
  ["id" => 2, "name" => "Rico Dela Vega", "branch" => "Branch 1", "completed" => 22],
  ["id" => 3, "name" => "Arnold Reyes", "branch" => "Branch 2", "completed" => 15],
  ["id" => 4, "name" => "Benjie Santos", "branch" => "Branch 2", "completed" => 5],
  ["id" => 5, "name" => "Marvin Dela Cruz", "branch" => "Main Branch", "completed" => 40],
];

// 🧠 Reward formula: ₱100 per 10 completed repairs
foreach ($mechanics as &$m) {
  $m['rewards'] = floor($m['completed'] / 10) * 100;
}
unset($m);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mechanic Reports & Rewards | MEU Admin</title>
  <link rel="stylesheet" href="rewards.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="fas fa-cogs"></i>
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
          <a href="rewards.php"class="active">View Mechanic Reports</a>
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
      <h1><i class="fas fa-wrench"></i> Mechanic Reports & Reward System</h1>
      <p>Each 10 completed repairs = ₱100 bonus reward</p>
    </header>

    <section class="rewards-section">
      <div class="filter-bar">
        <input type="text" placeholder="Search mechanic..." class="search-input">
        <button class="btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Mechanic Name</th>
              <th>Branch</th>
              <th>Completed Repairs</th>
              <th>Reward</th>
              <th>Performance</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mechanics as $m): ?>
              <tr>
                <td><?= $m['id'] ?></td>
                <td><?= htmlspecialchars($m['name']) ?></td>
                <td><?= htmlspecialchars($m['branch']) ?></td>
                <td><?= $m['completed'] ?></td>
                <td>₱<?= number_format($m['rewards'], 2) ?></td>
                <td>
                  <div class="progress-bar">
                    <div class="progress" style="width: <?= min($m['completed'] / 50 * 100, 100) ?>%;"></div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  
  <script>
    // Dropdown toggle logic
    document.querySelectorAll('.dropdown-btn').forEach(button => {
      button.addEventListener('click', () => {
        button.classList.toggle('active');
        const dropdownContent = button.nextElementSibling;

        if (dropdownContent.style.maxHeight) {
          dropdownContent.style.maxHeight = null;
        } else {
          dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
        }
      });
    });
  </script>

</body>
</html>
