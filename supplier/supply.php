<?php
session_start();
$supplier_name = $_SESSION['supplier_name'] ?? 'Supplier';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supply Requests | MEU GearUp</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="supply.css">
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div>
      <div class="logo">
        <i class="ri-motorbike-line"></i>
        <span>MEU GearUp</span>
      </div>
      <nav class="menu">
        <a href="index.php"><i class="ri-dashboard-line"></i> Dashboard</a>
        <a href="supply.php" class="active"><i class="ri-file-list-3-line"></i> Supply Requests</a>
        <a href="delivery.php"><i class="ri-truck-line"></i> Delivery Info</a>
        <a href="orders.php"><i class="ri-shopping-bag-3-line"></i> Orders</a>
        <a href="inquiries.php"><i class="ri-message-3-line"></i> Inquiries</a>
        <a href="logout.php"><i class="ri-logout-box-r-line"></i> Logout</a>
      </nav>

      <div class="theme-toggle">
        <i class="fa-solid fa-sun"></i>
        <i class="fa-solid fa-moon"></i>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content fade-up">
    <div class="topbar">
      <h2>Welcome, <span><?= htmlspecialchars($supplier_name) ?></span></h2>
      <div class="avatar"><img src="https://cdn-icons-png.flaticon.com/512/921/921071.png" alt="Supplier Avatar"></div>
    </div>

    <!-- Supply Requests Section -->
    <section class="dashboard-section fade-in">
      <h3><i class="ri-file-list-3-line"></i> Supply Requests</h3>
      <p class="subtitle">View and manage all supply requests sent by the admin.</p>

      <div class="requests-grid">
        <!-- Request Card 1 -->
        <div class="request-card gradient-blue fade-up">
          <div class="icon"><i class="ri-tools-line"></i></div>
          <h4>Brake Pads</h4>
          <p class="details">Quantity: <strong>50 sets</strong></p>
          <p class="details">Requested by: <strong>Admin</strong></p>
          <span class="status pending"><i class="ri-time-line"></i> Pending Approval</span>
        </div>

        <!-- Request Card 2 -->
        <div class="request-card gradient-green fade-up">
          <div class="icon"><i class="ri-oil-line"></i></div>
          <h4>Engine Oil</h4>
          <p class="details">Quantity: <strong>100 liters</strong></p>
          <p class="details">Requested by: <strong>Admin</strong></p>
          <span class="status approved"><i class="ri-check-line"></i> Approved</span>
        </div>

        <!-- Request Card 3 -->
        <div class="request-card gradient-purple fade-up">
          <div class="icon"><i class="ri-tire-line"></i></div>
          <h4>Tires</h4>
          <p class="details">Quantity: <strong>25 pcs</strong></p>
          <p class="details">Requested by: <strong>Admin</strong></p>
          <span class="status delivered"><i class="ri-truck-line"></i> Delivered</span>
        </div>
      </div>
    </section>
  </main>

  <script>
    // 🌙 Theme Toggle
    const body = document.body;
    const sun = document.querySelector('.fa-sun');
    const moon = document.querySelector('.fa-moon');

    moon.addEventListener('click', () => {
      body.classList.add('dark-mode');
    });

    sun.addEventListener('click', () => {
      body.classList.remove('dark-mode');
    });
  </script>
</body>
</html>
