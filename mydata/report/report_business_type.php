<?php
require_once '../config/dbconnect.php'; // ตรวจสอบว่ามีการเชื่อมต่อฐานข้อมูลที่ถูกต้อง

// Query SQL สำหรับดึงข้อมูลประเภทธุรกิจและจำนวน
$sql = "SELECT business_type, COUNT(*) AS count
        FROM customers_data
        GROUP BY business_type
        ORDER BY count DESC";

// ดึงข้อมูลจากฐานข้อมูล
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางนับจำนวนประเภทธุรกิจ</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        table {
            border-collapse: collapse;
            width: 60%;
            background-color: #e0e0e0;
            border: 2px solid blue;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border-bottom: 2px solid red;
        }
        th {
            background-color: #bdbdbd;
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
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ประเภทธุรกิจ</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result && $result->num_rows > 0) {
                // วน loop แสดงข้อมูลแต่ละแถว
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['business_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['count']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>ไม่พบข้อมูล</td></tr>";
            }

            // ปิดการเชื่อมต่อฐานข้อมูล
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
