<?php
require_once('../dbconnect.php');

if(isset($_POST['amphure_id'])) {
    $amphure_id = $_POST['amphure_id'];

    // ดึงข้อมูลตำบลจากฐานข้อมูล
    $sql = "SELECT * FROM districts WHERE amphure_id = $amphure_id";
    $result = $conn->query($sql);

    // สร้าง HTML สำหรับตัวเลือกตำบล
    if ($result->num_rows > 0) {
        echo '<option value="">เลือกตำบล</option>';
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name_th'].'</option>';
        }
    } else {
        echo '<option value="">ไม่พบข้อมูลตำบล</option>';
    }
}
$conn->close();
?>
