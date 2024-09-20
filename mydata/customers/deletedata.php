<?php
session_start();
require_once '../config/dbconnect.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: ../login/login.php");
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM customers_data WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../index.php?message=ลบข้อมูลสำเร็จ");
} else {
    header("Location: ../index.php?message=ลบข้อมูลไม่สำเร็จ");
}

$stmt->close();
$conn->close();
?>
