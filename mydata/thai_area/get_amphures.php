<?php
require_once '../config/dbconnect.php';

// เปิดการแสดงข้อผิดพลาด
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['province_id'])) {
    $province_id = intval($_GET['province_id']);
    $sql = "SELECT id, name_th FROM amphures WHERE province_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $province_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"" . htmlspecialchars($row['id']) . "\">" . htmlspecialchars($row['name_th']) . "</option>";
        }

        $stmt->close();
    } else {
        echo "Error: Could not prepare SQL statement.";
    }
} else {
    echo "Error: No province_id provided.";
}

$conn->close();
?>
