<?php
require_once('dbconnect.php'); // เชื่อมต่อฐานข้อมูล

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql_customers = "SELECT cd.id, cd.business_type, cd.business_name, cd.company_name, cd.contact_name, cd.email, cd.phone, cd.line_id, cd.facebook, 
p.name_th AS province_name, a.name_th AS amphure_name, d.name_th AS district_name, cd.zip_code
FROM customers_data cd
INNER JOIN provinces p ON cd.province = p.id
INNER JOIN amphures a ON cd.amphure = a.id
INNER JOIN districts d ON cd.district = d.id";

if (!empty($search)) {
    $sql_customers .= " WHERE cd.business_name LIKE '%$search%' OR cd.company_name LIKE '%$search%' OR cd.contact_name LIKE '%$search%'";
}
$result_customers = $conn->query($sql_customers);
?>
