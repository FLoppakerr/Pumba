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

// Get number of provinces to display
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

// Get data for the current week
$sql = "SELECT province, COUNT(*) as count FROM hotels 
        WHERE YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1) 
        GROUP BY province 
        ORDER BY count DESC 
        LIMIT $limit";

$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
