<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "customers";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Form Control: Select by.devtai.com</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    label {
      color: black; /* เปลี่ยนสีฟอนต์เป็นสีน้ำเงินเพื่อทดสอบ */
      font-size: 14px; /* ขนาดฟอนต์ */
    }
  </style>
</head>
<body>
<?php
    $sql_provinces = "SELECT * FROM provinces";
    $query = mysqli_query($conn, $sql_provinces);
?>

<div class="container">
  <h2>เลือกจังหวัด อำเภอ ตำบล</h2>
  <p>Code เลือกจังหวัด อำเภอ ตำบล php + mysqli + ajax + jquery + bootstrap :</p>
  <form action="insertdata.php" method="post">
    <div class="form-group">
      <label class="control-label" for="provinces">จังหวัด:</label>
      <select class="form-control" name="Ref_prov_id" id="provinces">
            <option value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
            <?php foreach ($query as $value) { ?>
            <option value="<?= $value['id'] ?>"><?= $value['name_th'] ?></option>
            <?php } ?>
      </select>
      <br>

      <label class="control-label" for="amphures">อำเภอ:</label>
      <select class="form-control" name="Ref_dist_id" id="amphures">
      </select>
      <br>

      <label class="control-label" for="districts">ตำบล:</label>
      <select class="form-control" name="Ref_subdist_id" id="districts">
      </select>
      <br>

      <label class="control-label" for="zip_code">รหัสไปรษณีย์:</label>
      <input type="text" name="zip_code" id="zip_code" class="form-control">
      <br>
      <a href="#">
        <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>
      </a>
    </div>
  </form>
</div>
</body>
</html>
<?php include('script.php'); ?>
