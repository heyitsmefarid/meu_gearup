<?php
// backend/assign_emergency.php
require_once '../db_connect.php';
$conn = connectDB();
header('Content-Type: application/json');

try {
    // Change from JSON to form data (since frontend sends application/x-www-form-urlencoded)
    $emergency_id = $_POST['emergency_id'] ?? null;
    $mechanic_id = $_POST['mechanic_id'] ?? null;

    if (!$emergency_id || !$mechanic_id) {
        echo json_encode(["success" => false, "message" => "Missing required data"]);
        exit;
    }

    $pdo = connectDB();

    // Update emergency status to 'Assigned' (assuming the enum includes 'Assigned')
    $stmt = $pdo->prepare("UPDATE emergency_tbl SET status = 'Assigned' WHERE emergency_id = ?");
    $stmt->execute([$emergency_id]);

    // Note: The original code tried to insert into repair_tbl, but repair_tbl does not have the required columns (emergency_id, date_assigned).
    // Additionally, repair_tbl has required fields like vehicle_model, service_type, repair_date that are not provided.
    // For emergencies, we're only updating the status in emergency_tbl to record the assignment.
    // If you need to track assignments separately, consider adding a new table or modifying repair_tbl schema.

    echo json_encode(["success" => true, "message" => "Emergency assigned successfully"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>