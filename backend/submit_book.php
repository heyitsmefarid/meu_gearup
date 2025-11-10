<?php
session_start();
require_once '../db_connect.php';

$conn = connectDB();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'You must be logged in to book a repair.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $vehicle_model = trim($_POST['vehicle_model']);
    $service_type = trim($_POST['service_type']);
    $issue_description = trim($_POST['issue_description']);
    $repair_date = $_POST['repair_date'];
    $repair_time = $_POST['repair_time'];
  

    if (empty($vehicle_model) || empty($service_type) || empty($repair_date) || empty($repair_time)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please fill in all required fields.'
        ]);
        exit;
    }

    try {
        $sql = "INSERT INTO repair_tbl 
                (user_id, vehicle_model, service_type, issue_description, repair_date, repair_time, repair_status)
                VALUES 
                (:user_id, :vehicle_model, :service_type, :issue_description, :repair_date, :repair_time, 'Pending')";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':vehicle_model' => $vehicle_model,
            ':service_type' => $service_type,
            ':issue_description' => $issue_description,
            ':repair_date' => $repair_date,
            ':repair_time' => $repair_time
            
        ]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Your booking has been successfully submitted!'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
}
?>
