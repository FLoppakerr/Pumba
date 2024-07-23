<?php
session_start();
require_once('dbconnect.php'); // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามี session user_id หรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีไฟล์ถูกอัพโหลดหรือไม่
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        // กำหนดเส้นทางและชื่อไฟล์ใหม่
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['profile_image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // ตรวจสอบว่าคือไฟล์รูปภาพหรือไม่
        $check = getimagesize($_FILES['profile_image']['tmp_name']);
        if ($check !== false) {
            // ย้ายไฟล์ไปยังโฟลเดอร์ปลายทาง
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                // อัปเดตฐานข้อมูลด้วยเส้นทางของรูปภาพ
                $sql = "UPDATE users SET profile_image = '$target_file' WHERE id = $user_id";
                if ($conn->query($sql) === TRUE) {
                    echo "ไฟล์ถูกอัพโหลดและบันทึกข้อมูลเรียบร้อย";
                    header("Location: edit_profile.php");
                    exit();
                } else {
                    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
                }
            } else {
                echo "เกิดข้อผิดพลาดในการอัพโหลดไฟล์";
            }
        } else {
            echo "ไฟล์ที่อัพโหลดไม่ใช่รูปภาพ";
        }
    } else {
        echo "ไม่มีไฟล์ถูกอัพโหลด";
    }
}

$conn->close();
?>
