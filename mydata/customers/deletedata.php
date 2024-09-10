<?php
session_start();
require_once '../config/dbconnect.php';

// ตรวจสอบว่า session user_id ถูกตั้งค่าและมีการส่ง id มา
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
  header("Location: ../login/login.php");
  exit();
}

$id = $_GET['id'];
$sql = "DELETE FROM customers_data WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
  header("Location: ../index.php?message=ลบข้อมูลสำเร็จ");
} else {
  header("Location: ../index.php?message=ลบข้อมูลไม่สำเร็จ");
}
$stmt->close();
$conn->close();
