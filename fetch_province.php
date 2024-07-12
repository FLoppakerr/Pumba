<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "customers";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลจังหวัด
$sql = "SELECT DISTINCT thai_provinces FROM thai_provinces"; // เปลี่ยนเป็นชื่อตารางและคอลัมน์ที่ถูกต้อง

$result = $conn->query($sql);

$options = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row["thai_provinces"] . '">' . $row["thai_provinces"] . '</option>';
    }
} else {
    $options .= '<option value="">ไม่พบข้อมูลจังหวัด</option>';
}

$conn->close();
