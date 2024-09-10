<?php
session_start();
require_once '../config/dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ตรวจสอบว่าไฟล์ได้รับการส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];

    // ตรวจสอบข้อผิดพลาดการอัปโหลด
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading file.";
        exit();
    }

    // ตรวจสอบขนาดของไฟล์ (ตัวอย่าง: 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        echo "File is too large.";
        exit();
    }

    // ตรวจสอบประเภทของไฟล์
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        echo "Invalid file type.";
        exit();
    }

    // กำหนดเส้นทางที่ต้องการเก็บไฟล์
    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_name = basename($file['name']);
    $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $file_name); // Sanitize file name
    $upload_file = $upload_dir . $file_name;

    // ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
    if (move_uploaded_file($file['tmp_name'], $upload_file)) {
        // อัปเดตเส้นทางของไฟล์ในฐานข้อมูล
        $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
        $stmt->bind_param("si", $file_name, $user_id);

        if ($stmt->execute()) {
            // เปลี่ยนเส้นทางไปยัง index.php หลังจากการอัปเดตสำเร็จ
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error updating profile image: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to move uploaded file.";
    }
}

$conn->close();
?>
