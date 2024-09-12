<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Anuphan', sans-serif;
            background: linear-gradient(135deg, #E3F2FD 0%, #1E88E5 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 90%;
            max-width: 400px;
        }

        h2 {
            color: #1565C0;
            text-align: center;
            margin-bottom: 10px;
            font-weight: 600;
            font-size: 28px;
        }

        span {
            color: #1565C0;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 400;
            font-size: 20px;
            display: block;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #1976D2;
            font-weight: 400;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 10px;
            border: none;
            border-bottom: 2px solid #90CAF9;
            background-color: transparent;
            transition: border-color 0.3s;
            font-size: 16px;
            color: #1565C0;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1565C0;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #1E88E5, #1565C0);
            border: none;
            border-radius: 25px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(30, 136, 229, 0.3);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #64B5F6;
            cursor: pointer;
            font-size: 18px;
        }

        .btn-login i {
            margin-right: 10px;
        }

        .toggle-password {
            cursor: pointer;
        }

        ::placeholder {
            color: #90CAF9;
        }

        /* Responsive styles */
        @media screen and (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                width: 95%;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                font-size: 14px;
            }

            .form-group input {
                font-size: 14px;
                padding: 10px 8px;
            }

            .btn-login {
                font-size: 16px;
                padding: 12px;
            }

            .input-icon i {
                font-size: 16px;
            }
        }

        @media screen and (min-width: 481px) and (max-width: 768px) {
            .login-container {
                padding: 35px 25px;
                width: 80%;
            }

            h2 {
                font-size: 26px;
            }
        }
    </style>
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
