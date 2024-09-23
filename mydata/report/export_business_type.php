<?php
require_once '../config/dbconnect.php';

// กำหนด Header เพื่อแจ้งให้ Browser รู้ว่าเป็นไฟล์ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=business_type_report.csv');

// เปิด output stream สำหรับเขียนข้อมูล CSV
$output = fopen('php://output', 'w');

// เขียนหัวตารางใน CSV
fputcsv($output, array('ประเภทธุรกิจ', 'จำนวน'));

// Query SQL สำหรับดึงข้อมูลประเภทธุรกิจและจำนวน
$sql = "SELECT business_type, COUNT(*) AS count
        FROM customers_data
        GROUP BY business_type
        ORDER BY count DESC";

$result = $conn->query($sql);

// เขียนข้อมูลจากฐานข้อมูลลงใน CSV
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array($row['business_type'], $row['count']));
    }
}

// ปิด output stream
fclose($output);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
