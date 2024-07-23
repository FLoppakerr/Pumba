<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}

require_once('dbconnect.php');

// ตรวจสอบว่ามีพารามิเตอร์ ID ส่งมาหรือไม่
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // เตรียมคำสั่ง SQL สำหรับลบข้อมูล
    $sql = "DELETE FROM customers_data WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // ลบข้อมูล
    if ($stmt->execute()) {
        echo "ลบข้อมูลเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ไม่พบ ID ที่ต้องการลบ";
}

$conn->close();

header("Location: index.php"); // กลับไปยังหน้าแรกหลังจากทำการลบ
exit();
?>
