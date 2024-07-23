<?php
session_start();
require_once('../dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username);
        $stmt->fetch();
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header("Location: ../index.php");
    } else {
        echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'); window.location.href='login.php';</script>";
    }
    $stmt->close();
}
?>
