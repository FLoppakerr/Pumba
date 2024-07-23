<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>เข้าสู่ระบบ</h2>
    <form action="login_process.php" method="post">
        <div class="form-group">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">รหัสผ่าน:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
    </form>
</div>
</body>
</html>
