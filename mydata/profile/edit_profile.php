<?php
session_start();
require_once '../config/dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ดึงข้อมูลรูปภาพปัจจุบันจากฐานข้อมูล
$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile_image = htmlspecialchars($row['profile_image']);
} else {
    echo "No user found";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="edit_profile.css"> <!-- ลิงก์ไปยังไฟล์ styles.css -->
</head>
<body>

<div class="container full-height">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">แก้ไขโปรไฟล์</h3>
            <?php if (!empty($profile_image)) { ?>
                <img src="../uploads/<?php echo $profile_image; ?>" alt="Profile Image" class="img-fluid rounded">
            <?php } else { ?>
                <p>No profile image set.</p>
            <?php } ?>
            <!-- ฟอร์มสำหรับอัปโหลดไฟล์รูปภาพ -->
            <form action="upload_profile.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Select Profile Image:</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                    <button type="submit" class="btn btn-primary">Upload Image</button>
                </div>

                
            </form>

            <hr class="my-4">
        
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>
</html>