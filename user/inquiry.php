<?php
session_start();
require_once '../functions.php';
$conn = connectDB();

$user_id = $_SESSION['user_id'] ?? 1;

// Handle inquiry submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $msg = trim($_POST['message']);
    if (!empty($msg)) {
        $stmt = $conn->prepare("INSERT INTO inquiry_tbl (user_id, message) VALUES (?, ?)");
        $stmt->execute([$user_id, $msg]);
        echo "<script>
                Swal.fire({
                  title: 'Message Sent!',
                  text: 'Your inquiry has been sent successfully.',
                  icon: 'success',
                  confirmButtonColor: '#2563eb'
                }).then(() => { window.location.reload(); });
              </script>";
    }
}

// Fetch all inquiries and responses for this user
$stmt = $conn->prepare("SELECT * FROM inquiry_tbl WHERE user_id = ? ORDER BY date_sent DESC");
$stmt->execute([$user_id]);
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inquiries | MEU GearUp</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="inquiry.css">
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
      <a href="index.php" ><i class="ri-dashboard-line"></i> Dashboard</a>
       <a href="book.php" ><i class="fa-solid fa-wrench"></i> Book Services</a>
      <a href="browse.php"><i class="ri-shopping-bag-3-line"></i> Browse Parts</a>
      <a href="repairs.php"><i class="ri-tools-line"></i> My Repairs</a>
      <a href="emergency.php"><i class="ri-map-pin-line"></i> Roadside Request</a>
      <a href="inquiry.php" class = "active" ><i class="ri-message-3-line"></i> Inquiries</a>
      <a href="profile.php"><i class="ri-user-line"></i> Profile</a>
      <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
    </nav>
    </div>

    <div class="theme-toggle">
      <i class="ri-sun-line" id="theme-sun"></i>
      <i class="ri-moon-line" id="theme-moon"></i>
    </div>
  </aside>

  <!-- Main -->
  <main class="main-content">
    <div class="topbar">
      <h2><span>Inquiries</span></h2>
      <div class="avatar">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User">
      </div>
    </div>

    <section class="inquiry-section fade-up">
      <div class="send-inquiry fade-in">
        <h3><i class="ri-send-plane-line"></i> Send a Message</h3>
        <form method="POST" class="inquiry-form">
          <textarea name="message" placeholder="Type your message here..." required></textarea>
          <button type="submit" class="btn-submit"><i class="ri-mail-send-line"></i> Send</button>
        </form>
      </div>

      <div class="inquiry-list fade-in">
        <h3><i class="ri-chat-history-line"></i> Message History</h3>
        <?php if (count($inquiries) > 0): ?>
          <div class="inquiry-grid">
            <?php foreach ($inquiries as $inq): ?>
              <div class="inquiry-card">
                <p class="user-msg"><strong>You:</strong> <?= htmlspecialchars($inq['message']) ?></p>
                <p class="msg-date"><?= date('M d, Y h:i A', strtotime($inq['date_sent'])) ?></p>
                <?php if (!empty($inq['response'])): ?>
                  <p class="admin-reply"><strong>Admin:</strong> <?= htmlspecialchars($inq['response']) ?></p>
                <?php else: ?>
                  <p class="pending">Awaiting admin response...</p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="no-msg">No inquiries yet. Send your first message!</p>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <script>
  // Dark mode toggle (same logic as other pages)
  (function(){
    const themeToggle = document.querySelector('.theme-toggle');
    const sun = document.getElementById('theme-sun');
    const moon = document.getElementById('theme-moon');
    const body = document.body;
    const STORAGE_KEY = 'meu_theme';

    const saved = localStorage.getItem(STORAGE_KEY);
    if(saved === 'dark') body.classList.add('dark');

    const updateIcons = () => {
      sun.style.opacity = body.classList.contains('dark') ? '1' : '0.4';
      moon.style.opacity = body.classList.contains('dark') ? '0.4' : '1';
    };
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
