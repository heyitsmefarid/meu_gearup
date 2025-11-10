<?php
session_start();
require_once '../db_connect.php';
$conn = connectDB();

// ✅ Check user login
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user's "In Progress" booked services only
$stmt = $conn->prepare("
  SELECT * 
  FROM repair_tbl 
  WHERE user_id = :user_id 
  AND repair_status = 'In Progress'
  ORDER BY created_at DESC
");
$stmt->execute([':user_id' => $user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book a Service | MEU GearUp</title>
  <link rel="stylesheet" href="book.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <i class="ri-motorbike-line"></i>
      <span>MEU GearUp</span>
    </div>
    <nav class="menu">
      <a href="index.php"><i class="ri-dashboard-line"></i> Dashboard</a>
      <a href="book.php" class="active"><i class="fa-solid fa-wrench"></i> Book Services</a>
      <a href="browse.php"><i class="ri-shopping-bag-3-line"></i> Browse Parts</a>
      <a href="repairs.php"><i class="ri-tools-line"></i> My Repairs</a>
      <a href="emergency.php"><i class="ri-map-pin-line"></i> Roadside Request</a>
      <a href="inquiry.php"><i class="ri-message-3-line"></i> Inquiries</a>
      <a href="profile.php"><i class="ri-user-line"></i> Profile</a>
      <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
    </nav>
    <div class="theme-toggle">
      <i class="fa-solid fa-sun"></i>
      <i class="fa-solid fa-moon"></i>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="topbar fade-in">
      <h2><span>Book</span> a Service</h2>
      <div class="avatar">
        <img src="assets/img/avatar.jpg" alt="User">
      </div>
    </div>

    <!-- Booking Form -->
    <section class="booking-section fade-up delay-2">
      <h3><i class="fa-solid fa-calendar-check"></i> Schedule Your Repair Service</h3>
      <p class="subtitle">Choose the type of service and select your preferred date & time.</p>

      <form id="bookingForm" class="booking-form" method="POST">
        <div class="form-group">
          <label for="vehicle_model"><i class="fa-solid fa-motorcycle"></i> Vehicle Model</label>
          <input type="text" id="vehicle_model" name="vehicle_model" placeholder="Enter your vehicle model" required>
        </div>

        <div class="form-group">
          <label for="service_type"><i class="fa-solid fa-tools"></i> Service Type</label>
          <select name="service_type" id="service_type" required>
            <option value="" disabled selected>Select a Service</option>
            <option value="engine">Engine Repair</option>
            <option value="electrical">Electrical Diagnosis</option>
            <option value="tire">Tire Replacement</option>
            <option value="maintenance">General Maintenance</option>
          </select>
        </div>

        <div class="form-group">
          <label for="issue_description"><i class="fa-solid fa-note-sticky"></i> Issue Description</label>
          <textarea id="issue_description" name="issue_description" placeholder="Describe the issue..." rows="3"></textarea>
        </div>

        <div class="form-group">
          <label for="repair_date"><i class="fa-solid fa-calendar-day"></i> Date</label>
          <input type="date" id="repair_date" name="repair_date" required>
        </div>

        <div class="form-group">
          <label for="repair_time"><i class="fa-solid fa-clock"></i> Time</label>
          <input type="time" id="repair_time" name="repair_time" required>
        </div>

        <button type="submit" class="btn-submit"><i class="fa-solid fa-check"></i> Confirm Booking</button>
      </form>
    </section>

    <!-- Booked Services - Only In Progress -->
    <section class="booked-list fade-up delay-4">
      <h3><i class="fa-solid fa-list"></i> Your Booked Services (In Progress)</h3>

      <div class="booked-grid">
        <?php if (count($bookings) > 0): ?>
          <?php foreach ($bookings as $b): ?>
            <div class="booked-card">
              <i class="fa-solid fa-screwdriver-wrench icon"></i>
              <h4><?= htmlspecialchars(ucwords($b['service_type'])) ?></h4>
              <p><strong>Vehicle:</strong> <?= htmlspecialchars($b['vehicle_model']) ?></p>
              <p><strong>Date:</strong> <?= htmlspecialchars(date("F j, Y", strtotime($b['repair_date']))) ?></p>
              <p><strong>Time:</strong> <?= htmlspecialchars(date("g:i A", strtotime($b['repair_time']))) ?></p>
              <span class="status in-progress"><?= htmlspecialchars($b['repair_status']) ?></span>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="no-bookings">You have no ongoing repair services right now.</p>
        <?php endif; ?>
      </div>
    </section>
  </div>

  <script>
  document.getElementById('bookingForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    const response = await fetch('../backend/submit_book.php', {
      method: 'POST',
      body: formData
    });

    const result = await response.json();

    if (result.status === 'success') {
      Swal.fire({
        icon: 'success',
        title: 'Booking Successful!',
        text: result.message,
        confirmButtonColor: '#3085d6'
      }).then(() => {
        window.location.reload(); // refresh page to show new booking
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Booking Failed!',
        text: result.message,
        confirmButtonColor: '#d33'
      });
    }
  });
  </script>
</body>
</html>
