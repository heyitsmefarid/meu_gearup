<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout | MEU GearUp</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #f8fafc, #e0f2fe);
      font-family: 'Poppins', sans-serif;
      color: #0f172a;
    }

    .dark {
      background: linear-gradient(135deg, #1e293b, #0f172a);
      color: #f1f5f9;
    }

    .loading {
      text-align: center;
      font-size: 1.2rem;
    }

    .loading i {
      display: block;
      font-size: 3rem;
      color: #2563eb;
      margin-bottom: 10px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div class="loading">
    <i class="ri-loader-4-line"></i>
    Preparing logout confirmation...
  </div>

  <script>
    // Match user’s theme
    const savedTheme = localStorage.getItem('meu_theme');
    if (savedTheme === 'dark') document.body.classList.add('dark');

    // Ask for confirmation first
    setTimeout(() => {
      Swal.fire({
        title: 'Are you sure you want to log out?',
        text: 'You will need to log in again to access your account.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, log out',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // If confirmed, log out
          fetch('logout_process.php', { method: 'POST' })
            .then(() => {
              Swal.fire({
                icon: 'success',
                title: 'Logged out successfully!',
                text: 'See you soon.',
                timer: 2000,
                showConfirmButton: false
              }).then(() => {
                window.location.href = '../index.php'; // adjust path
              });
            });
        } else {
          // If canceled, go back to dashboard
          window.location.href = 'index.php';
        }
      });
    }, 500);
  </script>
</body>
</html>
