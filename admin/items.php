<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Items | Admin Panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="items.css">
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
          <a href="items.php" class = "acive" >Add / Update / Delete Items</a>
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
    <div class="header">
      <h1><i class="fa-solid fa-boxes-stacked"></i> Manage Inventory Items</h1>
      <button class="btn-add"><i class="fa-solid fa-plus"></i> Add New Item</button>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Branch</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Brake Pads</td>
            <td>Auto Parts</td>
            <td>45</td>
            <td>Main Branch</td>
            <td>₱850.00</td>
            <td class="action-btns">
              <button class="edit-btn"><i class="fa-solid fa-pen"></i></button>
              <button class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Engine Oil</td>
            <td>Lubricant</td>
            <td>120</td>
            <td>Branch 1</td>
            <td>₱550.00</td>
            <td class="action-btns">
              <button class="edit-btn"><i class="fa-solid fa-pen"></i></button>
              <button class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>Air Filter</td>
            <td>Engine Component</td>
            <td>80</td>
            <td>Branch 2</td>
            <td>₱320.00</td>
            <td class="action-btns">
              <button class="edit-btn"><i class="fa-solid fa-pen"></i></button>
              <button class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    // Sidebar dropdown toggle logic
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
