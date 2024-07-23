<?php
// Include database connection file
require_once('dbconnect.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT cd.id, cd.business_type, cd.business_name, cd.company_name, cd.contact_name, cd.email, cd.phone, cd.line_id, cd.facebook, 
        p.name_th AS province_name, a.name_th AS amphure_name, d.name_th AS district_name, cd.zip_code
        FROM customers_data cd
        INNER JOIN provinces p ON cd.province = p.id
        INNER JOIN amphures a ON cd.amphure = a.id
        INNER JOIN districts d ON cd.district = d.id";

if (!empty($search)) {
    $sql .= " WHERE cd.business_name LIKE '%$search%' OR cd.company_name LIKE '%$search%' OR cd.contact_name LIKE '%$search%'";
}
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ผลการค้นหาข้อมูลลูกค้า</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>ผลการค้นหาข้อมูลลูกค้า</h2>
  
  <!-- แบบฟอร์มค้นหา -->
  <form class="form-inline" action="search.php" method="get">
    <div class="form-group">
      <label for="search">ค้นหา:</label>
      <input type="text" class="form-control" id="search" placeholder="ค้นหา" name="search" value="<?php echo htmlspecialchars($search); ?>">
    </div>
    <button type="submit" class="btn btn-default">ค้นหา</button>
  </form>
  <br>

  <!-- ตารางแสดงข้อมูล -->
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
    <?php if ($result->num_rows > 0) : ?>
        <?php while($row = $result->fetch_assoc()) : ?>
            <tr>
                <!-- แสดงข้อมูลของแต่ละแถว -->
            </tr>
        <?php endwhile; ?>
    <?php else : ?>
        <tr><td colspan='14'>ไม่พบข้อมูล</td></tr>
    <?php endif; ?>
    </tbody>
  </table>

</div>

</body>
</html>
