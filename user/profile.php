<?php
session_start();
require_once '../functions.php';
$conn = connectDB();

// Example session (replace with your real session)
$user_id = $_SESSION['user_id'] ?? 1;

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM user_tbl WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Flags for SweetAlert messages
$alert = '';
$alert_type = '';
$alert_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $user['password'];

    // Password validation
    if (!empty($_POST['password']) || !empty($_POST['confirm_password'])) {
        if ($_POST['password'] === $_POST['confirm_password']) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            $alert_type = 'error';
            $alert_message = 'Passwords do not match!';
        }
    }

    // If no error, proceed with update
    if ($alert_type !== 'error') {
        $update = $conn->prepare("UPDATE user_tbl 
            SET first_name=?, middle_initial=?, last_name=?, contact_number=?, 
                street=?, barangay=?, city=?, province=?, password=? 
            WHERE user_id=?");

        $update->execute([
            $_POST['first_name'],
            $_POST['middle_initial'],
            $_POST['last_name'],
            $_POST['contact_number'],
            $_POST['street'],
            $_POST['barangay'],
            $_POST['city'],
            $_POST['province'],
            $password,
            $user_id
        ]);

        $alert_type = 'success';
        $alert_message = 'Profile updated successfully!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile | MEU GearUp</title>
  <link rel="stylesheet" href="profile.css">
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
        <a href="browse.php"><i class="ri-shopping-bag-3-line"></i> Browse Parts</a>
        <a href="book.php"><i class="ri-calendar-check-line"></i> Book Services</a>
        <a href="repairs.php"><i class="ri-wrench-line"></i> My Repairs</a>
       
        <a href="emergency.php"><i class="ri-roadster-line"></i> Emergency</a>
          <a href="inquiry.php"><i class="ri-message-3-line"></i> Inquiries</a>
        <a href="profile.php" class="active"><i class="ri-user-line"></i> My Profile</a>
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
      <h2><span>My</span> Profile</h2>
      <div class="avatar">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User Avatar">
      </div>
    </div>

    <section class="profile-section fade-up">
      <div class="profile-card fade-in">
        <div class="profile-header">
          <div class="profile-photo">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile Photo">
          </div>
          <h3><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
          <p class="role"><?= htmlspecialchars($user['role'] ?? 'User'); ?></p>
        </div>

        <form method="POST" class="profile-form" id="profileForm">
          <div class="form-row">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="form-group">
              <label>Middle Initial</label>
              <input type="text" name="middle_initial" maxlength="5" value="<?= htmlspecialchars($user['middle_initial']); ?>">
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']); ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Email (non-editable)</label>
              <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" readonly>
            </div>
            <div class="form-group">
              <label>Contact Number</label>
              <input type="text" name="contact_number" value="<?= htmlspecialchars($user['contact_number']); ?>">
            </div>
          </div>

          <h4>Change Password</h4>
          <div class="form-row">
            <div class="form-group">
              <label>New Password</label>
              <input type="password" id="password" name="password" placeholder="Enter new password (optional)">
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter new password">
            </div>
          </div>

          <h4>Address Information</h4>
          <div class="form-row">
            <div class="form-group">
              <label>Street</label>
              <input type="text" name="street" value="<?= htmlspecialchars($user['street']); ?>" required>
            </div>
            <div class="form-group">
              <label>Barangay</label>
              <input type="text" name="barangay" value="<?= htmlspecialchars($user['barangay']); ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>City</label>
              <input type="text" name="city" value="<?= htmlspecialchars($user['city']); ?>" required>
            </div>
            <div class="form-group">
              <label>Province</label>
              <input type="text" name="province" value="<?= htmlspecialchars($user['province']); ?>" required>
            </div>
          </div>

          <button type="submit" class="btn-update">
            <i class="ri-save-3-line"></i> Save Changes
          </button>
        </form>
      </div>
    </section>
  </main>

  <!-- SweetAlert Feedback -->
  <?php if ($alert_type && $alert_message): ?>
    <script>
      Swal.fire({
        icon: '<?= $alert_type ?>',
        title: '<?= $alert_type === "success" ? "Success" : "Oops..." ?>',
        text: '<?= $alert_message ?>',
        confirmButtonColor: '#2563eb',
      }).then(() => {
        <?php if ($alert_type === 'success'): ?>
          window.location = 'profile.php';
        <?php endif; ?>
      });
    </script>
  <?php endif; ?>

  <!-- JS Theme Toggle -->
  <script>
  (function(){
    const themeToggle = document.querySelector('.theme-toggle');
    const sun = document.getElementById('theme-sun');
    const moon = document.getElementById('theme-moon');
    const body = document.body;
    const STORAGE_KEY = 'meu_theme';

    const saved = localStorage.getItem(STORAGE_KEY);
    if(saved === 'dark') body.classList.add('dark');
    if(saved === 'light') body.classList.remove('dark');

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
  </script>
</body>
</html>
