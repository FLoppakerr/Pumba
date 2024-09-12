<?php
require_once 'config/dbconnect.php';

// กำหนด header สำหรับการส่งออกไฟล์ CSV
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"customers_data.csv\"");
header("Pragma: no-cache");
header("Expires: 0");

// เพิ่ม BOM สำหรับ UTF-8 เพื่อรองรับการแสดงผลภาษาไทยใน Excel
echo "\xEF\xBB\xBF";

// Query เพื่อดึงข้อมูลลูกค้าทั้งหมด
$sql_customers = "SELECT c.id, c.business_type, c.business_name, c.company_name, c.contact_name, c.email, c.phone, c.line_id, c.facebook, p.name_th AS province_name, a.name_th AS amphure_name, d.name_th AS district_name, d.zip_code 
FROM customers_data c
JOIN provinces p ON c.province = p.id
JOIN amphures a ON c.amphure = a.id
JOIN districts d ON c.district = d.id";
$result_customers = $conn->query($sql_customers);

// Output header row for CSV
echo "ID,ประเภทธุรกิจ,ชื่อธุรกิจ,ชื่อบริษัท,ชื่อผู้ติดต่อ,Email,โทรศัพท์,Line ID,Facebook,จังหวัด,อำเภอ,ตำบล,รหัสไปรษณีย์\n";

// Output data rows for CSV
while ($row = $result_customers->fetch_assoc()) {
    // Escape ข้อมูลเพื่อป้องกันอักขระพิเศษใน HTML
    $row = array_map('htmlspecialchars', $row);

    // บังคับให้เบอร์โทรศัพท์เป็นข้อความ โดยใช้ ' ครอบเบอร์
    $row['phone'] = "'" . $row['phone'] . "'";

    // นำข้อมูลแต่ละแถวมาแปลงเป็นคอมม่าแยกแต่ละคอลัมน์ และส่งออก
    echo implode(",", $row) . "\n";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
