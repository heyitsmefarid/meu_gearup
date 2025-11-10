<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Sales Summary | MEU Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="branch.css">
  <style>
    .main-content {
      margin-left: 270px;
      padding: 40px;
      background: linear-gradient(135deg, #f8fafc, #e0f2fe);
      min-height: 100vh;
      overflow-y: auto;
    }

    .summary-container {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 30px;
      animation: fadeIn 0.6s ease;
    }

    h1 {
      color: #1e3a8a;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 25px;
    }

    h1 i {
      color: #2563eb;
    }

    .filter-section {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 25px;
      flex-wrap: wrap;
      gap: 10px;
    }

    .filter-section input[type="date"] {
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
      font-size: 0.95rem;
    }

    .btn-filter {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-filter:hover {
      background: #1e40af;
      transform: translateY(-2px);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #e2e8f0;
      font-size: 0.95rem;
    }

    th {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      font-weight: 600;
    }

    tr:hover {
      background: #f1f5f9;
      transition: 0.3s;
    }

    .total-card {
      display: flex;
      justify-content: space-between;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      border-radius: 12px;
      padding: 20px 30px;
      margin-top: 25px;
      font-weight: 600;
    }

    .top-branch {
      margin-top: 30px;
    }

    .top-branch h2 {
      color: #1e3a8a;
      font-size: 1.2rem;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .top-branch ul {
      list-style: none;
      padding: 0;
    }

    .top-branch li {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 12px 15px;
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
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
          <a href="summary.php"class="active">Daily Sales Summary</a>
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
    <div class="summary-container">
      <h1><i class="fas fa-receipt"></i> Daily Sales Summary</h1>

      <div class="filter-section">
        <div>
          <label for="date"><strong>Select Date:</strong></label>
          <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <button class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
      </div>

      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Branch Name</th>
            <th>Total Sales</th>
            <th>Transactions</th>
            <th>Total Discounts</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Main Branch</td>
            <td>₱52,300.00</td>
            <td>48</td>
            <td>₱2,300.00</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Branch 1</td>
            <td>₱41,750.00</td>
            <td>36</td>
            <td>₱1,850.00</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Branch 2</td>
            <td>₱38,600.00</td>
            <td>33</td>
            <td>₱1,200.00</td>
          </tr>
        </tbody>
      </table>

      <div class="total-card">
        <span>Total Branches: <strong>3</strong></span>
        <span>Total Sales: <strong>₱132,650.00</strong></span>
        <span>Total Discounts: <strong>₱5,350.00</strong></span>
      </div>

      <div class="top-branch">
        <h2><i class="fas fa-trophy"></i> Top Performing Branches</h2>
        <ul>
          <li><span>Main Branch</span> <span>₱52,300.00</span></li>
          <li><span>Branch 1</span> <span>₱41,750.00</span></li>
          <li><span>Branch 2</span> <span>₱38,600.00</span></li>
        </ul>
      </div>
    </div>
  </main>
</body>
</html>
