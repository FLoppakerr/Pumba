<?php
session_start();
require_once 'config/dbconnect.php';

// ตรวจสอบว่ามีการเลือกข้อมูลหรือไม่
if (isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {
    // รับค่าที่ถูกเลือกจากฟอร์ม
    $selected_ids = $_POST['selected_ids'];

    // กำหนด header สำหรับการส่งออกไฟล์ CSV
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"export_customers_data.csv\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // เพิ่ม BOM สำหรับ UTF-8 เพื่อรองรับการแสดงผลภาษาไทยใน Excel
    echo "\xEF\xBB\xBF";

    // Output header row for CSV
    echo "ID,ประเภทธุรกิจ,ชื่อธุรกิจ,ชื่อบริษัท,ชื่อผู้ติดต่อ,Email,โทรศัพท์,Line ID,Facebook,จังหวัด,อำเภอ,ตำบล,รหัสไปรษณีย์\n";

    // เตรียม Query สำหรับดึงข้อมูลลูกค้าที่ถูกเลือก
    $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
    $sql = "SELECT c.id, c.business_type, c.business_name, c.company_name, c.contact_name, c.email, c.phone, c.line_id, c.facebook, 
                   p.name_th AS province_name, a.name_th AS amphure_name, d.name_th AS district_name, d.zip_code 
            FROM customers_data c
            JOIN provinces p ON c.province = p.id
            JOIN amphures a ON c.amphure = a.id
            JOIN districts d ON c.district = d.id
            WHERE c.id IN ($placeholders)";

    $stmt = $conn->prepare($sql);

    // Bind parameters dynamically
    $stmt->bind_param(str_repeat('i', count($selected_ids)), ...$selected_ids);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    // หากไม่มีการเลือกข้อมูลใดๆ ให้ดึงข้อมูลทั้งหมด
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"export_customers_data.csv\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // เพิ่ม BOM สำหรับ UTF-8 เพื่อรองรับการแสดงผลภาษาไทยใน Excel
    echo "\xEF\xBB\xBF";

    // Output header row for CSV
    echo "ID,ประเภทธุรกิจ,ชื่อธุรกิจ,ชื่อบริษัท,ชื่อผู้ติดต่อ,Email,โทรศัพท์,Line ID,Facebook,จังหวัด,อำเภอ,ตำบล,รหัสไปรษณีย์\n";

    // Query ดึงข้อมูลลูกค้าทั้งหมด
    $sql = "SELECT c.id, c.business_type, c.business_name, c.company_name, c.contact_name, c.email, c.phone, c.line_id, c.facebook, 
                   p.name_th AS province_name, a.name_th AS amphure_name, d.name_th AS district_name, d.zip_code 
            FROM customers_data c
            JOIN provinces p ON c.province = p.id
            JOIN amphures a ON c.amphure = a.id
            JOIN districts d ON c.district = d.id";
    $result = $conn->query($sql);
}

// Output data rows for CSV
while ($row = $result->fetch_assoc()) {
    // Escape ข้อมูลเพื่อป้องกันอักขระพิเศษใน HTML
    $row = array_map('htmlspecialchars', $row);

    // บังคับให้เบอร์โทรศัพท์เป็นข้อความ โดยใช้ ' ครอบเบอร์
    if (isset($row['phone'])) {
        $row['phone'] = "'" . $row['phone'] . "'";
    }

    // แปลงข้อมูลเป็น CSV แยกแต่ละคอลัมน์ด้วยคอมม่า
    echo implode(",", $row) . "\n";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
