<?php
session_start();
require_once '../db_connect.php';
$conn = connectDB();

// Assume mechanics have their own session (adjust if your mechanic login differs)
if (!isset($_SESSION['mechanic_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Mechanic login required.']);
    exit;
}

$mechanic_id = $_SESSION['mechanic_id'];
$emergency_id = $_POST['emergency_id'] ?? null;

if (!$emergency_id) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters.']);
    exit;
}

// Validate emergency_id is numeric
if (!is_numeric($emergency_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid emergency ID.']);
    exit;
}

try {
    // Fetch emergency details and ensure it's pending
    $stmt = $conn->prepare("SELECT * FROM emergency_tbl WHERE emergency_id = ? AND status = 'Pending'");
    $stmt->execute([$emergency_id]);
    $em = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$em) {
        echo json_encode(['success' => false, 'message' => 'Emergency not found or already assigned.']);
        exit;
    }

    // Insert into repair_tbl
    $insert = $conn->prepare("
        INSERT INTO repair_tbl (user_id, service_type, issue_description, repair_date, repair_status, assigned_to)
        VALUES (?, 'Emergency Repair', ?, NOW(), 'In Progress', ?)
    ");
    $insert->execute([$em['user_id'], $em['issue'], $mechanic_id]);

    // Update emergency status
    $update = $conn->prepare("UPDATE emergency_tbl SET status = 'In Progress' WHERE emergency_id = ?");
    $update->execute([$emergency_id]);

    echo json_encode(['success' => true, 'message' => 'Emergency accepted successfully.']);
} catch (PDOException $e) {
    error_log("Emergency accept error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to accept emergency. Please try again.']);
}
?>