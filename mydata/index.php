<?php
session_start();
require_once 'config/dbconnect.php';

// ตรวจสอบว่ามี session user_id หรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}

// Query เพื่อดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $profile_image = !empty($row['profile_image']) ? 'uploads/' . $row['profile_image'] : 'path/to/default/profile/image';
} else {
    $username = "Guest";
    $profile_image = "path/to/default/profile/image";
}

// รับค่าค้นหาจากฟอร์ม
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = "%{$search_query}%";

// Query เพื่อดึงข้อมูลลูกค้าตามคำค้นหา
$sql_customers = "SELECT c.id, c.business_type, c.business_name, c.company_name, c.contact_name, c.email, c.phone, c.line_id, c.facebook, p.name_th AS province_name, a.name_th AS amphure_name, d.name_th AS district_name, d.zip_code 
FROM customers_data c
JOIN provinces p ON c.province = p.id
JOIN amphures a ON c.amphure = a.id
JOIN districts d ON c.district = d.id
WHERE c.business_name LIKE ? OR c.contact_name LIKE ?";

$stmt_customers = $conn->prepare($sql_customers);
$stmt_customers->bind_param("ss", $search_query, $search_query);
$stmt_customers->execute();
$result_customers = $stmt_customers->get_result();

// ดึงข้อมูลจังหวัด
$sql_provinces = "SELECT * FROM provinces";
$query_provinces = $conn->query($sql_provinces);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>


<!DOCTYPE html>
<html lang="th">

<head>
  
  <meta charset="UTF-8">
  <title>จัดการข้อมูลลูกค้า</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/modal.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anuphan:wght@400;700&display=swap">

  <script src="thai_area/ajax-functions.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script  defer src="https://code.jquery.com/jquery-3.7.1.js"></script> 
  <script  defer src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
  <script  defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script  defer src="index.js"></script>
  <script  defer src="table.js"></script>

</head>


<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php" style= "margin:15px;">
        <h1 style="margin: 0; font-size: 30px;">HOTEL JOB</h1>
        <h3 style="margin: 0; font-size: 16.4px;">ระบบจัดการข้อมูลลูกค้า</h3>
      </a>
    </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><button type="button" class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#insertModal">เพิ่มข้อมูล</button></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if (!empty($profile_image)) : ?>
                <img src="<?= $profile_image ?>" class="profile-img" alt="Profile Image">
              <?php else : ?>
                โปรไฟล์
              <?php endif; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">
                <div >
                  <?php if (!empty($profile_image)) : ?>
                    <img src="<?= $profile_image ?>" class="profile-img" alt="Profile Image">
                  <?php else : ?>
                    โปรไฟล์
                  <?php endif; ?>
                  <?= htmlspecialchars($username) ?>
                </div>
              </li>
              <li role="separator" class="divider"></li>
              <li><a href="profile/edit_profile.php">แก้ไขโปรไฟล์</a></li>
              <li><a href="login/logout.php">ออกจากระบบ</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container-fluid">
      <button type="button" class="btn btn-success" onclick="window.location.href='export.php'">
         <i class="fas fa-file-excel"></i> Export to Excel
       </button>
    <table id="example" class="" style="width:100%">
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
        <?php if ($result_customers->num_rows > 0) : ?>
          <?php while ($row = $result_customers->fetch_assoc()) : ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['business_type']) ?></td>
              <td><?= htmlspecialchars($row['business_name']) ?></td>
              <td><?= htmlspecialchars($row['company_name']) ?></td>
              <td><?= htmlspecialchars($row['contact_name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><?= htmlspecialchars($row['line_id']) ?></td>
              <td><?= htmlspecialchars($row['facebook']) ?></td>
              <td><?= htmlspecialchars($row['province_name']) ?></td>
              <td><?= htmlspecialchars($row['amphure_name']) ?></td>
              <td><?= htmlspecialchars($row['district_name']) ?></td>
              <td><?= htmlspecialchars($row['zip_code']) ?></td>
              <td><a href="customers/editdata.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-warning btn-xs">
                <i class="fas fa-edit"></i> แก้ไข</a>
                <a href="customers/deletedata.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?')">
                <i class="fas fa-trash-alt"></i> ลบ</a></td>
            </tr>
          <?php endwhile; ?>
        <?php else : ?>
          <tr>
            <td colspan="14" class="text-center">ไม่พบข้อมูล</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

<!-- Modal สำหรับเพิ่มข้อมูล -->
<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="insertModalLabel">เพิ่มข้อมูลลูกค้า</h4>
            </div>
            <div class="modal-body">
                <form id="insertForm">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="business_type">ประเภทธุรกิจ:</label>
                            <input type="text" class="form-control" id="business_type" name="business_type" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="business_name">ชื่อธุรกิจ:</label>
                            <input type="text" class="form-control" id="business_name" name="business_name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="company_name">ชื่อบริษัท:</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="contact_name">ชื่อผู้ติดต่อ:</label>
                            <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="phone">โทรศัพท์:</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="line_id">Line ID:</label>
                            <input type="text" class="form-control" id="line_id" name="line_id">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="facebook">Facebook:</label>
                            <input type="text" class="form-control" id="facebook" name="facebook">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="province">จังหวัด:</label>
                            <select class="form-control" id="province" name="province" required>
                                <option value="">เลือกจังหวัด</option>
                                <!-- PHP loop for provinces -->
                                <?php while ($province = $query_provinces->fetch_assoc()) : ?>
                                    <option value="<?= htmlspecialchars($province['id']) ?>">
                                        <?= htmlspecialchars($province['name_th']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="amphure">อำเภอ:</label>
                            <select class="form-control" id="amphure" name="amphure" required>
                                <option value="">เลือกอำเภอ</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="district">ตำบล:</label>
                            <select class="form-control" id="district" name="district" required>
                                <option value="">เลือกตำบล</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="zip_code">รหัสไปรษณีย์:</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
