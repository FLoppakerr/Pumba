<?php
session_start();
require_once '../config/dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$business_type = $_POST['business_type'];
$business_name = $_POST['business_name'];
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

$sql = "INSERT INTO customers_data (business_type, business_name, company_name, contact_name, email, phone, line_id, facebook, province, amphure, district, zip_code) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssss", $business_type, $business_name, $company_name, $contact_name, $email, $phone, $line_id, $facebook, $province, $amphure, $district, $zip_code);

if ($stmt->execute()) {
    header("Location: ../index.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
