<?php
require_once('../dbconnect.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch provinces based on province_id
if (isset($_POST['function']) && $_POST['function'] == 'provinces') {
    $id = $_POST['id'];
    // Prepare SQL statement to prevent SQL injection
    $sql = "SELECT * FROM amphures WHERE province_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="" selected disabled>-กรุณาเลือกอำเภอ-</option>';
    while ($value = $result->fetch_assoc()) {
        echo '<option value="' . $value['id'] . '">' . $value['name_th'] . '</option>';
    }
}

// Fetch districts based on amphure_id
if (isset($_POST['function']) && $_POST['function'] == 'amphures') {
    $id = $_POST['id'];
    // Prepare SQL statement to prevent SQL injection
    $sql = "SELECT * FROM districts WHERE amphure_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="" selected disabled>-กรุณาเลือกตำบล-</option>';
    while ($value = $result->fetch_assoc()) {
        echo '<option value="' . $value['id'] . '">' . $value['name_th'] . '</option>';
    }
}

// Fetch zip_code based on district_id
if (isset($_POST['function']) && $_POST['function'] == 'districts') {
    $id = $_POST['id'];
    // Prepare SQL statement to prevent SQL injection
    $sql = "SELECT * FROM districts WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['zip_code'];
    } else {
        echo "ไม่พบรหัสไปรษณีย์";
    }
}

// Close MySQL connection
$conn->close();
?>
