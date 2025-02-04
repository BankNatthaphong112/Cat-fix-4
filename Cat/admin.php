<?php
session_start();

// ตรวจสอบว่ามีการเข้าสู่ระบบหรือยัง
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "its66040233112";
$password = "H5tmJ2K8";
$dbname = "its66040233112";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_POST['search']) ? $_POST['search'] : '';
$sql = "SELECT * FROM CatBreeds WHERE (name_th LIKE '%$search%' OR name_en LIKE '%$search%') AND is_visible = 1";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงข้อมูลสายพันธุ์แมว</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f8f9fa; color: #333; padding-bottom: 50px; }
        .container { margin-top: 50px; }
        .cat-card { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .cat-card img { width: 100%; border-radius: 8px; object-fit: cover; }
        .cat-info { display: none; }
        .toggle-btn { display: block; width: 100%; background-color: #007bff; color: white; border: none; padding: 10px; margin-top: 10px; cursor: pointer; border-radius: 5px; }
        .toggle-btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="admin.php">Home Admin</a></li>
                <li><a href="add_cat.php">Add Cat</a></li>
                <li><a href="visible.php">Edit</a></li>
                <li><a href="imageList.php" target="_blank">IMG</a></li>
                <li><a href="logout.php">ออกจากระบบ</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h2>สายพันธุ์แมวยอดนิยม</h2>
    <form method="POST" action="">
        <div class="search-box">
            <input type="text" class="form-control" name="search" placeholder="ค้นหาสายพันธุ์แมว..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
    </form>

    <div class="row">
        <?php if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <div class='col-md-4'>
                    <div class='cat-card'>
                        <h3><?php echo $row['name_th'] . " (" . $row['name_en'] . ")"; ?></h3>
                        <img src='<?php echo $row['image_url']; ?>' alt='Image'>
                        <div class='cat-info'>
                            <p><strong>คำอธิบาย:</strong> <?php echo $row['description']; ?></p>
                            <p><strong>ลักษณะทั่วไป:</strong> <?php echo $row['characteristics']; ?></p>
                            <p><strong>คำแนะนำการเลี้ยงดู:</strong> <?php echo $row['care_instructions']; ?></p>
                        </div>
                        <button class='toggle-btn'>แสดงเพิ่มเติม</button>
                        <a href='edit_cat.php?id=<?php echo $row['id']; ?>'>แก้ไข</a> | 
                        <a href='delete_cat.php?id=<?php echo $row['id']; ?>'>ลบ</a>
                    </div>
                </div>
        <?php }} else { echo "<p>ไม่มีข้อมูลแสดง</p>"; } ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-btn").forEach(button => {
        button.addEventListener("click", function () {
            let info = this.previousElementSibling;
            info.style.display = (info.style.display === "none" || info.style.display === "") ? "block" : "none";
            this.textContent = (info.style.display === "block") ? "ย่อ" : "แสดงเพิ่มเติม";
        });
    });
});
</script>

</body>
</html>