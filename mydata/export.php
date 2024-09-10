<?php
require_once 'config/dbconnect.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"customers_data.xls\"");
header("Pragma: no-cache");
header("Expires: 0");

// Query เพื่อดึงข้อมูลลูกค้าทั้งหมด
$sql_customers = "SELECT c.id, c.business_type, c.business_name, c.company_name, c.contact_name, c.email, c.phone, c.line_id, c.facebook, p.name_th AS province_name, a.name_th AS amphure_name, d.name_th AS district_name, d.zip_code 
FROM customers_data c
JOIN provinces p ON c.province = p.id
JOIN amphures a ON c.amphure = a.id
JOIN districts d ON c.district = d.id";
$result_customers = $conn->query($sql_customers);

// Output the data to Excel format
echo "ID\tประเภทธุรกิจ\tชื่อธุรกิจ\tชื่อบริษัท\tชื่อผู้ติดต่อ\tEmail\tโทรศัพท์\tLine ID\tFacebook\tจังหวัด\tอำเภอ\tตำบล\tรหัสไปรษณีย์\n";
while ($row = $result_customers->fetch_assoc()) {
    echo implode("\t", array_map('strip_tags', $row)) . "\n";
}

$conn->close();
?>
