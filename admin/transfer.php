<?php
session_start();

// Sample data for items and branches
$branches = ["Main Branch", "Branch 1", "Branch 2", "Branch 3"];
$items = [
  ["id" => 1, "name" => "Engine Oil", "available" => 150, "branch" => "Main Branch"],
  ["id" => 2, "name" => "Brake Pads", "available" => 80, "branch" => "Branch 1"],
  ["id" => 3, "name" => "Air Filter", "available" => 60, "branch" => "Branch 2"],
  ["id" => 4, "name" => "Coolant", "available" => 40, "branch" => "Branch 3"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transfer Items | MEU Admin</title>
  <link rel="stylesheet" href="transfer.css">
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
          <a href="stock.php">View Stock Levels (per Branch)</a>
          <a href="transfer.php"class="active">Transfer Items Between Branches</a>
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
      <h1><i class="fas fa-exchange-alt"></i> Transfer Items Between Branches</h1>
    </header>

    <!-- Transfer Form -->
    <section class="transfer-section">
      <form class="transfer-form">
        <div class="form-group">
          <label for="item">Select Item</label>
          <select id="item" required>
            <option value="">-- Choose Item --</option>
            <?php foreach ($items as $item): ?>
              <option><?= htmlspecialchars($item['name']) ?> (<?= htmlspecialchars($item['branch']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="from">From Branch</label>
            <select id="from" required>
              <option value="">-- Select Source Branch --</option>
              <?php foreach ($branches as $b): ?>
                <option><?= htmlspecialchars($b) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="to">To Branch</label>
            <select id="to" required>
              <option value="">-- Select Destination Branch --</option>
              <?php foreach ($branches as $b): ?>
                <option><?= htmlspecialchars($b) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="quantity">Quantity to Transfer</label>
          <input type="number" id="quantity" min="1" placeholder="Enter quantity" required>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-transfer"><i class="fas fa-paper-plane"></i> Transfer Item</button>
          <button type="reset" class="btn-reset"><i class="fas fa-rotate-right"></i> Reset</button>
        </div>
      </form>
    </section>

    <!-- Recent Transfers -->
    <section class="table-container">
      <h2><i class="fas fa-clock"></i> Recent Transfers</h2>
      <table>
        <thead>
          <tr>
            <th>Item</th>
            <th>From</th>
            <th>To</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Engine Oil</td>
            <td>Main Branch</td>
            <td>Branch 2</td>
            <td>20</td>
            <td>2025-10-29</td>
            <td><span class="status success">Completed</span></td>
          </tr>
          <tr>
            <td>Brake Pads</td>
            <td>Branch 1</td>
            <td>Branch 3</td>
            <td>10</td>
            <td>2025-10-27</td>
            <td><span class="status pending">Pending</span></td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>

  <script>
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        btn.classList.toggle('active');
        const content = btn.nextElementSibling;
        content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + "px";
      });
    });
  </script>
</body>
</html>
