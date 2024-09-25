<?php
session_start(); // เริ่มต้น session

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once '../config/dbconnect.php'; // เชื่อมต่อฐานข้อมูล

// ตั้งค่าหัวเอกสารเพื่อนำเสนอเป็นไฟล์ CSV
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="business_type_report.csv"');

// เปิด output buffer เพื่อเขียนข้อมูล CSV
$output = fopen('php://output', 'w');

// เขียน BOM ให้รองรับภาษาไทยใน Excel
fwrite($output, "\xEF\xBB\xBF");

// เขียนส่วนหัวของตาราง
fputcsv($output, ['ประเภทธุรกิจ', 'จำนวน']);

// Query SQL เพื่อดึงข้อมูลประเภทธุรกิจและจำนวน
$sql = "SELECT business_type, COUNT(*) AS count
        FROM customers_data
        GROUP BY business_type
        ORDER BY count DESC";
$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result && $result->num_rows > 0) {
    // Loop ข้อมูลจากฐานข้อมูลแล้วเขียนลงไฟล์ CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [$row['business_type'], $row['count']]);
    }
} else {
    // ถ้าไม่มีข้อมูล ให้ใส่ข้อความว่าไม่พบข้อมูล
    fputcsv($output, ['ไม่พบข้อมูล', '']);
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
fclose($output);
exit();
