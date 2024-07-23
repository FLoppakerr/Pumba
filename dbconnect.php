<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "customers";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");

// Function to get list of provinces
function getProvinceList() {
    global $conn;
    $sql = "SELECT id, name_th FROM provinces";
    $result = $conn->query($sql);
    $provinces = [];
    while ($row = $result->fetch_assoc()) {
        $provinces[] = $row;
    }
    return $provinces;
}

// Function to get list of amphures (districts)
function getAmphureList() {
    global $conn;
    $sql = "SELECT id, name_th FROM amphures";
    $result = $conn->query($sql);
    $amphures = [];
    while ($row = $result->fetch_assoc()) {
        $amphures[] = $row;
    }
    return $amphures;
}

// Function to get list of districts
function getDistrictList() {
    global $conn;
    $sql = "SELECT id, name_th FROM districts";
    $result = $conn->query($sql);
    $districts = [];
    while ($row = $result->fetch_assoc()) {
        $districts[] = $row;
    }
    return $districts;
}

// ในไฟล์ dbconnect.php ในฟังก์ชั่น getZipCode()
function getZipCode($district_id) {
    global $conn;

    // ใช้ prepared statement เพื่อป้องกัน SQL injection
    $query = "SELECT zip_code FROM districts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $district_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบว่า query ทำงานได้หรือไม่
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['zip_code'];
    } else {
        return null; // หรือค่าที่เหมาะสมตามต้องการเมื่อไม่พบข้อมูล
    }
}



?>
