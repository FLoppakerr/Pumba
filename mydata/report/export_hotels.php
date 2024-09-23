<?php
require_once '../config/dbconnect.php';

// กำหนด Header เพื่อบอกให้ Browser รู้ว่าเป็นไฟล์ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=hotel_report.csv');

// เปิด output stream สำหรับเขียนข้อมูล CSV
$output = fopen('php://output', 'w');

// เขียนหัวตาราง
fputcsv($output, array('จังหวัด', 'จำนวนโรงแรม'));

// Query SQL สำหรับดึงข้อมูลจังหวัดและจำนวนโรงแรม
$sql = "SELECT p.name_th AS province_name, COUNT(c.business_name) AS hotel_count
        FROM customers_data c
        JOIN provinces p ON c.province = p.id
        WHERE c.business_type = 'โรงแรม'
        GROUP BY c.province
        ORDER BY hotel_count DESC";

// ดึงข้อมูลจากฐานข้อมูล
$result = $conn->query($sql);

// ตรวจสอบว่ามีผลลัพธ์หรือไม่
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // เขียนข้อมูลแต่ละแถวลงในไฟล์ CSV
        fputcsv($output, array($row['province_name'], $row['hotel_count']));
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
fclose($output);
$conn->close();
?>
