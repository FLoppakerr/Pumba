$(document).ready(function () {
// เมื่อเลือกจังหวัด โหลดอำเภอที่เกี่ยวข้องอัตโนมัติและเลือกอำเภอแรก
$('#province').change(function () {
    let provinceId = $(this).val();

    // โหลดอำเภอ
    $.ajax({
        url: 'thai_area/get_amphures.php',
        type: 'GET',
        data: { province_id: provinceId },
        success: function (data) {
            $('#amphure').html(data); // แสดงอำเภอที่เกี่ยวข้อง
            let firstAmphure = $('#amphure option:first').val(); // เลือกอำเภอแรก
            $('#amphure').val(firstAmphure).change(); // ส่ง event change เพื่อโหลดตำบลอัตโนมัติ

            // รีเซ็ตรหัสไปรษณีย์
            $('#zip_code').val('');
        },
        error: function (xhr, status, error) {
            console.error("Error loading amphures: ", status, error);
        }
    });
});
// เมื่ออำเภอถูกเลือก โหลดตำบลที่เกี่ยวข้องอัตโนมัติและเลือกตำบลแรก
$('#amphure').change(function () {
    let amphureId = $(this).val();

    // โหลดตำบล
    $.ajax({
        url: 'thai_area/get_districts.php',
        type: 'GET',
        data: { amphure_id: amphureId },
        success: function (data) {
            $('#district').html(data); // แสดงตำบลที่เกี่ยวข้อง
            let firstDistrict = $('#district option:first').val(); // เลือกตำบลแรก
            $('#district').val(firstDistrict).change(); // ส่ง event change เพื่อโหลดรหัสไปรษณีย์อัตโนมัติ

            // รีเซ็ตรหัสไปรษณีย์
            $('#zip_code').val('');
        },
        error: function (xhr, status, error) {
            console.error("Error loading districts: ", status, error);
        }
    });
});
// เมื่อเลือกตำบล โหลดรหัสไปรษณีย์ที่เกี่ยวข้องอัตโนมัติ
$('#district').change(function () {
    let districtId = $(this).val();

    // โหลดรหัสไปรษณีย์
    $.ajax({
        url: 'thai_area/get_zip_code.php',
        type: 'GET',
        data: { district_id: districtId },
        success: function (data) {
            $('#zip_code').val(data.trim()); // อัปเดตรหัสไปรษณีย์
        },
        error: function (xhr, status, error) {
            console.error("Error loading zip code: ", status, error);
        }
    });
});
  // การส่งฟอร์มด้วย AJAX
  $('#insertForm').submit(function (e) {
      e.preventDefault();
      $.ajax({
          url: 'customers/insertdata.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function (response) {
              $('#insertModal').modal('hide'); // ปิด Modal
              location.reload(); // รีเฟรชหน้า
          },
          error: function (xhr, status, error) {
              console.error("AJAX Error:", status, error);
          }
      });
  });
});
