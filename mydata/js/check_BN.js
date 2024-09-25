$(document).ready(function () {
    $('#business_name').on('blur', function () {
        let businessName = $(this).val(); // รับค่าจาก input

        if (businessName !== "") {
            $.ajax({
                url: 'customers/check_business_name.php', // URL สำหรับตรวจสอบ business_name
                type: 'POST',
                data: { business_name: businessName },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'error') {
                        // ถ้าชื่อซ้ำ แสดงการแจ้งเตือน
                        alert(response.message);
                        $('#business_name').addClass('is-invalid'); // เพิ่ม class สำหรับ invalid
                    } else {
                        $('#business_name').removeClass('is-invalid'); // ลบ class เมื่อ valid
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error: ", status, error);
                    alert("เกิดข้อผิดพลาดในการตรวจสอบชื่อธุรกิจ");
                }
            });
        }
    });
});
