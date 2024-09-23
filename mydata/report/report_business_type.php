<?php
require_once '../config/dbconnect.php'; // ตรวจสอบว่ามีการเชื่อมต่อฐานข้อมูลที่ถูกต้อง

// กำหนดค่าเริ่มต้นสำหรับรูปโปรไฟล์และชื่อผู้ใช้
$profile_image = '../uploads/default_profile_image.jpg'; // กรณีที่ไม่พบรูปโปรไฟล์ ใช้รูปเริ่มต้น
$username = 'Guest'; // ค่าเริ่มต้นสำหรับชื่อผู้ใช้

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่ (สมมติว่ามี session สำหรับผู้ใช้)
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Query เพื่อดึงรูปโปรไฟล์และชื่อผู้ใช้จากฐานข้อมูล
    $sql_user = "SELECT profile_image, username FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql_user);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result_user = $stmt->get_result();

    if ($result_user->num_rows > 0) {
        $user_data = $result_user->fetch_assoc();
        if (!empty($user_data['profile_image'])) {
            $profile_image = '../uploads/' . $user_data['profile_image']; // รูปโปรไฟล์จากฐานข้อมูล
        }
        $username = $user_data['username']; // ชื่อผู้ใช้จากฐานข้อมูล
    }
}

// Query SQL สำหรับดึงข้อมูลประเภทธุรกิจและจำนวน
$sql = "SELECT business_type, COUNT(*) AS count
        FROM customers_data
        GROUP BY business_type
        ORDER BY count DESC";

// ดึงข้อมูลจากฐานข้อมูล
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางนับจำนวนประเภทธุรกิจ</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/report.css">
    <link rel="stylesheet" href="../styles/table.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script defer src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script defer src="../js/table.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../index.php" style="margin:15px;">
        <h1 style="margin: 0; font-size: 30px;">HOTEL JOB</h1>
        <h3 style="margin: 0; font-size: 16.4px;">สรุปรายงานธุรกิจ</h3>
      </a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-left">
        <!-- ปุ่ม Export CSV ย้ายมาด้านหน้าสุด -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- Dropdown สำหรับสรุปรายงาน -->
        <li>
        <button type="button" class="btn btn-success navbar-btn" onclick="window.location.href='export_business_type.php'">Export CSV</button>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle btn btn-info navbar-btn" data-toggle="dropdown">สรุปรายงาน <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="report_hotels.php">โรงแรม</a></li>
            <li><a href="report_business_type.php">ประเภทธุรกิจ</a></li>
            <li><a href="report_province.php">จังหวัด</a></li>
          </ul>
        </li>

        <!-- แสดงโปรไฟล์ผู้ใช้ -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?= htmlspecialchars($profile_image) ?>" class="profile-img" alt="Profile Image">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">
              <div>
                <img src="<?= htmlspecialchars($profile_image) ?>" class="profile-img" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%;">
                <?= htmlspecialchars($username) ?>
              </div>
            </li>
            <li role="separator" class="divider"></li>
            <li><a href="../profile/edit_profile.php">แก้ไขโปรไฟล์</a></li>
            <li><a href="../login/logout.php">ออกจากระบบ</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<h1>สรุปรายงานจำนวนประเภทธุรกิจ</h1>

<div class="table-container">
    <table id="example" class="table" style="width:100%">
        <thead>
            <tr>
                <th>ประเภทธุรกิจ</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['business_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['count']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>ไม่พบข้อมูล</td></tr>";
            }

            // ปิดการเชื่อมต่อฐานข้อมูล
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
