<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Roles | MEU Admin</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
 <link rel="stylesheet" href="indec.css">
 <style>
    
    /* ===== Table ===== */
    .roles-table table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(30,41,59,0.08);
      animation: fadeUp 0.6s ease;
    }

    .roles-table th {
      background: linear-gradient(135deg, #1e3a8a, #2563eb);
      color: #fff;
      text-align: left;
      padding: 12px;
      font-weight: 600;
    }

    .roles-table td {
      padding: 12px;
      color: #334155;
      border-bottom: 1px solid #e2e8f0;
    }

    .roles-table tr:hover {
      background: #f1f5f9;
      transition: 0.2s ease;
    }

    /* ===== Role Select ===== */
    select {
      padding: 6px 10px;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
      background: #fff;
      font-size: 0.9rem;
      color: #1e3a8a;
      font-weight: 600;
      transition: 0.3s ease;
    }

    select:focus {
      border-color: #2563eb;
      box-shadow: 0 0 6px rgba(37,99,235,0.3);
      outline: none;
    }

    /* ===== Buttons ===== */
    .actions {
      display: flex;
      gap: 8px;
    }

    .btn-save, .btn-cancel {
      border: none;
      border-radius: 8px;
      padding: 6px 12px;
      cursor: pointer;
      font-size: 0.9rem;
      transition: 0.3s ease;
    }

    .btn-save {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
    }

    .btn-save:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
    }

    .btn-cancel {
      background: #f3f4f6;
      color: #334155;
    }

    .btn-cancel:hover {
      background: #e2e8f0;
    }

    /* ===== Animations ===== */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="fas fa-user-shield"></i>
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
          <a href="roles.php"class = "active">Manage Roles (Supplier, Mechanic)</a>
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
      <h1><i class="fas fa-user-cog"></i> Manage Roles</h1>
      <p>Assign and update user roles (Supplier, Mechanic) for system management.</p>
    </header>

    <!-- Roles Table -->
    <section class="roles-table">
      <table>
        <thead>
          <tr>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Current Role</th>
            <th>Change Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Farid Dela Cruz</td>
            <td>farid.mechanic@gmail.com</td>
            <td><span style="color:#2563eb; font-weight:600;">Mechanic</span></td>
            <td>
              <select>
                <option selected>Mechanic</option>
                <option>Supplier</option>
              </select>
            </td>
            <td class="actions">
              <button class="btn-save"><i class="fas fa-save"></i> Save</button>
              <button class="btn-cancel"><i class="fas fa-times"></i> Cancel</button>
            </td>
          </tr>

          <tr>
            <td>2</td>
            <td>Jessa Ramos</td>
            <td>jessa.supplier@gmail.com</td>
            <td><span style="color:#ca8a04; font-weight:600;">Supplier</span></td>
            <td>
              <select>
                <option selected>Supplier</option>
                <option>Mechanic</option>
              </select>
            </td>
            <td class="actions">
              <button class="btn-save"><i class="fas fa-save"></i> Save</button>
              <button class="btn-cancel"><i class="fas fa-times"></i> Cancel</button>
            </td>
          </tr>

          <tr>
            <td>3</td>
            <td>Leo Santiago</td>
            <td>leo.mechanic@gmail.com</td>
            <td><span style="color:#475569; font-weight:600;">Mechanic</span></td>
            <td>
              <select>
           
                <option>Mechanic</option>
                <option>Supplier</option>
              </select>
            </td>
            <td class="actions">
              <button class="btn-save"><i class="fas fa-save"></i> Save</button>
              <button class="btn-cancel"><i class="fas fa-times"></i> Cancel</button>
            </td>
          </tr>
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
