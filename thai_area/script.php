<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
  $('#provinces').change(function() {
    var id_province = $(this).val();

    $.ajax({
      type: "POST",
      url: "ajax_db.php",
      data: { id: id_province, function: 'provinces' },
      success: function(data) {
        $('#amphures').html(data);
        $('#districts').html('<option value="" selected disabled>-กรุณาเลือกตำบล-</option>');
        $('#zip_code').val('');  // เคลียร์ค่า zipcode ทุกครั้งที่เลือกจังหวัดใหม่
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูลจังหวัด:', error);
      }
    });
  });

  $('#amphures').change(function() {
    var id_amphures = $(this).val();

    $.ajax({
      type: "POST",
      url: "ajax_db.php",
      data: { id: id_amphures, function: 'amphures' },
      success: function(data) {
        $('#districts').html(data);
        $('#zip_code').val('');  // เคลียร์ค่า zipcode ทุกครั้งที่เลือกอำเภอใหม่
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูลอำเภอ:', error);
      }
    });
  });

  $('#districts').change(function() {
    var id_districts = $(this).val();

    $.ajax({
      type: "POST",
      url: "ajax_db.php",
      data: { id: id_districts, function: 'districts' },
      success: function(data) {
        $('#zip_code').val(data);  // เซ็ตค่า zipcode ตามข้อมูลที่ได้จากการเลือกตำบล
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูลตำบล:', error);
      }
    });
  });
});
</script>
