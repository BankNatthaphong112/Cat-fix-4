<?php
// การเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "its66040233112";
$password = "H5tmJ2K8";
$dbname =  "its66040233112";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $name_th = $_POST['name_th'];
    $name_en = $_POST['name_en'];
    $description = $_POST['description'];
    $characteristics = $_POST['characteristics'];
    $care_instructions = $_POST['care_instructions'];
    $image_url = $_POST['image_url'];
    $is_visible = isset($_POST['is_visible']) ? 1 : 0;

    // คำสั่งเตรียมเพื่อหลีกเลี่ยงการโจมตี SQL injection
    $stmt = $conn->prepare("INSERT INTO CatBreeds (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $name_th, $name_en, $description, $characteristics, $care_instructions, $image_url, $is_visible);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ'); window.location.href = 'index.php';</script>";
    } else {
        echo "ข้อผิดพลาด: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลสายพันธุ์แมว</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-right">
            <li><a href="admin.php">Home Admin</a></li>
                <li><a href="add_cat.php">Add Cat</a></li>
                <li><a href="imageList.php" target="_blank">IMG</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container form-container">
    <h2>เพิ่มข้อมูลสายพันธุ์แมว</h2>

    <form action="add_cat.php" method="post">
        <div class="form-group">
            <label for="name_th">ชื่อสายพันธุ์ (ไทย):</label>
            <input type="text" class="form-control" id="name_th" name="name_th" required>
        </div>

        <div class="form-group">
            <label for="name_en">ชื่อสายพันธุ์ (อังกฤษ):</label>
            <input type="text" class="form-control" id="name_en" name="name_en" required>
        </div>

        <div class="form-group">
            <label for="description">คำอธิบาย:</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>

        <div class="form-group">
            <label for="characteristics">ลักษณะทั่วไป:</label>
            <textarea class="form-control" id="characteristics" name="characteristics" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="care_instructions">คำแนะนำการเลี้ยงดู:</label>
            <textarea class="form-control" id="care_instructions" name="care_instructions" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="image_url">URL ของรูปภาพ:</label>
            <input type="text" class="form-control" id="image_url" name="image_url">
        </div>

        <div class="form-group">
            <label for="is_visible">แสดงผลในเว็บไซต์:</label>
            <input type="checkbox" id="is_visible" name="is_visible" checked>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>
