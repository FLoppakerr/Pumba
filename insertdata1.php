<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "customers";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $business_type = $_POST['business_type'];
    $business_name = $_POST['business_name'];
    $company_name = $_POST['company_name'];
    $contact_name = $_POST['contact_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $line_id = $_POST['line_id'];
    $facebook = $_POST['facebook'];
    $province = $_POST['province'];
    $district = $_POST['district'];

    // ตรวจสอบข้อมูลซ้ำ
    $checkQuery = "SELECT * FROM customers WHERE email = '$email' OR phone = '$phone'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "มีลูกค้าที่ใช้อีเมลหรือเบอร์โทรนี้แล้ว";
    } else {
        // เพิ่มข้อมูลลูกค้าใหม่
        $sql = "INSERT INTO customers (business_type, business_name, company_name, contact_name, email, phone, line_id, facebook, province, district)
                VALUES ('$business_type', '$business_name', '$company_name', '$contact_name', '$email', '$phone', '$line_id', '$facebook', '$province', '$district')";

        if ($conn->query($sql) === TRUE) {
            echo "เพิ่มข้อมูลลูกค้าสำเร็จ";
        } else {
            echo "ข้อผิดพลาดในการเพิ่มข้อมูล: " . $conn->error;
        }
    }
}

$conn->close();
?>
