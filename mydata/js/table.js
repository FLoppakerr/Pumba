$(document).ready(function() {
    $('#example').DataTable({
        pageLength: 10,  // ตั้งค่าจำนวนเริ่มต้นที่จะแสดง
        lengthMenu: [10, 25, 50, 100, 500, 1000],  // เพิ่มตัวเลือกจำนวนรายการ
        language: {
            search: "ค้นหา:", // ปรับข้อความของ search box
            lengthMenu: "แสดง _MENU_ รายการต่อหน้า",  // ปรับข้อความจำนวนรายการ
            info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            paginate: {
                first: "หน้าแรก",
                last: "หน้าสุดท้าย",
                next: "ถัดไป",
                previous: "ก่อนหน้า"
            }
        }
    });
});
