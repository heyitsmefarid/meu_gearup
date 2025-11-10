<?php
session_start();

// Simulated Admin Data
$admin_name = "Admin User";

// Sample stock data per branch
$stock_data = [
  ["branch" => "Main Branch", "item" => "Engine Oil", "quantity" => 150, "status" => "Sufficient"],
  ["branch" => "Main Branch", "item" => "Air Filter", "quantity" => 40, "status" => "Low Stock"],
  ["branch" => "Branch 1", "item" => "Brake Pads", "quantity" => 70, "status" => "Sufficient"],
  ["branch" => "Branch 1", "item" => "Transmission Fluid", "quantity" => 20, "status" => "Low Stock"],
  ["branch" => "Branch 2", "item" => "Wiper Blades", "quantity" => 90, "status" => "Sufficient"],
  ["branch" => "Branch 2", "item" => "Coolant", "quantity" => 15, "status" => "Critical"],
  ["branch" => "Branch 3", "item" => "Spark Plugs", "quantity" => 60, "status" => "Sufficient"],
  ["branch" => "Branch 3", "item" => "Tires", "quantity" => 25, "status" => "Low Stock"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Levels per Branch | MEU GearUp</title>
  <link rel="stylesheet" href="branch.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  <!-- ===== Sidebar ===== -->
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
          <a href="stock.php"class="active">View Stock Levels (per Branch)</a>
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
      <a href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a>
      <br>
      <br>
      <br>
      <br>
  </nav>
  </aside>

  <!-- ===== Main Content ===== -->
  <main class="main-content">
    <header class="header">
      <h1><i class="fas fa-warehouse"></i> Stock Levels per Branch</h1>
      <button class="btn-refresh" onclick="location.reload()">
        <i class="fas fa-sync-alt"></i> Refresh
      </button>
    </header>

    <!-- Branch Summary Cards -->
    <section class="branch-summary">
      <div class="summary-card">
        <h3>4</h3>
        <p>Total Branches</p>
      </div>
      <div class="summary-card">
        <h3>470</h3>
        <p>Total Items in Stock</p>
      </div>
      <div class="summary-card">
        <h3>5</h3>
        <p>Low Stock Alerts</p>
      </div>
      <div class="summary-card">
        <h3>2</h3>
        <p>Critical Stock</p>
      </div>
    </section>

    <!-- Table -->
    <section class="table-container">
      <table>
        <thead>
          <tr>
            <th>Branch</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($stock_data as $item): ?>
          <tr>
            <td class="branch-name"><?= htmlspecialchars($item['branch']) ?></td>
            <td><?= htmlspecialchars($item['item']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td>
              <?php
                $status = $item['status'];
                $color = match($status) {
                  "Sufficient" => "#16a34a",
                  "Low Stock" => "#f59e0b",
                  "Critical" => "#dc2626",
                  default => "#64748b"
                };
              ?>
              <span style="color: <?= $color ?>; font-weight: 600;">
                <?= htmlspecialchars($status) ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
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
