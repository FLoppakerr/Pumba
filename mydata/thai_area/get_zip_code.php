<?php
require_once '../config/dbconnect.php';

if (isset($_GET['district_id'])) {
    $district_id = $_GET['district_id'];
    $sql = "SELECT zip_code FROM districts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $district_id);
    $stmt->execute();
    $stmt->bind_result($zip_code);
    $stmt->fetch();

    echo htmlspecialchars($zip_code);
    $stmt->close();
}
?>
