<?php
session_start();
require_once '../config/dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

if (isset($_POST['business_name'])) {
    $business_name = $_POST['business_name'];

    $stmt = $conn->prepare("SELECT id FROM customers_data WHERE business_name = ?");
    $stmt->bind_param("s", $business_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'exists']);
    } else {
        echo json_encode(['status' => 'available']);
    }

    $stmt->close();
}
?>
