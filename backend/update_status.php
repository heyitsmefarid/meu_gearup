<?php
require '../db_connect.php';
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['repair_id'])) {
    $repair_id = $_POST['repair_id'];

    try {
        $stmt = $conn->prepare("UPDATE repair_tbl SET repair_status = 'Completed', updated_at = NOW() WHERE repair_id = ?");
        $stmt->execute([$repair_id]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
