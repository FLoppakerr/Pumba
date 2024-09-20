<?php
// เริ่มต้น session (ถ้ามีการใช้ session)
session_start();

// เชื่อมต่อฐานข้อมูล
require_once '../config/dbconnect.php';

// Query ดึงข้อมูลจำนวนธุรกิจในแต่ละจังหวัด และเรียงตามจำนวนธุรกิจจากมากไปน้อย
$sql = "SELECT provinces.name_th AS province, COUNT(customers_data.id) AS business_count 
        FROM customers_data
        JOIN provinces ON customers_data.province = provinces.id
        GROUP BY customers_data.province
        ORDER BY business_count DESC"; // เพิ่ม ORDER BY เพื่อเรียงลำดับจากมากไปน้อย
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางจำนวนธุรกิจ</title>
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
                <th>จังหวัด</th>
                <th>จำนวนธุรกิจ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
            if ($result->num_rows > 0) {
                // วน loop แสดงข้อมูลแต่ละแถว
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['province']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['business_count']) . "</td>";
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
