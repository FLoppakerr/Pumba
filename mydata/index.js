$(document).ready(function () {
      // จัดการการเปลี่ยนแปลงของ dropdown
      $('#province').change(function () {
        let provinceId = $(this).val();
        $.ajax({
          url: 'thai_area/get_amphures.php',
          type: 'GET',
          data: { province_id: provinceId },
          success: function (data) {
            $('#amphure').html(data);
            $('#district').html('<option value="">เลือกตำบล</option>');
            $('#zip_code').val('');
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
          }
        });
      });

      $('#amphure').change(function () {
        let amphureId = $(this).val();
        $.ajax({
          url: 'thai_area/get_districts.php',
          type: 'GET',
          data: { amphure_id: amphureId },
          success: function (data) {
            $('#district').html(data);
            $('#zip_code').val('');
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
          }
        });
      });

      $('#district').change(function () {
        let districtId = $(this).val();
        $.ajax({
          url: 'thai_area/get_zip_code.php',
          type: 'GET',
          data: { district_id: districtId },
          success: function (data) {
            $('#zip_code').val(data);
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
          }
        });
      });

      // จัดการการส่งฟอร์ม
      $('#insertForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
          url: 'customers/insertdata.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function (response) {
            $('#insertModal').modal('hide');
            location.reload(); // รีเฟรชหน้าเพื่อตรวจสอบข้อมูลใหม่
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
          }
        });
      });
    });