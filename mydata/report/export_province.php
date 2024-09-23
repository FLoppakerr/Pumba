<?php
require_once '../config/dbconnect.php'; // ตรวจสอบว่ามีการเชื่อมต่อฐานข้อมูลที่ถูกต้อง

// Query SQL สำหรับดึงข้อมูลจังหวัดและจำนวนธุรกิจ
$sql = "SELECT provinces.name_th AS province, COUNT(customers_data.id) AS business_count
        FROM customers_data
        JOIN provinces ON customers_data.province = provinces.id
        GROUP BY customers_data.province
        ORDER BY business_count DESC"; 

$result = $conn->query($sql);

// กำหนด header สำหรับการดาวน์โหลดไฟล์ CSV
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="province_report.csv"');

// สร้างไฟล์ CSV
$output = fopen('php://output', 'w');

// เขียน header ของ CSV
fputcsv($output, array('จังหวัด', 'จำนวนธุรกิจ'));

// เขียนข้อมูลจากฐานข้อมูลลงใน CSV
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array($row['province'], $row['business_count']));
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
fclose($output);
exit;
?>
