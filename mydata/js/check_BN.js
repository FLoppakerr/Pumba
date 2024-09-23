$(document).ready(function() {
    $('#business_name').on('blur', function() {
        var businessName = $(this).val();

        if (businessName !== '') {
            $.ajax({
                url: 'customers/check_business_name.php',
                type: 'POST',
                data: { business_name: businessName },
                success: function(response) {
                    if (response === 'exists') {
                        alert('ชื่อธุรกิจนี้มีอยู่แล้ว กรุณาใช้ชื่ออื่น');
                        $('#business_name').val('').focus(); // ล้างค่าชื่อธุรกิจที่ซ้ำ
                        $('#submitBtn').attr('disabled', true); // ปิดการใช้งานปุ่มบันทึก
                    } else {
                        $('#submitBtn').attr('disabled', false); // เปิดใช้งานปุ่มบันทึกถ้าไม่มีชื่อซ้ำ
                    }
                }
            });
        }
    });
});