<?php
ob_start();
session_start();
require_once '../db_connect.php';
$conn = connectDB();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    ob_end_clean();
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to submit a request.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$issue = trim($_POST['issue'] ?? '');
$location = trim($_POST['location'] ?? '');
$latitude = trim($_POST['latitude'] ?? '');
$longitude = trim($_POST['longitude'] ?? '');

if (empty($issue) || empty($location) || empty($latitude) || empty($longitude)) {
    ob_end_clean();
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters. Please fill all fields.']);
    exit;
}

if (!is_numeric($latitude) || !is_numeric($longitude) || 
    $latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
    ob_end_clean();
    echo json_encode(['status' => 'error', 'message' => 'Invalid location data.']);
    exit;
}

$issue = filter_var($issue, FILTER_SANITIZE_STRING);
$location = filter_var($location, FILTER_SANITIZE_STRING);

try {
    // Updated: Use 'created_at' instead of 'request_time'
    $stmt = $conn->prepare("
        INSERT INTO emergency_tbl (user_id, issue, location, latitude, longitude, status, created_at)
        VALUES (?, ?, ?, ?, ?, 'Pending', NOW())
    ");
    $stmt->execute([$user_id, $issue, $location, (float)$latitude, (float)$longitude]);

    ob_end_clean();
    echo json_encode(['status' => 'success', 'message' => 'Emergency request submitted successfully. Our team will contact you soon.']);
} catch (PDOException $e) {
    error_log("Emergency submit error: " . $e->getMessage());
    ob_end_clean();
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit request. Please try again.']);
}
?>