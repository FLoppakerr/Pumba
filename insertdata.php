<?php
// Include database connection file
require_once('dbconnect.php');

// Prepare and bind SQL statement to prevent SQL injection
$sql = "INSERT INTO customers_data (business_type, business_name, company_name, contact_name, email, phone, line_id, facebook, province, amphure, district, zip_code) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssss", $business_type, $business_name, $company_name, $contact_name, $email, $phone, $line_id, $facebook, $province_id, $amphure_id, $district_id, $zip_code);

// Set parameters and execute
$business_type = $_POST['business_type'];
$business_name = $_POST['business_name'];
$company_name = $_POST['company_name'];
$contact_name = $_POST['contact_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$line_id = $_POST['line_id'];
$facebook = $_POST['facebook'];
$province_id = $_POST['province']; // แก้ไขชื่อฟิลด์ให้ตรงกับชื่อในแบบฟอร์ม
$amphure_id = $_POST['amphure'];   // แก้ไขชื่อฟิลด์ให้ตรงกับชื่อในแบบฟอร์ม
$district_id = $_POST['district']; // แก้ไขชื่อฟิลด์ให้ตรงกับชื่อในแบบฟอร์ม
$zip_code = $_POST['zip_code'];

if ($stmt->execute()) {
    echo "บันทึกข้อมูลเรียบร้อยแล้ว";
} else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: index.php"); // กลับไปยังหน้าแรกหลังจากบันทึกข้อมูล
exit();
?>
