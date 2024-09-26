$(document).ready(function () {
    // เมื่อเลือกจังหวัด โหลดอำเภอที่เกี่ยวข้อง แต่ไม่เลือกอัตโนมัติ
    $('#province').change(function () {
        let provinceId = $(this).val();

        // โหลดอำเภอ
        $.ajax({
            url: 'thai_area/get_amphures.php',
            type: 'GET',
            data: { province_id: provinceId },
            success: function (data) {
                $('#amphure').html('<option value="-">-</option>' + data); // เพิ่ม option "-" ก่อนแสดงอำเภอที่ได้จาก AJAX
                $('#amphure').val('-'); // ลบ .change() เพื่อไม่ให้เลือกอัตโนมัติ
               
                // ตั้งค่าเริ่มต้นให้ตำบลเป็น "-"
                $('#district').html('<option value="-">-</option>');
                $('#zip_code').val('-');
            },
            error: function (xhr, status, error) {
                console.error("Error loading amphures: ", status, error);
            }
        });
    });

    // เมื่อเลือกอำเภอ โหลดตำบลที่เกี่ยวข้อง แต่ไม่เลือกอัตโนมัติ
    $('#amphure').change(function () {
        let amphureId = $(this).val();

        if (amphureId === '-') {
            // ถ้าอำเภอเป็น "-" ให้ตั้งค่าตำบลและรหัสไปรษณีย์เป็น "-"
            $('#district').html('<option value="-">-</option>');
            $('#zip_code').val('-');
        } else {
            // โหลดตำบล
            $.ajax({
                url: 'thai_area/get_districts.php',
                type: 'GET',
                data: { amphure_id: amphureId },
                success: function (data) {
                    $('#district').html('<option value="-">-</option>' + data); // เพิ่ม option "-" ก่อนแสดงตำบลที่ได้จาก AJAX
                    $('#zip_code').val('-'); // รีเซ็ตรหัสไปรษณีย์
                },
                error: function (xhr, status, error) {
                    console.error("Error loading districts: ", status, error);
                }
            });
        }
    });

    // เมื่อเลือกตำบล โหลดรหัสไปรษณีย์ที่เกี่ยวข้อง
    $('#district').change(function () {
        let districtId = $(this).val();

        if (districtId === '-') {
            $('#zip_code').val('-'); // ถ้าตำบลเป็น "-" ให้รหัสไปรษณีย์เป็น "-"
        } else {
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
        }
    });

    $('#insertForm').submit(function (e) {
        e.preventDefault();  // ป้องกันการ submit แบบปกติ
    
        $.ajax({
            url: 'customers/insertdata.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'error') {
                    alert(response.message);  // ถ้ามีข้อผิดพลาด จะแสดงข้อความแจ้งเตือน
                } else {
                    // เมื่อบันทึกข้อมูลสำเร็จ ให้รีเฟรชหน้าโดยไม่แสดงข้อความ
                    location.reload();  
                }
            },
            error: function (xhr, status, error) {
                console.error("Error: ", status, error);
                alert("เกิดข้อผิดพลาด: " + error);  // แสดงข้อความเมื่อเกิดข้อผิดพลาด
            }
        });
    });
    
    
});
