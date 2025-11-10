<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Sale | POS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="branch.css">
  <style>
 
    .sales-container {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(30, 41, 59, 0.08);
      padding: 30px;
      animation: fadeIn 0.5s ease;
      width: 100%;
      max-width: 900px;
      margin: 0 auto;
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

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: 600;
      color: #334155;
      display: block;
      margin-bottom: 6px;
    }

    select, input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      font-size: 0.95rem;
      outline: none;
      transition: border-color 0.3s;
    }

    select:focus, input:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 2px rgba(37,99,235,0.15);
    }

    .sales-table {
      margin-top: 20px;
      width: 100%;
      border-collapse: collapse;
    }

    .sales-table th, .sales-table td {
      padding: 12px;
      border-bottom: 1px solid #e2e8f0;
      text-align: left;
    }

    .sales-table th {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
    }

    .add-item-btn {
      margin-top: 10px;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 10px 15px;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
    }

    .add-item-btn:hover {
      background: #1e40af;
      transform: translateY(-2px);
    }

    .summary {
      background: #f1f5f9;
      border-radius: 12px;
      padding: 20px;
      margin-top: 25px;
      text-align: right;
    }

    .summary h3 {
      color: #1e3a8a;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .summary p {
      font-size: 1.2rem;
      color: #2563eb;
      font-weight: 700;
    }

    .checkout-btn {
      background: linear-gradient(135deg, #22c55e, #15803d);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 12px 20px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .checkout-btn:hover {
      background: #15803d;
      transform: translateY(-2px);
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
      <i class="fas fa-wrench"></i>
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
            <a href="emergency.php">Emergency Assign</a>
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
          <a href="branch_sales.php" class = "active" >Sales (per Branch)</a>
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
    <div class="sales-container">
      <h1><i class="fas fa-cash-register"></i> Create New Sale</h1>

      <form>
        <div class="form-group">
          <label for="branch">Select Branch</label>
          <select id="branch" name="branch">
            <option>Main Branch</option>
            <option>Branch 1</option>
            <option>Branch 2</option>
            <option>Branch 3</option>
          </select>
        </div>

        <div class="form-group">
          <label for="item">Select Item</label>
          <select id="item" name="item">
            <option>Brake Pads</option>
            <option>Engine Oil</option>
            <option>Air Filter</option>
          </select>
        </div>

        <div class="form-group">
          <label for="quantity">Quantity</label>
          <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" min="1" value="1">
        </div>

        <button type="button" class="add-item-btn"><i class="fas fa-plus"></i> Add Item</button>

        <table class="sales-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Item Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Brake Pads</td>
              <td>2</td>
              <td>₱850.00</td>
              <td>₱1,700.00</td>
              <td><button class="delete-btn"><i class="fas fa-trash"></i></button></td>
            </tr>
          </tbody>
        </table>

        <div class="summary">
          <h3>Grand Total:</h3>
          <p>₱1,700.00</p>
          <button class="checkout-btn"><i class="fas fa-credit-card"></i> Checkout</button>
        </div>
      </form>
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
