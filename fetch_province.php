<?php
// การเชื่อมต่อฐานข้อมูล MySQL
$servername = "localhost";
$username = "username"; // แทนที่ด้วยชื่อผู้ใช้ MySQL
$password = "password"; // แทนที่ด้วยรหัสผ่าน MySQL
$dbname = "mydata"; // แทนที่ด้วยชื่อฐานข้อมูล MySQL

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
