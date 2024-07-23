<?php
require_once('../dbconnect.php');

if(isset($_POST['province_id'])) {
    $province_id = $_POST['province_id'];

    // ดึงข้อมูลอำเภอจากฐานข้อมูล
    $sql = "SELECT * FROM amphures WHERE province_id = $province_id";
    $result = $conn->query($sql);

    // สร้าง HTML สำหรับตัวเลือกอำเภอ
    if ($result->num_rows > 0) {
        echo '<option value="">เลือกอำเภอ</option>';
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name_th'].'</option>';
        }
    } else {
        echo '<option value="">ไม่พบข้อมูลอำเภอ</option>';
    }
}
$conn->close();
?>
