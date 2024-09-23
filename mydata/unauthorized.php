<?php
session_start();
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>การเข้าถึงไม่อนุญาต</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <style>
    .container {
      margin-top: 50px;
    }
    .jumbotron {
      text-align: center;
      background-color: #f2dede;
      color: #a94442;
      border: 1px solid #ebccd1;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="jumbotron">
      <h1>การเข้าถึงไม่อนุญาต</h1>
      <p>คุณไม่มีสิทธิ์ในการเข้าถึงหน้านี้</p>
      <p><a href="login/login.php" class="btn btn-primary">กลับไปหน้าเข้าสู่ระบบ</a></p>
    </div>
  </div>
</body>
</html>
