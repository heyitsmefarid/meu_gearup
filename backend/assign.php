<?php
require_once '../db_connect.php';
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repair_id = $_POST['repair_id'] ?? null;
    $mechanic_id = $_POST['mechanic_id'] ?? null;

    if (!$repair_id || !$mechanic_id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing data.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE repair_tbl 
                                SET assigned_to = :mechanic_id, repair_status = 'In Progress'
                                WHERE repair_id = :repair_id");
        $stmt->execute([':mechanic_id' => $mechanic_id, ':repair_id' => $repair_id]);

        echo json_encode(['status' => 'success', 'message' => 'Mechanic assigned successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
