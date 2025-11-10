<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Details | MEU Admin</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="indec.css">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="fas fa-users-cog"></i>
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
          <a href="user.php"class="active">View User Details</a>
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
      <h1><i class="fas fa-users"></i> User Details</h1>
      <p>Overview of all registered users, their roles, and branch assignments.</p>
    </header>

    <!-- Search Bar -->
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search user...">
      <i class="fas fa-search"></i>
    </div>

    <!-- Users Table -->
    <section class="user-table">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Branch</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="userTable">
          <tr>
            <td>1</td>
            <td>Farid Dela Cruz</td>
            <td>farid.mechanic@gmail.com</td>
            <td><span class="role mechanic">Mechanic</span></td>
            <td>Main Branch</td>
            <td><span class="status active">Active</span></td>
            <td class="actions">
              <button class="btn-view"><i class="fas fa-eye"></i></button>
              <button class="btn-edit"><i class="fas fa-edit"></i></button>
              <button class="btn-delete"><i class="fas fa-trash-alt"></i></button>
            </td>
          </tr>

          <tr>
            <td>2</td>
            <td>Jessa Ramos</td>
            <td>jessa.supplier@gmail.com</td>
            <td><span class="role supplier">Supplier</span></td>
            <td>Branch 1</td>
            <td><span class="status active">Active</span></td>
            <td class="actions">
              <button class="btn-view"><i class="fas fa-eye"></i></button>
              <button class="btn-edit"><i class="fas fa-edit"></i></button>
              <button class="btn-delete"><i class="fas fa-trash-alt"></i></button>
            </td>
          </tr>

        
        </tbody>
      </table>
    </section>
  </main>

  <script>
    // 🔍 Simple search filter
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#userTable tr');
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
      });
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
