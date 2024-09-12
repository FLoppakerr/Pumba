<?php
session_start();
require_once '../config/dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// รับค่าจากฟอร์ม
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$business_type = isset($_POST['business_type']) ? $_POST['business_type'] : '';
$business_name = isset($_POST['business_name']) ? $_POST['business_name'] : '';
$company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
$contact_name = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$line_id = isset($_POST['line_id']) ? $_POST['line_id'] : '';
$facebook = isset($_POST['facebook']) ? $_POST['facebook'] : '';
$province = isset($_POST['province']) ? $_POST['province'] : '';
$amphure = isset($_POST['amphure']) ? $_POST['amphure'] : '';
$district = isset($_POST['district']) ? $_POST['district'] : '';
$zip_code = isset($_POST['zip_code']) ? $_POST['zip_code'] : '';

// Query อัปเดตข้อมูลลูกค้า
$sql = "UPDATE customers_data SET business_type = ?, business_name = ?, company_name = ?, contact_name = ?, email = ?, phone = ?, line_id = ?, facebook = ?, province = ?, amphure = ?, district = ?, zip_code = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssi", $business_type, $business_name, $company_name, $contact_name, $email, $phone, $line_id, $facebook, $province, $amphure, $district, $zip_code, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // ปิดการเชื่อมต่อฐานข้อมูลก่อน redirect
    $stmt->close();
    $conn->close();
    header("Location: http://localhost/mydata/index.php");
    exit();
} else {
    echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
}

$stmt->close();
$conn->close();
?>
