<?php
session_start();

// Example branch performance data (replace with DB data)
$branch_performance = [
  ["branch" => "Main Branch", "sales" => 152000, "repairs" => 45, "inventory" => 350, "rating" => 4.8],
  ["branch" => "Masipit", "sales" => 98000, "repairs" => 30, "inventory" => 280, "rating" => 4.5],
  ["branch" => "Baco", "sales" => 67000, "repairs" => 25, "inventory" => 200, "rating" => 4.2],
 
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Branch Performance | MEU Admin</title>
  <link rel="stylesheet" href="indec.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="fas fa-chart-line"></i>
      <span>MEU Admin</span>
    </div>

   <nav class="menu">
      <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>

      <!-- Multi-Branch Control Panel -->
      <div class="dropdown">
        <button class="dropdown-btn"><i class="fas fa-building"></i> Multi-Branch Control <i class="fas fa-chevron-down"></i></button>
        <div class="dropdown-content">
          <a href="view.php">View All Branches</a>
         
          <a href="performance.php"class="active">View Branch Performance</a>
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
      <a href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a>
      <br>
      <br>
      <br>
      <br>
  </nav>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <header class="dashboard-header">
      <h1><i class="fas fa-chart-line"></i> Branch Performance Summary</h1>
      <p>Visual insights and metrics for each branch.</p>
    </header>

    <!-- Branch Summary Cards -->
    <section class="performance-cards">
      <?php foreach ($branch_performance as $branch): ?>
      <div class="perf-card fade-up">
        <h3><i class="fas fa-store"></i> <?= htmlspecialchars($branch['branch']) ?></h3>
        <p><strong>Sales:</strong> ₱<?= number_format($branch['sales'], 2) ?></p>
        <p><strong>Repairs Done:</strong> <?= $branch['repairs'] ?></p>
        <p><strong>Inventory Count:</strong> <?= $branch['inventory'] ?></p>
        <div class="rating">
          <i class="fas fa-star"></i> <?= number_format($branch['rating'], 1) ?>
        </div>
      </div>
      <?php endforeach; ?>
    </section>

    <!-- Chart Section -->
    <section class="chart-section fade-up">
      <h2><i class="fas fa-chart-bar"></i> Sales Overview</h2>
      <canvas id="salesChart"></canvas>
    </section>
  </main>

  <script>
    // Chart.js setup
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode(array_column($branch_performance, 'branch')) ?>,
        datasets: [{
          label: 'Total Sales (₱)',
          data: <?= json_encode(array_column($branch_performance, 'sales')) ?>,
          backgroundColor: ['#2563eb', '#1e40af', '#3b82f6', '#60a5fa'],
          borderRadius: 12
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: { backgroundColor: '#1e3a8a', color: '#fff' }
        },
        scales: {
          y: { beginAtZero: true, ticks: { color: '#1e3a8a' } },
          x: { ticks: { color: '#1e3a8a' } }
        }
      }
    });
  </script>
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
