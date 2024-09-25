<?php
require_once '../config/dbconnect.php';

if (isset($_GET['province_id'])) {
    $province_id = $_GET['province_id'];
    $sql = "SELECT id, name_th FROM amphures WHERE province_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $province_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name_th']) . '</option>';
    }

    $stmt->close();
}
?>
