<?php
require_once 'config/dbconnect.php';

$sql_customers = "SELECT c.id, c.business_type, c.business_name, c.company_name, c.contact_name, c.email, c.phone, c.line_id, c.facebook, p.name_th AS province_name, a.name_th AS amphure_name, d.name_th AS district_name, c.zip_code 
FROM customers_data c
JOIN provinces p ON c.province = p.id
JOIN amphures a ON c.amphure = a.id
JOIN districts d ON c.district = d.id";

$result_customers = $conn->query($sql_customers);

if (!$result_customers) {
    die("Query failed: " . $conn->error);
}

// Return data as JSON (example)
$customers = [];
while ($row = $result_customers->fetch_assoc()) {
    $customers[] = $row;
}
echo json_encode($customers);
?>
