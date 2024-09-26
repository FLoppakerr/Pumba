<?php
session_start();

// ตรวจสอบว่ามีข้อมูลใน Session หรือไม่
if (!isset($_SESSION['rows'])) {
    die('ไม่มีข้อมูลสำหรับการส่งออก');
}

// ดึงข้อมูลที่ผู้ใช้เลือกจาก Session
$rows = isset($_SESSION['rows']) ? $_SESSION['rows'] : [];
$businessType = isset($_SESSION['businessType']) ? $_SESSION['businessType'] : '';
$province = isset($_SESSION['province']) ? $_SESSION['province'] : '';

// ตั้งค่า header สำหรับการดาวน์โหลดไฟล์ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=export_data.csv');

// สร้างไฟล์ CSV พร้อมเขียน BOM สำหรับการแสดงผลภาษาไทยใน Excel
$output = fopen('php://output', 'w');
// เขียน BOM เพื่อรองรับการแสดงผลภาษาไทย
fwrite($output, "\xEF\xBB\xBF");

// เขียนหัวตารางลงในไฟล์ CSV
if (!empty($businessType) && !empty($province)) {
    // ถ้าเลือกทั้งประเภทธุรกิจและจังหวัด
    fputcsv($output, ['ประเภทธุรกิจ', 'จำนวนธุรกิจ']);
} elseif (!empty($businessType)) {
    // ถ้าเลือกเฉพาะประเภทธุรกิจ
    fputcsv($output, ['จังหวัด', 'จำนวนธุรกิจในจังหวัดนั้นๆ']);
} elseif (!empty($province)) {
    // ถ้าเลือกเฉพาะจังหวัด
    fputcsv($output, ['ประเภทธุรกิจ', 'จำนวนธุรกิจทั้งหมด']);
}

// เขียนข้อมูลลงในไฟล์ CSV
if (!empty($rows)) {
    foreach ($rows as $row) {
        if (!empty($businessType) && !empty($province)) {
            // ถ้าเลือกทั้งประเภทธุรกิจและจังหวัด
            fputcsv($output, [$row['business_type'], $row['business_count']]);
        } elseif (!empty($businessType)) {
            // ถ้าเลือกเฉพาะประเภทธุรกิจ
            fputcsv($output, [$row['province'], $row['business_count']]);
        } elseif (!empty($province)) {
            // ถ้าเลือกเฉพาะจังหวัด
            fputcsv($output, [$row['business_type'], $row['business_count']]);
        }
    }
}

// ปิดไฟล์
fclose($output);

