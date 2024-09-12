<?php
require_once '../config/dbconnect.php';  // ตรวจสอบให้แน่ใจว่าเส้นทางนี้ถูกต้อง

$function = $_POST['function'];
$id = $_POST['id'];

if ($function === 'provinces') {
    $sql = "SELECT * FROM amphures WHERE province_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $options = "<option value=''>เลือกอำเภอ</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['name_th'] . "</option>";
    }
    echo $options;

} elseif ($function === 'amphures') {
    $sql = "SELECT * FROM districts WHERE amphure_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $options = "<option value=''>เลือกตำบล</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['name_th'] . "</option>";
    }
    echo $options;

} elseif ($function === 'districts') {
    $sql = "SELECT zip_code FROM districts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo $row['zip_code'];
    } else {
        echo '';
    }
}

$stmt->close();
$conn->close();
?>
