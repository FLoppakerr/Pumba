<?php
session_start();
require_once '../config/dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile_image = htmlspecialchars($row['profile_image']);
} else {
    echo "ไม่พบข้อมูลผู้ใช้";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/edit_profile.css">
</head>
<body>
<div class="container full-height">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">แก้ไขโปรไฟล์</h3>
            <?php if (!empty($profile_image)) { ?>
                <img src="../uploads/<?= htmlspecialchars($profile_image) ?>" alt="Profile Image" class="img-fluid rounded">
            <?php } else { ?>
                <p>No profile image set.</p>
            <?php } ?>
            <form action="upload_profile.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="profile_image" class="form-label">เลือกรูปโปรไฟล์:</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                    <button type="submit" class="btn btn-primary">Upload Image</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
