<?php
require_once '../config/dbconnect.php';

// Query SQL สำหรับดึงข้อมูลชื่อจังหวัดและจำนวนโรงแรม
$sql = "SELECT p.name_th AS province_name, COUNT(c.business_name) AS hotel_count
        FROM customers_data c
        JOIN provinces p ON c.province = p.id
        WHERE c.business_type = 'โรงแรม'
        GROUP BY c.province
        ORDER BY hotel_count DESC";

// ดึงข้อมูลจากฐานข้อมูล
$result = $conn->query($sql);

// ตรวจสอบว่ามีผลลัพธ์หรือไม่
if ($result && $result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC); // เก็บผลลัพธ์ทั้งหมดใน array
} else {
    $rows = []; // กรณีไม่มีข้อมูล
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางจำนวนโรงแรมในแต่ละจังหวัด</title>
    <style>
        body {
            font-family: 'Anuphan', sans-serif !important;
            background-color: #51829b;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            font-size: 2em;
            color: #ffffff;
            font-weight: 400;
        }
        .table-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        table {
            width: 60%;
            background-color: #ffffff;
            border: 2px solid #e5e5e5;
            border-radius: 10px;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border-bottom: 2px solid #e5e5e5;
        }
        th {
            background-color: #edeaea;
            font-size: 1.5em;
            font-weight: bold;
        }
        td {
            font-size: 1.2em;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:nth-child(even) {
            background-color: #ffffff;
        }
    </style>
</head>
<body>

    <h1>สรุปรายงานโรงแรมในแต่ละจังหวัด</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>จังหวัด</th>
                    <th>จำนวนโรงแรม</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['province_name']) ?></td>
                            <td><?= htmlspecialchars($row['hotel_count']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="2">ไม่พบข้อมูล</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

