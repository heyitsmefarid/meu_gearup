<?php
session_start();
require_once '../db_connect.php';
$conn = connectDB();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emergency Roadside Request | MEU GearUp</title>

  <link rel="stylesheet" href="emergency.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div>
      <div class="logo">
        <i class="ri-tools-line"></i>
        <span>MEU GearUp</span>
      </div>

      <nav class="menu">
        <a href="index.php"><i class="ri-dashboard-line"></i> Dashboard</a>
        <a href="book.php"><i class="fa-solid fa-wrench"></i> Book Services</a>
        <a href="browse.php"><i class="ri-shopping-bag-3-line"></i> Browse Parts</a>
        <a href="repairs.php"><i class="ri-tools-line"></i> My Repairs</a>
        <a href="emergency.php" class="active"><i class="ri-map-pin-line"></i> Roadside Request</a>
        <a href="inquiry.php"><i class="ri-message-3-line"></i> Inquiries</a>
        <a href="profile.php"><i class="ri-user-line"></i> Profile</a>
        <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
      </nav>
    </div>

    <div class="theme-toggle">
      <i class="ri-sun-line" id="theme-sun"></i>
      <i class="ri-moon-line" id="theme-moon"></i>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <div class="topbar">
      <h2><span>Emergency</span> Roadside Request</h2>
      <div class="avatar">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User Avatar">
      </div>
    </div>

    <section class="emergency-section fade-up">
      <h3><i class="ri-alert-line"></i> Request Roadside Assistance</h3>
      <p class="subtitle">Share your location and request immediate help from our nearest mechanic.</p>

      <div class="emergency-card fade-in">
        <div class="map-container" id="map">
          <p>Fetching your location...</p>
        </div>

        <form id="emergencyForm" class="emergency-form">
          <label for="issue">Describe Your Issue:</label>
          <textarea id="issue" name="issue" rows="3" placeholder="E.g. Flat tire, engine won't start..." required></textarea>

          <label for="location">Your Location:</label>
          <input type="text" id="location" name="location" readonly required>

          <!-- Hidden fields for lat/lon -->
          <input type="hidden" id="latitude" name="latitude">
          <input type="hidden" id="longitude" name="longitude">

          <button type="submit" class="btn-send">
            <i class="ri-navigation-line"></i> Send Request
          </button>
        </form>
      </div>

      <p class="note"><i class="ri-information-line"></i> Our team will reach out to you shortly once your request is received.</p>
    </section>
  </main>

  <!-- Scripts -->
  <script>
  // 🌙 Dark Mode
  (function(){
    const themeToggle = document.querySelector('.theme-toggle');
    const sun = document.getElementById('theme-sun');
    const moon = document.getElementById('theme-moon');
    const body = document.body;
    const STORAGE_KEY = 'meu_theme';

    const saved = localStorage.getItem(STORAGE_KEY);
    if(saved === 'dark') body.classList.add('dark');

    function updateIcons() {
      sun.style.opacity = body.classList.contains('dark') ? '1' : '0.4';
      moon.style.opacity = body.classList.contains('dark') ? '0.4' : '1';
    }
    updateIcons();

    themeToggle.addEventListener('click', () => {
      body.classList.toggle('dark');
      localStorage.setItem(STORAGE_KEY, body.classList.contains('dark') ? 'dark' : 'light');
      updateIcons();
    });
  })();

  // 📍 Geolocation
  document.addEventListener("DOMContentLoaded", () => {
    const locationField = document.getElementById('location');
    const latInput = document.getElementById('latitude');
    const lonInput = document.getElementById('longitude');
    const mapDiv = document.getElementById('map');

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          const lat = pos.coords.latitude;
          const lon = pos.coords.longitude;
          latInput.value = lat;
          lonInput.value = lon;
          locationField.value = `Lat: ${lat.toFixed(4)}, Lon: ${lon.toFixed(4)}`;
          mapDiv.innerHTML = `<iframe 
            width="100%" height="100%" style="border:0; border-radius:14px;"
            src="https://maps.google.com/maps?q=${lat},${lon}&z=15&output=embed"
            allowfullscreen></iframe>`;
        },
        () => {
          mapDiv.innerHTML = `<p class="error">Unable to retrieve location. Please enable GPS.</p>`;
        }
      );
    } else {
      mapDiv.innerHTML = `<p class="error">Geolocation not supported.</p>`;
    }

    // 🚨 Submit Emergency Form
    const form = document.getElementById('emergencyForm');
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      const response = await fetch('../backend/submit_emergency.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.status === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Emergency Request Sent!',
          text: result.message,
          confirmButtonColor: '#3085d6'
        }).then(() => form.reset());
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Failed!',
          text: result.message,
          confirmButtonColor: '#d33'
        });
      }
    });
  });
  </script>
</body>
</html>
