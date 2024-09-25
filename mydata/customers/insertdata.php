<?php
session_start();
require_once '../config/dbconnect.php';

// ตรวจสอบว่ามีการส่งข้อมูลเข้ามาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $business_name = $_POST['business_name'];
    $business_type = $_POST['business_type'];
    $company_name = $_POST['company_name'];
    $contact_name = $_POST['contact_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $line_id = $_POST['line_id'];
    $facebook = $_POST['facebook'];
    $province = $_POST['province'];
    $amphure = $_POST['amphure'];
    $district = $_POST['district'];
    $zip_code = $_POST['zip_code'];

    // ตรวจสอบว่าชื่อธุรกิจซ้ำหรือไม่
    $sql_check = "SELECT id FROM customers_data WHERE business_name = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $business_name);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'ชื่อธุรกิจนี้มีอยู่แล้วในระบบ']);
    } else {
        // บันทึกข้อมูลถ้าไม่มีชื่อซ้ำ
        $sql_insert = "INSERT INTO customers_data (business_type, business_name, company_name, contact_name, email, phone, line_id, facebook, province, amphure, district, zip_code)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssssssssss", $business_type, $business_name, $company_name, $contact_name, $email, $phone, $line_id, $facebook, $province, $amphure, $district, $zip_code);

        if ($stmt_insert->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }

    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'วิธีการส่งข้อมูลไม่ถูกต้อง']);
}
?>
