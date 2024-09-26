<?php
require_once '../config/dbconnect.php';

if (isset($_POST['business_name'])) {
    $business_name = $_POST['business_name'];

    // Query เพื่อตรวจสอบว่า business_name มีอยู่หรือไม่
    $sql = "SELECT id FROM customers_data WHERE business_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $business_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // ถ้าชื่อธุรกิจซ้ำ ส่งสถานะ 'error' กลับไป
        echo json_encode(['status' => 'error', 'message' => 'ชื่อธุรกิจนี้มีอยู่แล้วในระบบ']);
    } else {
        // ถ้าไม่มีชื่อซ้ำ ส่งสถานะ 'success' กลับไป
        echo json_encode(['status' => 'success']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่มีชื่อธุรกิจที่ตรวจสอบ']);
}
?>
