<?php
session_start();
$admin_name = "Admin User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Completion Reports | MEU GearUp</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="branch.css">
  <script src="https://cdn.jsdelivr.net/snpm/chart.js"></script>
  <style>
    .main-content {
      margin-left: 270px;
      padding: 40px;
      background: linear-gradient(135deg, #f8fafc, #e0f2fe);
      min-height: 100vh;
      overflow-y: auto;
    }

    h1 {
      color: #1e3a8a;
      font-weight: 700;
    }

    h1 span {
      color: #2563eb;
    }

    .filter-bar {
      margin: 25px 0;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    select {
      padding: 10px 15px;
      border-radius: 10px;
      border: 1px solid #93c5fd;
      font-size: 0.95rem;
      color: #1e3a8a;
      outline: none;
    }

    /* ===== Summary Cards ===== */
    .summary-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .summary-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 20px;
      text-align: center;
      transition: 0.3s ease;
    }

    .summary-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
    }

    .summary-card h3 {
      color: #1e3a8a;
      margin-bottom: 5px;
    }

    .summary-card p {
      color: #475569;
      font-size: 0.9rem;
    }

    /* ===== Chart Section ===== */
    .chart-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 25px;
      margin-bottom: 40px;
    }

    .chart-card h3 {
      color: #1e3a8a;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }

    /* ===== Mechanics Table ===== */
    .mechanic-report {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 25px;
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

    .progress {
      background: #e2e8f0;
      border-radius: 12px;
      overflow: hidden;
      height: 12px;
      width: 100%;
    }

    .progress-bar {
      height: 100%;
      transition: width 0.5s ease;
      border-radius: 12px;
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

    .progress-bar.blue { background: #2563eb; }
    .progress-bar.green { background: #16a34a; }
    .progress-bar.orange { background: #f59e0b; }

    tr:hover {
      background: #f8fafc;
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
          <a href="inventory.php">Inventory Reports (per Branch / Overall)</a>
          <a href="task.php"class="active">Task Completion Reports</a>
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
    <h1>🧰 Task Completion <span>Reports</span></h1>
    <p>Track mechanic performance, task trends, and branch productivity.</p>

    <!-- Filter -->
    <div class="filter-bar">
      <label for="branch">Filter by Branch:</label>
      <select id="branch">
        <option>Main Branch</option>
        <option>Branch 1</option>
        <option>Branch 2</option>
     
      </select>
    </div>

    <!-- Summary Cards -->
    <section class="summary-grid">
      <div class="summary-card">
        <h3>🧑‍🔧 Total Mechanics</h3>
        <p><strong>18</strong></p>
      </div>
      <div class="summary-card">
        <h3>✅ Tasks Completed</h3>
        <p><strong>324</strong> this week</p>
      </div>
      <div class="summary-card">
        <h3>⚙️ Ongoing Repairs</h3>
        <p><strong>15</strong> in progress</p>
      </div>
      <div class="summary-card">
        <h3>🏆 Best Performer</h3>
        <p><strong>Rico Dela Cruz</strong> (42 tasks)</p>
      </div>
    </section>

    <!-- Chart Section -->
    <div class="chart-card">
      <h3>Weekly Task Completion Trend</h3>
      <canvas id="taskChart"></canvas>
    </div>

    <!-- Mechanics Table -->
    <div class="mechanic-report">
      <h3><i class="fas fa-list-check"></i> Mechanic Task Performance</h3>
      <table>
        <thead>
          <tr>
            <th>Mechanic Name</th>
            <th>Branch</th>
            <th>Tasks Completed</th>
            <th>Performance</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Rico Dela Cruz</td><td>Main</td><td>42</td>
            <td><div class="progress"><div class="progress-bar green" style="width: 95%"></div></div></td>
            <td>Excellent</td>
          </tr>
          <tr>
            <td>Joel Fernandez</td><td>Branch 1</td><td>37</td>
            <td><div class="progress"><div class="progress-bar blue" style="width: 85%"></div></div></td>
            <td>Very Good</td>
          </tr>
          <tr>
            <td>Carlo Reyes</td><td>Branch 2</td><td>28</td>
            <td><div class="progress"><div class="progress-bar orange" style="width: 65%"></div></div></td>
            <td>Good</td>
          </tr>
          <tr>
            <td>Mark Villanueva</td><td>Branch 1</td><td>22</td>
            <td><div class="progress"><div class="progress-bar blue" style="width: 55%"></div></div></td>
            <td>Average</td>
          </tr>
          <tr>
            <td>Leo Santos</td><td>Main</td><td>18</td>
            <td><div class="progress"><div class="progress-bar orange" style="width: 40%"></div></div></td>
            <td>Needs Improvement</td>
          </tr>
        </tbody>
      </table>
    </div>
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

    // Weekly Task Chart
    const ctx = document.getElementById('taskChart');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
          label: 'Tasks Completed',
          data: [42, 38, 50, 47, 56, 35, 40],
          borderColor: '#2563eb',
          backgroundColor: 'rgba(37, 99, 235, 0.2)',
          tension: 0.3,
          fill: true,
          borderWidth: 3,
          pointBackgroundColor: '#1e3a8a'
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</body>
</html>
