<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Discounts & Payments | MEU Admin</title>
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

    .payments-container {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 30px;
      animation: fadeIn 0.5s ease;
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

    .section-title {
      font-weight: 600;
      font-size: 1.1rem;
      color: #1e40af;
      margin-bottom: 15px;
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #e2e8f0;
      font-size: 0.95rem;
    }

    th {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: white;
      font-weight: 600;
    }

    tr:hover {
      background: #f1f5f9;
      transition: 0.3s;
    }

    .btn {
      border: none;
      border-radius: 8px;
      padding: 8px 14px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-add {
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: #fff;
      margin-bottom: 15px;
    }

    .btn-add:hover {
      background: #15803d;
      transform: translateY(-2px);
    }

    .btn-edit {
      background: #3b82f6;
      color: #fff;
    }

    .btn-edit:hover {
      background: #1e40af;
    }

    .btn-delete {
      background: #ef4444;
      color: #fff;
    }

    .btn-delete:hover {
      background: #991b1b;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }

    .two-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
    }

    @media (max-width: 900px) {
      .two-col {
        grid-template-columns: 1fr;
      }
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
          <a href="payments.php" class = "active">Manage Discounts / Payments</a>
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
    <div class="payments-container">
      <h1><i class="fas fa-credit-card"></i> Manage Discounts & Payment Methods</h1>

      <div class="two-col">
        <!-- Discounts Section -->
        <div>
          <h2 class="section-title">Discounts</h2>
          <button class="btn btn-add"><i class="fas fa-plus"></i> Add Discount</button>
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Discount Name</th>
                <th>Rate</th>
                <th>Valid Until</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Senior Citizen</td>
                <td>20%</td>
                <td>Unlimited</td>
                <td>
                  <button class="btn btn-edit"><i class="fas fa-pen"></i></button>
                  <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Promo - October</td>
                <td>10%</td>
                <td>2025-10-31</td>
                <td>
                  <button class="btn btn-edit"><i class="fas fa-pen"></i></button>
                  <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Payments Section -->
        <div>
          <h2 class="section-title">Payment Methods</h2>
          <button class="btn btn-add"><i class="fas fa-plus"></i> Add Method</button>
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Method Name</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Cash</td>
                <td><span style="color:green; font-weight:600;">Active</span></td>
                <td>
                  <button class="btn btn-edit"><i class="fas fa-pen"></i></button>
                  <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>GCash</td>
                <td><span style="color:green; font-weight:600;">Active</span></td>
                <td>
                  <button class="btn btn-edit"><i class="fas fa-pen"></i></button>
                  <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>Credit Card</td>
                <td><span style="color:#854d0e; font-weight:600;">Disabled</span></td>
                <td>
                  <button class="btn btn-edit"><i class="fas fa-pen"></i></button>
                  <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
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
