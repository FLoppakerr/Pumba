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
// ดึงข้อมูลลูกค้า
include_once 'get_customers.php';

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>จัดการข้อมูลลูกค้า</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <script src="thai_area/ajax-functions.js"></script>
  <style>
      .profile-img {
          max-width: 30px;
          max-height: 30px;
          border-radius: 50%;
          margin-right: 1px;
      }
  </style>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <form class="navbar-form" action="index.php" method="get">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="ค้นหา" name="search">
            </div>
            <button type="submit" class="btn btn-default">ค้นหา</button>
          </form>
        </li>
        <li><button type="button" class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#insertModal">เพิ่มข้อมูล</button></li>
        <li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <?php
    // แสดงรูปโปรไฟล์
    if (!empty($profile_image)) {
        echo '<img src="' . $profile_image . '" class="profile-img" alt="Profile Image">';
    } else {
        echo 'โปรไฟล์';
    }
    ?>
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">
    <li class="dropdown-header">
      <div>
        <?php
        // แสดงรูปโปรไฟล์
        if (!empty($profile_image)) {
            echo '<img src="' . $profile_image . '" class="profile-img" alt="Profile Image">';
        } else {
            echo 'โปรไฟล์';
        }
        ?>
        <?php echo $username; ?>
    </div>
      </li>
        <li role="separator" class="divider"></li>
          <li><a href="edit_profile.php">แก้ไขโปรไฟล์</a></li>
            <li><a href="login/logout.php">ออกจากระบบ</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid">
  <h2>จัดการข้อมูลลูกค้า</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>ประเภทธุรกิจ</th>
        <th>ชื่อธุรกิจ</th>
        <th>ชื่อบริษัท</th>
        <th>ชื่อผู้ติดต่อ</th>
        <th>Email</th>
        <th>โทรศัพท์</th>
        <th>Line ID</th>
        <th>Facebook</th>
        <th>จังหวัด</th>
        <th>อำเภอ</th>
        <th>ตำบล</th>
        <th>รหัสไปรษณีย์</th>
        <th>การจัดการ</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if ($result_customers->num_rows > 0) {
        while($row = $result_customers->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['business_type']."</td>";
            echo "<td>".$row['business_name']."</td>";
            echo "<td>".$row['company_name']."</td>";
            echo "<td>".$row['contact_name']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['phone']."</td>";
            echo "<td>".$row['line_id']."</td>";
            echo "<td>".$row['facebook']."</td>";
            echo "<td>".$row['province_name']."</td>";
            echo "<td>".$row['amphure_name']."</td>";
            echo "<td>".$row['district_name']."</td>";
            echo "<td>".$row['zip_code']."</td>";
            echo '<td>
                    <a href="editdata.php?id='.$row['id'].'" class="btn btn-warning btn-xs">แก้ไข</a>
                    <a href="deletedata.php?id='.$row['id'].'" class="btn btn-danger btn-xs" onclick="return confirm(\'คุณต้องการลบข้อมูลนี้หรือไม่?\')">ลบ</a>
                  </td>';
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='14'>ไม่พบข้อมูล</td></tr>";
    }
    ?>
    </tbody>
  </table>
</div>

<!-- Modal เพิ่มข้อมูล -->
<div id="insertModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">เพิ่มข้อมูลลูกค้าใหม่</h4>
      </div>
      <div class="modal-body">
        <form action="insertdata.php" method="post">
          <!-- แบบฟอร์มใส่ข้อมูล -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
