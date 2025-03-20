<?php
$servername = "localhost";
$username = "root";  // เปลี่ยนเป็นชื่อผู้ใช้ MySQL ของคุณ
$password = "";      // เปลี่ยนเป็นรหัสผ่าน MySQL ของคุณ
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}
?>
