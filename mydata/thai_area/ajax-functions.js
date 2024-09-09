$(document).ready(function () {
    $('#province').change(function () {
        var province_id = $(this).val();
        if (province_id) {
            $.ajax({
                url: 'thai_area/get_amphures.php',
                type: 'GET',
                data: { province_id: province_id },
                success: function (data) {
                    $('#amphure').html(data);
                    $('#district').html('<option value="">เลือกตำบล</option>'); // เคลียร์ตำบล
                    $('#zip_code').val(''); // เคลียร์รหัสไปรษณีย์
                }
            });
        } else {
            $('#amphure').html('<option value="">เลือกอำเภอ</option>');
            $('#district').html('<option value="">เลือกตำบล</option>');
            $('#zip_code').val('');
        }
    });

    $('#amphure').change(function () {
        var amphure_id = $(this).val();
        if (amphure_id) {
            $.ajax({
                url: 'thai_area/get_districts.php',
                type: 'GET',
                data: { amphure_id: amphure_id },
                success: function (data) {
                    $('#district').html(data);
                    $('#zip_code').val(''); // เคลียร์รหัสไปรษณีย์
                }
            });
        } else {
            $('#district').html('<option value="">เลือกตำบล</option>');
            $('#zip_code').val('');
        }
    });

    $('#district').change(function () {
        var district_id = $(this).val();
        if (district_id) {
            $.ajax({
                url: 'thai_area/get_zip_code.php',
                type: 'GET',
                data: { district_id: district_id },
                success: function (data) {
                    $('#zip_code').val(data);
                }
            });
        } else {
            $('#zip_code').val('');
        }
    });
});
