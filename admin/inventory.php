<?php
session_start();
$admin_name = "Admin User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Reports | MEU GearUp</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="branch.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .main-content {
      margin-left: 270px;
      padding: 40px;
      background: linear-gradient(135deg, #f8fafc, #e0f2fe);
      min-height: 100vh;
      overflow-y: auto;
    }

    .dashboard-header h1 {
      color: #1e3a8a;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .dashboard-header span {
      color: #2563eb;
    }

    /* ===== Branch Summary Cards ===== */
    .branch-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      margin: 30px 0;
    }

    .branch-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 20px;
      text-align: center;
      transition: 0.3s ease;
    }

    .branch-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
    }

    .branch-card h3 {
      color: #1e3a8a;
      margin-bottom: 10px;
    }

    .branch-card p {
      font-size: 0.95rem;
      color: #475569;
    }

    /* ===== Charts Section ===== */
    .charts-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
      gap: 25px;
      margin-bottom: 40px;
    }

    .chart-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 25px;
      animation: fadeIn 0.6s ease;
    }

    .chart-card h3 {
      color: #1e3a8a;
      margin-bottom: 15px;
      font-weight: 700;
      text-align: center;
    }

    /* ===== Inventory Table ===== */
    .inventory-table {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 25px;
      animation: fadeIn 0.6s ease;
    }

    .inventory-table h3 {
      color: #1e3a8a;
      margin-bottom: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #e2e8f0;
      font-size: 0.95rem;
    }

    th {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
    }

    tr:hover {
      background: #f8fafc;
    }
.export-buttons {
  display: flex;
  gap: 10px;
}

.export-btn {
  background: linear-gradient(135deg, #2563eb, #1e3a8a);
  color: white;
  border: none;
  border-radius: 10px;
  padding: 10px 16px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}

.export-btn i {
  margin-right: 8px;
}

.export-btn:hover {
  background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
  transform: translateY(-3px);
}

.export-btn.pdf {
  background: linear-gradient(135deg, #dc2626, #b91c1c);
}

.export-btn.excel {
  background: linear-gradient(135deg, #16a34a, #15803d);
}

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }
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
          <a href="inventory.php" class = "active">Inventory Reports (per Branch / Overall)</a>
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
      <h1>📦 Inventory Reports <span>(Per Branch)</span></h1>
      <p>Get a detailed view of inventory stock, trends, and branch performance.</p>
    </header>

    <!-- Branch Summary -->
    <section class="branch-grid">
      <div class="branch-card">
        <h3>Main Branch</h3>
        <p><strong>Items:</strong> 420</p>
        <p><strong>Low Stock:</strong> 12</p>
        <p><strong>Last Updated:</strong> Today</p>
      </div>
      <div class="branch-card">
        <h3>Branch 1</h3>
        <p><strong>Items:</strong> 310</p>
        <p><strong>Low Stock:</strong> 8</p>
        <p><strong>Last Updated:</strong> 2 hrs ago</p>
      </div>
      <div class="branch-card">
        <h3>Branch 2</h3>
        <p><strong>Items:</strong> 285</p>
        <p><strong>Low Stock:</strong> 5</p>
        <p><strong>Last Updated:</strong> Yesterday</p>
      </div>
  
    </section>

    <!-- Charts -->
    <section class="charts-container">
      <div class="chart-card">
        <h3>Stock Levels Comparison</h3>
        <canvas id="stockChart"></canvas>
      </div>

      <div class="chart-card">
        <h3>Category Distribution (Main Branch)</h3>
        <canvas id="categoryChart"></canvas>
      </div>
    </section>

    <!-- Inventory Table -->
    <section class="inventory-table">
      <h3><i class="fas fa-list"></i> Top Inventory Items </h3>
      <table>
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Last Restocked</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Engine Oil</td><td>Lubricants</td><td>120</td><td>Available</td><td>2025-10-29</td></tr>
          <tr><td>Brake Pads</td><td>Brakes</td><td>45</td><td>Low</td><td>2025-10-27</td></tr>
          <tr><td>Air Filters</td><td>Filters</td><td>60</td><td>Available</td><td>2025-10-25</td></tr>
          <tr><td>Transmission Fluid</td><td>Fluids</td><td>30</td><td>Low</td><td>2025-10-23</td></tr>
          <tr><td>Wiper Blades</td><td>Accessories</td><td>80</td><td>Available</td><td>2025-10-22</td></tr>
        </tbody>
      </table>
    </section>
       <div class="report-table">
  <div style="display: flex; justify-content: space-between; align-items: center;">

    <div class="export-buttons">
      <form method="POST" action="export_sales.php" style="display: inline;">
        <input type="hidden" name="export_type" value="pdf">
        <button type="submit" class="export-btn pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
      </form>
      <form method="POST" action="export_sales.php" style="display: inline;">
        <input type="hidden" name="export_type" value="excel">
        <button type="submit" class="export-btn excel"><i class="fas fa-file-excel"></i> Export Excel</button>
      </form>
    </div>
  </div>
  </main>

  <script>
    // Sidebar dropdown toggle
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        btn.classList.toggle('active');
        const content = btn.nextElementSibling;
        content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + "px";
      });
    });

    // Stock Level Chart
    const stockCtx = document.getElementById('stockChart');
    new Chart(stockCtx, {
      type: 'bar',
      data: {
        labels: ['Main', 'Branch 1', 'Branch 2', ],
        datasets: [{
          label: 'Total Items',
          data: [420, 310, 285, 215],
          backgroundColor: ['#2563eb', '#1e40af', '#3b82f6'],
          borderRadius: 8
        }]
      },
      options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Category Pie Chart
    const catCtx = document.getElementById('categoryChart');
    new Chart(catCtx, {
      type: 'pie',
      data: {
        labels: ['Lubricants', 'Filters', 'Brakes', 'Fluids', 'Accessories'],
        datasets: [{
          data: [30, 25, 20, 15, 10],
          backgroundColor: ['#2563eb', '#1e40af', '#3b82f6', '#60a5fa', '#93c5fd']
        }]
      },
      options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
  </script>
</body>
</html>
