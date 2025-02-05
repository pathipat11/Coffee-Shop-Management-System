<?php
$username = $_POST["username"];
$password = $_POST["password"];
$realname = $_POST["realname"];
$email = $_POST["email"];
$mobile = $_POST["mobile"];
$image = $_POST["image"];
$status = isset($_POST["status"]) ? 1 : 0;  // ตรวจสอบค่าของ status ถ้าไม่ได้เลือกจะกำหนดเป็น 0

$link = mysqli_connect('localhost', 'root', '', 'coffee');

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// ใช้ prepared statement เพื่อป้องกัน SQL Injection
$sql = "UPDATE user SET image = ?, password = ?, realname = ?, email = ?, mobile = ?, status = ? WHERE username = ?";

$stmt = mysqli_prepare($link, $sql);

if ($stmt) {
    // ผูกค่ากับ placeholder
    mysqli_stmt_bind_param($stmt, "sssssis", $image, $password, $realname, $email, $mobile, $status, $username);

    // รันคำสั่ง
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('ข้อมูอได้รับการแก้ไขแล้ว');</script>";
        echo "<script>window.location='../user/show_all_users.php?username=$username';</script>";
    } else {
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
        echo "<script>window.location='../user/show_all_users.php?username=$username';</script>";
    }

    // ปิด statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error in preparing the query: " . mysqli_error($link);
}

mysqli_close($link);
?>
