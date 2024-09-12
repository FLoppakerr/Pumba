<?php
require_once '../config/dbconnect.php';

if (isset($_GET['district_id'])) {
    $district_id = intval($_GET['district_id']);
    $sql = "SELECT zip_code FROM districts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $district_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo htmlspecialchars($row['zip_code']);
    }

    $stmt->close();
}
$conn->close();
?>
