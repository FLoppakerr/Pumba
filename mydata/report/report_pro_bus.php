<?php
ini_set('session.cookie_lifetime', 0);  // ให้แน่ใจว่า session ใช้ในชีวิต browser
ini_set('session.use_strict_mode', 1);  // บังคับใช้ Session อย่างเข้มงวด
session_start();
require_once '../config/dbconnect.php';

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    // ตรวจสอบว่ามีรูปโปรไฟล์หรือไม่ ถ้าไม่มีให้ใช้รูปโปรไฟล์เริ่มต้น
    $profile_image = !empty($row['profile_image']) ? '../uploads/' . $row['profile_image'] : '../uploads/default_profile_image.png';
} else {
    $username = "Guest";
    $profile_image = "../uploads/default_profile_image.png";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $businessType = isset($_POST['business_type']) ? $_POST['business_type'] : ''; 
    $province = isset($_POST['province']) ? $_POST['province'] : ''; 

    if (empty($businessType) && empty($province)) {
        die('Please select either a business type or a province.');
    }

    if (!empty($businessType) && !empty($province)) {
        // Query สำหรับกรณีที่ผู้ใช้เลือกทั้งประเภทธุรกิจและจังหวัด
        $sql = "SELECT business_type, COUNT(id) AS business_count 
                FROM customers_data 
                WHERE business_type = ? AND province = ?
                GROUP BY business_type";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Error preparing statement for business type and province: ' . $conn->error);
        }

        $stmt->bind_param("si", $businessType, $province);
    } elseif (!empty($businessType)) {
        // Query สำหรับกรณีที่ผู้ใช้เลือกเฉพาะประเภทธุรกิจ
        $sql = "SELECT provinces.name_th AS province, COUNT(customers_data.id) AS business_count 
                FROM customers_data 
                JOIN provinces ON customers_data.province = provinces.id
                WHERE customers_data.business_type = ?
                GROUP BY customers_data.province";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Error preparing statement for business type: ' . $conn->error);
        }

        $stmt->bind_param("s", $businessType);
    } elseif (!empty($province)) {
        // Query สำหรับกรณีที่ผู้ใช้เลือกเฉพาะจังหวัด
        $sql = "SELECT customers_data.business_type AS business_type, COUNT(customers_data.id) AS business_count 
                FROM customers_data 
                WHERE customers_data.province = ?
                GROUP BY customers_data.business_type";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Error preparing statement for province: ' . $conn->error);
        }

        $stmt->bind_param("i", $province);
    }

    if (!$stmt->execute()) {
        die('Error executing query: ' . $stmt->error);
    }

    $result = $stmt->get_result(); // ดึงผลลัพธ์จาก statement ที่ execute แล้ว

    if ($result && $result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    
        // เก็บข้อมูลใน Session
        $_SESSION['rows'] = $rows;
        $_SESSION['businessType'] = $businessType;
        $_SESSION['province'] = $province;
    
        // บังคับเขียนข้อมูลลง Session
        session_write_close();
    
        // Redirect เพื่อป้องกันการส่ง POST ซ้ำ
        header("Location: report_pro_bus.php");
        exit();
    } else {
        // ถ้าไม่มีข้อมูลที่ตรงกับการค้นหา ให้เคลียร์ข้อมูลที่เคยมี
        $_SESSION['rows'] = [];
        $_SESSION['businessType'] = $businessType;
        $_SESSION['province'] = $province;
    
        session_write_close();
        header("Location: report_pro_bus.php");
        exit();
    }
}

// ดึงข้อมูลจาก Session หลังการ redirect
$rows = isset($_SESSION['rows']) ? $_SESSION['rows'] : [];
$businessType = isset($_SESSION['businessType']) ? $_SESSION['businessType'] : '';
$province = isset($_SESSION['province']) ? $_SESSION['province'] : '';

// ดึงข้อมูลเพื่อเติม Dropdown
$sql_provinces = "SELECT * FROM provinces";
$query_provinces = $conn->query($sql_provinces);

$sql_business_types = "SELECT DISTINCT business_type FROM customers_data";
$query_business_types = $conn->query($sql_business_types);

$conn->close();

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางจำนวนธุรกิจในแต่ละจังหวัด</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/report.css">
    <link rel="stylesheet" href="../styles/table.css">
    <link rel="stylesheet" href="../styles/report_province.css">
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
        <h3 style="margin: 0; font-size: 16.4px;">จังหวัด/ธุรกิจ</h3>
      </a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle btn btn-info navbar-btn" data-toggle="dropdown">สรุปรายงาน <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="report_province.php">จังหวัดทั้งหมด</a></li>
            <li><a href="report_business_type.php">ธุรกิจทั้งหมด</a></li>
            <li><a href="report_pro_bus.php">จังหวัด/ธุรกิจ</a></li>
          </ul>
        </li>
        <li>
        <button type="button" class="btn btn-success navbar-btn" onclick="window.location.href='export_pro_bus.php'">Export CSV</button>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?= htmlspecialchars($profile_image) ?>" class="profile-img" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%;">
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
    </div>
  </div>
</nav>

<h1>สรุปรายงานธุรกิจ/จังหวัด</h1>
<!-- ฟอร์มการกรองข้อมูล -->
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">กรองข้อมูล</h3>
        </div>
        <div class="panel-body">
            <form method="POST" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="business_type">ประเภทธุรกิจ:</label>
                            <select class="form-control" id="business_type" name="business_type">
                                <option value="">เลือกประเภทธุรกิจ</option>
                                <?php while ($businessTypeOption = $query_business_types->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($businessTypeOption['business_type']) ?>" <?= $businessType == $businessTypeOption['business_type'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($businessTypeOption['business_type']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="province">จังหวัด:</label>
                            <select class="form-control" id="province" name="province">
                                <option value="">เลือกจังหวัด</option>
                                <?php while ($provinceOption = $query_provinces->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($provinceOption['id']) ?>" <?= $province == $provinceOption['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($provinceOption['name_th']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">ค้นหา</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ตารางแสดงผล -->
<div class="table-container">
    <table id="example" class="table display">
        <thead>
            <tr>
                <?php if (!empty($businessType) && !empty($province)): ?>
                    <!-- กรณีที่เลือกทั้งประเภทธุรกิจและจังหวัด -->
                    <th>ธุรกิจ</th>
                    <th>จำนวนธุรกิจ</th>
                <?php elseif (!empty($businessType)): ?>
                    <!-- กรณีที่เลือกเฉพาะประเภทธุรกิจ -->
                    <th>จังหวัด</th>
                    <th>จำนวนธุรกิจในจังหวัดนั้นๆ</th>
                <?php elseif (!empty($province)): ?>
                    <!-- กรณีที่เลือกเฉพาะจังหวัด -->
                    <th>ประเภทธุรกิจ</th>
                    <th>จำนวนธุรกิจทั้งหมด</th>
                <?php endif; ?>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php if (!empty($businessType) && !empty($province)): ?>
                            <!-- กรณีที่เลือกทั้งประเภทธุรกิจและจังหวัด -->
                            <td><?= htmlspecialchars($row['business_type']) ?></td>
                            <td><?= htmlspecialchars($row['business_count']) ?></td>
                        <?php elseif (!empty($businessType)): ?>
                            <!-- กรณีที่เลือกเฉพาะประเภทธุรกิจ -->
                            <td><?= htmlspecialchars(isset($row['province']) ? $row['province'] : '') ?></td>
                            <td><?= htmlspecialchars($row['business_count']) ?></td>
                        <?php elseif (!empty($province)): ?>
                            <!-- กรณีที่เลือกเฉพาะจังหวัด -->
                            <td><?= htmlspecialchars($row['business_type']) ?></td>
                            <td><?= htmlspecialchars($row['business_count']) ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
</script>

</body>
</html>
