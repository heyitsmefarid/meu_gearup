<?php
// sample inquiries data (replace later with DB fetch)
$inquiries = [
  ["id" => 1, "name" => "John Dela Cruz", "email" => "john@example.com", "subject" => "Adoption Process", "message" => "Hello magkano paayos?", "date" => "Oct 28, 2025"],
  ["id" => 2, "name" => "Maria Santos", "email" => "maria@example.com", "subject" => "Pet Health", "message" => "Need emergency help.", "date" => "Oct 29, 2025"],
  ["id" => 3, "name" => "Carlo Reyes", "email" => "carlo@example.com", "subject" => "Adoption Fee", "message" => "Magkano ang gulong dyan boss", "date" => "Oct 30, 2025"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Response - Inquiries</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="branch.css">
  <style>
   
    /* ===== Main Content ===== */
    .main {
      margin-left: 270px;
      padding: 30px;
      width: calc(100% - 270px);

    }

    h1 {
      font-size: 1.8rem;
      font-weight: 700;
      color: #1e3a8a;
      margin-bottom: 25px;
    }

    .inquiry-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
      gap: 20px;
    }

    .inquiry-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(30, 41, 59, 0.08);
      padding: 20px;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .inquiry-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 24px rgba(30, 41, 59, 0.12);
    }

    .inquiry-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .inquiry-header h3 {
      color: #2563eb;
      font-size: 1.1rem;
      font-weight: 600;
    }

    .inquiry-header span {
      font-size: 0.85rem;
      color: #64748b;
    }

    .inquiry-body {
      margin-bottom: 15px;
    }

    .inquiry-body p {
      font-size: 0.95rem;
      color: #334155;
      margin-bottom: 8px;
    }

    .reply-box {
      margin-top: 10px;
    }

    textarea {
      width: 100%;
      height: 80px;
      padding: 10px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      resize: none;
      font-size: 0.9rem;
    }

    .reply-btn {
      margin-top: 10px;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 16px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .reply-btn:hover {
      background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
      transform: translateY(-2px);
    }

    @media (max-width: 768px) {
      .main {
        margin-left: 0;
        width: 100%;
        padding: 20px;
      }
      .sidebar {
        display: none;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo"><i class="fas fa-tools"></i>Admin Panel</div>
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
          <a href="sales_report.php">Sales Reports (Branch / Consolidated)</a>
        </div>
      </div>
  <a href="response.php" class ="active"><i class="fas fa-envelope"></i> Inquiries</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
      <br>
      <br>
      <br>
      <br>
  </nav>
  </div>

  <!-- Main Content -->
  <div class="main">
    <h1><i class="fas fa-reply"></i> Respond to Inquiries</h1>

    <div class="inquiry-container">
      <?php foreach ($inquiries as $inq): ?>
        <div class="inquiry-card">
          <div class="inquiry-header">
            <h3><?= htmlspecialchars($inq['subject']); ?></h3>
            <span><?= htmlspecialchars($inq['date']); ?></span>
          </div>
          <div class="inquiry-body">
            <p><strong>From:</strong> <?= htmlspecialchars($inq['name']); ?> (<?= htmlspecialchars($inq['email']); ?>)</p>
            <p><strong>Message:</strong> <?= htmlspecialchars($inq['message']); ?></p>
          </div>
          <form class="reply-box" method="POST" action="send_response.php">
            <textarea name="response" placeholder="Type your response..." required></textarea>
            <input type="hidden" name="inquiry_id" value="<?= $inq['id']; ?>">
            <button type="submit" class="reply-btn"><i class="fas fa-paper-plane"></i> Send Reply</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</body>
</html>
