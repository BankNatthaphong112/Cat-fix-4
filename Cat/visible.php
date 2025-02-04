<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "its66040233122";
$password = "V7nuB5S3";
$dbname =  "its66040233122";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการเปลี่ยนแปลงสถานะการแสดงภาพ
if (isset($_GET['toggle_visibility']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $toggle = $_GET['toggle_visibility'] == '1' ? 0 : 1; // เปลี่ยนสถานะจาก 1 เป็น 0 หรือจาก 0 เป็น 1

    // อัปเดตสถานะ is_visible ในฐานข้อมูล
    $sql = "UPDATE CatBreeds SET is_visible = $toggle WHERE id = $id";
    $conn->query($sql);
    header("Location: visible.php"); // รีเฟรชหน้าเมื่อทำการอัปเดตแล้ว
    exit();
}

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM CatBreeds";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลสายพันธุ์แมว</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
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

<div class="container">
    <h2>ข้อมูลสายพันธุ์แมว</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ชื่อสายพันธุ์</th>
                <th>คำอธิบาย</th>
                <th>ลักษณะ</th>
                <th>คำแนะนำการเลี้ยงดู</th>
                <th>แสดงผล</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['name_th']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['characteristics']; ?></td>
                    <td><?php echo $row['care_instructions']; ?></td>
                    <td>
                        <?php if ($row['is_visible'] == 1) { ?>
                            แสดง
                        <?php } else { ?>
                            ซ่อน
                        <?php } ?>
                    </td>
                    <td>
                        <a href="edit_cat.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">แก้ไข</a>
                        <a href="?toggle_visibility=<?php echo $row['is_visible']; ?>&id=<?php echo $row['id']; ?>" class="btn btn-<?php echo ($row['is_visible'] == 1) ? 'danger' : 'success'; ?>">
                            <?php echo ($row['is_visible'] == 1) ? 'ซ่อนรูป' : 'แสดงรูป'; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>


