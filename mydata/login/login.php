<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>
        <span>การจัดการข้อมูลลูกค้า</span>

        <form action="login_process.php" method="post">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้</label>
                <div class="input-icon">
                    <input type="text" id="username" name="username" required>
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <div class="input-icon">
                    <input type="password" id="password" name="password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                เข้าสู่ระบบ
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
