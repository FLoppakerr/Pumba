<?php
require_once('dbconnect.php');

// ตรวจสอบว่ามีการส่งค่า id มาหรือไม่
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ดึงข้อมูลลูกค้าตาม id
    $sql = "SELECT * FROM customers_data WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
} else {
    echo "ไม่มีข้อมูล";
    exit;
}

// อัปเดตข้อมูลลูกค้า
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $business_type = $_POST['business_type'];
    $business_name = $_POST['business_name'];
    $company_name = $_POST['company_name'];
    $contact_name = $_POST['contact_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $line_id = $_POST['line_id'];
    $facebook = $_POST['facebook'];
    $province = $_POST['province'];
    $amphure = $_POST['amphure'];
    $district = $_POST['district'];
    $zip_code = $_POST['zip_code'];

    $sql = "UPDATE customers_data SET business_type = ?, business_name = ?, company_name = ?, contact_name = ?, email = ?, phone = ?, line_id = ?, facebook = ?, province = ?, amphure = ?, district = ?, zip_code = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssi", $business_type, $business_name, $company_name, $contact_name, $email, $phone, $line_id, $facebook, $province, $amphure, $district, $zip_code, $id);

    if ($stmt->execute()) {
        echo "อัปเดตข้อมูลสำเร็จ";
        header("Location: index.php");
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขข้อมูลลูกค้า</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>แก้ไขข้อมูลลูกค้า</h2>
  <form action="" method="post">
    <div class="form-group">
      <label for="business_type">ประเภทธุรกิจ:</label>
      <input type="text" class="form-control" id="business_type" name="business_type" value="<?php echo $customer['business_type']; ?>">
    </div>
    <div class="form-group">
      <label for="business_name">ชื่อธุรกิจ:</label>
      <input type="text" class="form-control" id="business_name" name="business_name" value="<?php echo $customer['business_name']; ?>">
    </div>
    <div class="form-group">
      <label for="company_name">ชื่อบริษัท:</label>
      <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $customer['company_name']; ?>">
    </div>
    <div class="form-group">
      <label for="contact_name">ชื่อผู้ติดต่อ:</label>
      <input type="text" class="form-control" id="contact_name" name="contact_name" value="<?php echo $customer['contact_name']; ?>">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo $customer['email']; ?>">
    </div>
    <div class="form-group">
      <label for="phone">โทรศัพท์:</label>
      <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $customer['phone']; ?>">
    </div>
    <div class="form-group">
      <label for="line_id">Line ID:</label>
      <input type="text" class="form-control" id="line_id" name="line_id" value="<?php echo $customer['line_id']; ?>">
    </div>
    <div class="form-group">
      <label for="facebook">Facebook:</label>
      <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $customer['facebook']; ?>">
    </div>
    <div class="form-group">
      <label class="control-label" for="provinces">จังหวัด:</label>
      <select class="form-control" name="province" id="provinces">
        <option value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
        <?php foreach (getProvinceList() as $province) { ?>
          <option value="<?php echo $province['id']; ?>" <?php if ($customer['province'] == $province['id']) echo 'selected'; ?>><?php echo $province['name_th']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label class="control-label" for="amphures">อำเภอ:</label>
      <select class="form-control" name="amphure" id="amphures">
        <option value="" selected disabled>-กรุณาเลือกอำเภอ-</option>
      </select>
    </div>
    <div class="form-group">
      <label class="control-label" for="districts">ตำบล:</label>
      <select class="form-control" name="district" id="districts">
        <option value="" selected disabled>-กรุณาเลือกตำบล-</option>
      </select>
    </div>
    <div class="form-group">
      <label for="zip_code">รหัสไปรษณีย์:</label>
      <select class="form-control" id="zip_code" name="zip_code">
        <option value="" selected disabled>-กรุณาเลือกรหัสไปรษณีย์-</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
  </form>
</div>

<script>
$(document).ready(function(){
    var province_id = '<?php echo $customer['province']; ?>';
    var amphure_id = '<?php echo $customer['amphure']; ?>';
    var district_id = '<?php echo $customer['district']; ?>';

    if(province_id){
        $.ajax({
            type: 'POST',
            url: 'thai_area/get_amphures.php',
            data: { province_id: province_id },
            success: function(html){
                $('#amphures').html(html);
                $('#amphures').val(amphure_id);
                if(amphure_id){
                    $.ajax({
                        type: 'POST',
                        url: 'thai_area/get_districts.php',
                        data: { amphure_id: amphure_id },
                        success: function(html){
                            $('#districts').html(html);
                            $('#districts').val(district_id);
                            if(district_id){
                                $.ajax({
                                    type: 'POST',
                                    url: 'thai_area/get_zip_code.php',
                                    data: { district_id: district_id },
                                    success: function(response){
                                        $('#zip_code').html(response);
                                        $('#zip_code').val('<?php echo $customer['zip_code']; ?>');
                                    }
                                });
                            }
                        }
                    });
                }
            }
        });
    }

    $('#provinces').change(function(){
        var province_id = $(this).val();
        if(province_id){
            $.ajax({
                type:'POST',
                url:'thai_area/get_amphures.php',
                data:{province_id: province_id},
                success:function(html){
                    $('#amphures').html(html);
                    $('#districts').html('<option value="">-กรุณาเลือกตำบล-</option>');
                }
            });
        } else {
            $('#amphures').html('<option value="">-กรุณาเลือกอำเภอ-</option>');
            $('#districts').html('<option value="">-กรุณาเลือกตำบล-</option>');
        }
    });

    $('#amphures').change(function(){
        var amphure_id = $(this).val();
        if(amphure_id){
            $.ajax({
                type:'POST',
                url:'thai_area/get_districts.php',
                data:{amphure_id: amphure_id},
                success:function(html){
                    $('#districts').html(html);
                }
            });
        } else {
            $('#districts').html('<option value="">-กรุณาเลือกตำบล-</option>');
        }
    });

    $('#districts').change(function(){
        var district_id = $(this).val();
        if(district_id){
            $.ajax({
                type:'POST',
                url:'thai_area/get_zip_code.php',
                data:{district_id: district_id},
                success:function(response){
                    $('#zip_code').html(response);
                }
            });
        } else {
            $('#zip_code').html('<option value="">-กรุณาเลือกรหัสไปรษณีย์-</option>');
        }
    });
});
</script>

</body>
</html>
