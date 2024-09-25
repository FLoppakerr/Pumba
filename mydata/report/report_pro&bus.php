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

// ตรวจสอบว่ามีการส่งฟอร์มมา (POST Request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $businessType = isset($_POST['business_type']) ? $_POST['business_type'] : ''; 
    $province = isset($_POST['province']) ? $_POST['province'] : ''; 

    if (!empty($businessType)) {
        $sql = "SELECT provinces.name_th AS province, COUNT(customers_data.id) AS business_count 
                FROM customers_data 
                JOIN provinces ON customers_data.province = provinces.id
                WHERE customers_data.business_type = ?
                GROUP BY customers_data.province";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $businessType);
    } elseif (!empty($province)) {
        $sql = "SELECT customers_data.business_type AS business_type, COUNT(customers_data.id) AS business_count 
                FROM customers_data 
                WHERE customers_data.province = ?
                GROUP BY customers_data.business_type";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $province);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // เก็บข้อมูลใน Session
        $_SESSION['rows'] = $rows;
        $_SESSION['businessType'] = $businessType;
        $_SESSION['province'] = $province;

        // บังคับเขียนข้อมูลลง Session
        session_write_close();

        // Redirect เพื่อป้องกันการส่ง POST ซ้ำ
        header("Location: report_pro&bus.php");
        exit();
    } else {
        echo "ไม่มีข้อมูลที่ตรงกับการค้นหา";
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
            <li><a href="report_pro&bus.php">จังหวัด/ธุรกิจ</a></li>
          </ul>
        </li>
        <li>
        <button type="button" class="btn btn-success navbar-btn" onclick="window.location.href='export_pro&bus.php'">Export CSV</button>
        </li>
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
                <th><?= htmlspecialchars(!empty($businessType) ? 'จังหวัดทั้งหมด' : 'ประเภทธุรกิจทั้งหมด') ?></th>
                <th><?= htmlspecialchars(!empty($businessType) ? 'จำนวนธุรกิจในจังหวัดนั้นๆ' : 'จำนวนธุรกิจทั้งหมด') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars(!empty($businessType) ? $row['province'] : $row['business_type']) ?></td>
                        <td><?= htmlspecialchars($row['business_count']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#business_type').change(function() {
    if ($(this).val() !== '') {
        $('#province option[value=""]').hide();
    } else {
        $('#province option[value=""]').show();
    }
});

$('#province').change(function() {
    if ($(this).val() !== '') {
        $('#business_type option[value=""]').hide();
    } else {
        $('#business_type option[value=""]').show();
    }
});

    });
</script>

</body>
</html>
