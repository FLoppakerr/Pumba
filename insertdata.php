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

$sql_provinces = "SELECT * FROM provinces";
$query = mysqli_query($conn, $sql_provinces);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลลูกค้า</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        label {
            color: black;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Modal Content -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">เพิ่มข้อมูลลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="insertCustomerForm">
                        <div class="form-group">
                            <label for="business_type">ประเภทธุรกิจ</label>
                            <input type="text" class="form-control" id="business_type" name="business_type" placeholder="ใส่ประเภทธุรกิจ">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_name">ชื่อในการดำเนินธุรกิจ</label>
                                    <input type="text" class="form-control" id="business_name" name="business_name" placeholder="ใส่ชื่อที่ใช้ดำเนินธุรกิจ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">ชื่อบริษัท</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="ใส่ชื่อบริษัท">
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_name">ชื่อผู้ติดต่อ</label>
                                    <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="ใส่ชื่อผู้ติดต่อ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">อีเมล</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="ใส่อีเมล">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">เบอร์โทร</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="ใส่เบอร์โทร">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="line_id">LineID</label>
                                    <input type="text" class="form-control" id="line_id" name="line_id" placeholder="ใส่ LineID">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook" placeholder="ใส่ Facebook">
                                </div>
                            </div>
                        </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="addCustomerBtn">เพิ่มข้อมูลลูกค้า</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#addCustomerBtn').click(function () {
                $.ajax({
                    type: 'POST',
                    url: 'insertdata.php',
                    data: $('#insertCustomerForm').serialize(),
                    success: function(response) {
                        alert(response); // Display server response
                        $('#addCustomerModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                    }
                });
            });

            $('#addCustomerModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset(); // Reset form fields when modal is closed
            });

            $('#provinces').change(function() {
                var id_province = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "ajax_db.php",
                    data: {id:id_province,function:'provinces'},
                    success: function(data){
                        $('#amphures').html(data); 
                        $('#districts').html(' '); 
                        $('#districts').val(' ');  
                        $('#zip_code').val(' '); 
                    }
                });
            });

            $('#amphures').change(function() {
                var id_amphures = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "ajax_db.php",
                    data: {id:id_amphures,function:'amphures'},
                    success: function(data){
                        $('#districts').html(data);  
                    }
                });
            });

            $('#districts').change(function() {
                var id_districts= $(this).val();
                $.ajax({
                    type: "POST",
                    url: "ajax_db.php",
                    data: {id:id_districts,function:'districts'},
                    success: function(data){
                        $('#zip_code').val(data)
                    }
                });
            });
        });
    </script>
</body>
</html>
