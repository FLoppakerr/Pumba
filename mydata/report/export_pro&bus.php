<?php
session_start();

// ตรวจสอบว่ามีข้อมูลที่กรองแล้วหรือไม่
$rows = isset($_SESSION['rows']) ? $_SESSION['rows'] : [];
$businessType = isset($_SESSION['businessType']) ? $_SESSION['businessType'] : '';
$province = isset($_SESSION['province']) ? $_SESSION['province'] : '';

// ตรวจสอบว่ามีข้อมูลใน Session หรือไม่
if (empty($rows)) {
    echo "ไม่มีข้อมูลสำหรับการส่งออก";
    exit();
}

// ตั้งชื่อไฟล์ CSV ที่จะส่งออก
$filename = 'export_' . date('Ymd') . '.csv';

// ตั้งค่าหัวข้อ CSV
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="export_pro&bus.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// เปิด output เพื่อเขียนข้อมูล
$output = fopen('php://output', 'w');

// เขียนหัวข้อของตาราง CSV
if (!empty($businessType)) {
    fputcsv($output, ['จังหวัดทั้งหมด', 'จำนวนธุรกิจในจังหวัดนั้นๆ'], ',', '"');
} elseif (!empty($province)) {
    fputcsv($output, ['ประเภทธุรกิจทั้งหมด', 'จำนวนธุรกิจทั้งหมด'], ',', '"');
}

// เขียนข้อมูลที่กรองแล้วลงใน CSV
if (!empty($rows)) {
    foreach ($rows as $row) {
        if (!empty($businessType)) {
            fputcsv($output, [$row['province'], $row['business_count']], ',', '"');
        } elseif (!empty($province)) {
            fputcsv($output, [$row['business_type'], $row['business_count']], ',', '"');
        }
    }
}

// ปิด output
fclose($output);

// ล้างข้อมูลใน Session ที่เกี่ยวข้องหลังการใช้งาน (สามารถเปิดได้เมื่อทดสอบเสร็จสิ้น)
unset($_SESSION['rows'], $_SESSION['businessType'], $_SESSION['province']);

exit();
