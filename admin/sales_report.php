<?php
session_start();
$admin_name = "Admin User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Reports | MEU GearUp</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="branch.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: linear-gradient(135deg, #f8fafc, #e0f2fe);
    }

    .main-content {
      margin-left: 270px;
      padding: 40px;
      min-height: 100vh;
    }

    h1 {
      color: #1e3a8a;
      font-weight: 700;
    }

    h1 span {
      color: #2563eb;
    }

    /* Summary Cards */
    .summary-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 25px;
    }

    .card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 25px;
      text-align: center;
      transition: transform 0.25s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h3 {
      color: #2563eb;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .card i {
      font-size: 2rem;
      color: #1e3a8a;
      margin-bottom: 10px;
    }

    /* Chart Section */
    .chart-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 25px;
      margin: 35px 0;
    }

    .chart-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 25px;
    }

    .chart-card h3 {
      text-align: center;
      color: #1e3a8a;
      margin-bottom: 15px;
    }

    /* Table Section */
    .report-table {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 25px;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #e2e8f0;
      text-align: left;
    }

    th {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: white;
    }

    tr:hover {
      background: #f8fafc;
    }

    .status {
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.85rem;
      display: inline-block;
    }

    .paid { background: #dcfce7; color: #166534; }
    .pending { background: #fef9c3; color: #92400e; }
    .refunded { background: #fee2e2; color: #991b1b; }
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

    @media (max-width: 992px) {
      .chart-container {
        grid-template-columns: 1fr;
      }
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
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
          <a href="task.php">Task Completion Reports</a>
          <a href="activity_logs.php">User Activity Logs</a>
          <a href="mechanics_report.php">Mechanics Repair Reports</a>
          <a href="sales_report.php"class ="active">Sales Reports (Branch / Consolidated)</a>
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
    <h1>💰 Sales <span>Reports</span></h1>
    <p>Track daily, monthly, and consolidated sales performance per branch.</p>

    <!-- Summary Cards -->
    <div class="summary-cards">
      <div class="card">
        <i class="fas fa-peso-sign"></i>
        <h3>Total Sales (Month)</h3>
        <p><strong>₱540,250</strong></p>
      </div>
      <div class="card">
        <i class="fas fa-store"></i>
        <h3>Average Sales per Branch</h3>
        <p><strong>₱135,000</strong></p>
      </div>
      <div class="card">
        <i class="fas fa-trophy"></i>
        <h3>Top Performing Branch</h3>
        <p><strong>Branch 2 (₱165,000)</strong></p>
      </div>
      <div class="card">
        <i class="fas fa-chart-line"></i>
        <h3>Monthly Growth</h3>
        <p><strong>+8.4%</strong></p>
      </div>
    </div>

    <!-- Charts -->
    <div class="chart-container">
      <div class="chart-card">
        <h3>Sales per Branch (This Month)</h3>
        <canvas id="branchSalesChart"></canvas>
      </div>

      <div class="chart-card">
        <h3>Monthly Sales Trend (Consolidated)</h3>
        <canvas id="monthlySalesChart"></canvas>
      </div>
    </div>

    <!-- Table -->
    <div class="report-table">
      <h3><i class="fas fa-receipt"></i> Recent Transactions</h3>
      <table>
        <thead>
          <tr>
            <th>Transaction ID</th>
            <th>Branch</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>#TXN10245</td>
            <td>Main</td>
            <td>John Dela Cruz</td>
            <td>₱2,450</td>
            <td><span class="status paid">Paid</span></td>
            <td>Oct 29, 2025</td>
          </tr>
          <tr>
            <td>#TXN10246</td>
            <td>Branch 2</td>
            <td>Ana Reyes</td>
            <td>₱3,600</td>
            <td><span class="status paid">Paid</span></td>
            <td>Oct 29, 2025</td>
          </tr>
          <tr>
            <td>#TXN10247</td>
            <td>Branch 2</td>
            <td>Pedro Santos</td>
            <td>₱1,850</td>
            <td><span class="status pending">Pending</span></td>
            <td>Oct 30, 2025</td>
          </tr>
          <tr>
            <td>#TXN10248</td>
            <td>Branch 1</td>
            <td>Maria Lopez</td>
            <td>₱5,100</td>
            <td><span class="status refunded">Refunded</span></td>
            <td>Oct 28, 2025</td>
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
    // Sidebar dropdown
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        btn.classList.toggle('active');
        const content = btn.nextElementSibling;
        content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + "px";
      });
    });

    // Chart: Sales per Branch
    const branchCtx = document.getElementById('branchSalesChart');
    new Chart(branchCtx, {
      type: 'bar',
      data: {
        labels: ['Main', 'Branch 1', 'Branch 2'],
        datasets: [{
          label: 'Sales (₱)',
          data: [150000, 120000, 165000, 105000],
          backgroundColor: [
            'rgba(37, 99, 235, 0.9)',
            'rgba(59, 130, 246, 0.9)',
            'rgba(96, 165, 250, 0.9)'
           
          ],
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true },
          x: { grid: { display: false } }
        }
      }
    });

    // Chart: Monthly Sales Trend
    const monthlyCtx = document.getElementById('monthlySalesChart');
    new Chart(monthlyCtx, {
      type: 'line',
      data: {
        labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        datasets: [{
          label: 'Total Sales (₱)',
          data: [420000, 460000, 490000, 510000, 520000, 540000],
          borderColor: 'rgba(37, 99, 235, 0.9)',
          backgroundColor: 'rgba(191, 219, 254, 0.4)',
          tension: 0.4,
          fill: true,
          borderWidth: 3,
          pointRadius: 5,
          pointBackgroundColor: '#2563eb'
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: false } }
      }
    });
  </script>
</body>
</html>
