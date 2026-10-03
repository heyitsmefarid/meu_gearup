<?php
session_start();
$supplier_name = $_SESSION['supplier_name'] ?? 'Supplier';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supplier Dashboard</title>

  <!-- Remix Icons + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0e6a0aa.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="index.css">
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
        <a href="index.php" class="active"><i class="ri-dashboard-line"></i> Dashboard</a>
        <a href="supply.php"><i class="ri-file-list-3-line"></i> Supply Requests</a>
        <a href="delivery.php"><i class="ri-truck-line"></i> Delivery Info</a>
        <a href="orders.php"><i class="ri-shopping-bag-3-line"></i> Orders</a>
        <a href="inquiries.php"><i class="ri-message-3-line"></i> Inquiries</a>
        <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>

        
      </nav>
  <div class="theme-toggle">
        <i class="fa-solid fa-sun"></i>
        <i class="fa-solid fa-moon"></i>
      </div>
      <!-- Theme Toggle (inside sidebar) -->
    
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content fade-up">
    <div class="topbar">
      <h2>Welcome, <span><?= htmlspecialchars($supplier_name) ?></span></h2>
      <div class="avatar">
        <img src="https://cdn-icons-png.flaticon.com/512/921/921071.png" alt="Supplier Avatar">
      </div>
    </div>

    <section class="dashboard-section fade-in">
      <h3><i class="ri-dashboard-line"></i> Dashboard Overview</h3>
      <p class="subtitle">Quick summary of your supply operations.</p>

      <div class="card-grid">
        <div class="card gradient-blue">
          <div class="icon"><i class="ri-file-list-3-line"></i></div>
          <h4>Pending Requests</h4>
          <p class="count" data-target="3">0</p>
          <p class="desc">Awaiting confirmation</p>
        </div>

        <div class="card gradient-green">
          <div class="icon"><i class="ri-truck-line"></i></div>
          <h4>Deliveries</h4>
          <p class="count" data-target="2">0</p>
          <p class="desc">Scheduled this week</p>
        </div>

        <div class="card gradient-purple">
          <div class="icon"><i class="ri-shopping-bag-3-line"></i></div>
          <h4>Completed Orders</h4>
          <p class="count" data-target="5">0</p>
          <p class="desc">This month</p>
        </div>
      </div>
    </section>
  </main>

  <script>
    // === Theme Toggle ===
    const sun = document.querySelector('.fa-sun');
    const moon = document.querySelector('.fa-moon');
    const body = document.body;

    const setTheme = (theme) => {
      if (theme === 'dark') {
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
      } else {
        body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
      }
    };

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);

    // Toggle logic
    sun.addEventListener('click', () => setTheme('light'));
    moon.addEventListener('click', () => setTheme('dark'));

    // === Animated Counters ===
    const counters = document.querySelectorAll('.count');
    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;
        const speed = 200;

        const increment = target / speed;
        if (count < target) {
          counter.innerText = Math.ceil(count + increment);
          setTimeout(updateCount, 15);
        } else {
          counter.innerText = target;
        }
      };
      updateCount();
    });
  </script>
</body>
</html>
