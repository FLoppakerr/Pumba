<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "customers";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// กำหนดการตั้งค่าการเข้ารหัสฐานข้อมูลเป็น UTF-8
$conn->set_charset("utf8mb4");
?>
