<?php
require_once('../dbconnect.php');

if (isset($_POST['district_id'])) {
    $district_id = $_POST['district_id'];
    $sql = "SELECT zip_code FROM districts WHERE id = $district_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['zip_code'] . '">' . $row['zip_code'] . '</option>';
        }
    } else {
        echo '<option value="" selected disabled>-ไม่พบรหัสไปรษณีย์-</option>';
    }
} else {
    echo '<option value="" selected disabled>-กรุณาเลือกรหัสไปรษณีย์-</option>';
}

$conn->close();
?>
