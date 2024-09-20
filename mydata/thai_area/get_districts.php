<?php
require_once '../config/dbconnect.php';

if (isset($_GET['amphure_id'])) {
    $amphure_id = intval($_GET['amphure_id']);
    $sql = "SELECT id, name_th FROM districts WHERE amphure_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $amphure_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<option value=\"" . htmlspecialchars($row['id']) . "\">" . htmlspecialchars($row['name_th']) . "</option>";
    }

    $stmt->close();
}
$conn->close();
?>
