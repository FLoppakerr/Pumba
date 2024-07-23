<?php
session_start();
require_once('dbconnect.php'); // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามี session user_id หรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}

// Query เพื่อดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, profile_image FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $profile_image = !empty($row['profile_image']) ? $row['profile_image'] : "path/to/default/profile/image"; // กำหนดรูปโปรไฟล์เริ่มต้น (ถ้าต้องการ)
} else {
    $username = "Guest"; // หากไม่พบข้อมูลผู้ใช้
    $profile_image = "path/to/default/profile/image"; // กำหนดรูปโปรไฟล์เริ่มต้น (ถ้าต้องการ)
}

$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขโปรไฟล์</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>แก้ไขโปรไฟล์ของ <?php echo $username; ?></h2>

    <!-- แสดงรูปโปรไฟล์ -->
    <img src="<?php echo $profile_image; ?>" class="profile-img" alt="Profile Image">

    <!-- แบบฟอร์มอัพโหลดรูปโปรไฟล์ -->
    <form action="upload_profile.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="profile_image">อัพโหลดรูปโปรไฟล์ใหม่:</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image">
        </div>
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
</div>

</body>
</html>
