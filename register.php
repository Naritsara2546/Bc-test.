<?php
require 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $message = "✅ สมัครสมาชิกสำเร็จ! <a href='login.php'>เข้าสู่ระบบ</a>";
    } else {
        $message = "❌ เกิดข้อผิดพลาด: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
      font-family: "Arial", sans-serif;
      text-align: center;
      background-color: #f5f5f5; /* สีพื้นหลังอ่อน */
      background-size: cover; 
      background-position: center; 
      background-image: url('https://scontent.fbkk33-1.fna.fbcdn.net/v/t1.15752-9/483155493_1579406083009229_6293893871067609196_n.png?_nc_cat=105&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeEWBWXtXRJEaMto_Udk54nlqUJc7ajUQcepQlztqNRBxwsOLq6jWZBl4oNxFlbVzrHupOfNInkhlr2S55IFol1W&_nc_ohc=d3tL9qhIuOoQ7kNvgGdc04H&_nc_oc=AdhLi48GDOjH7UXbgZYtEez7kQkeqsDHCdMvv34y8Eno9AyoMNhv9drGvWZ2cbJ7H3w&_nc_zt=23&_nc_ht=scontent.fbkk33-1.fna&oh=03_Q7cD1wGyXX9la4cbJExLa3EzrXeuK6_x8wrhnmHGKcKhfMXGCQ&oe=67FBADB1'); /* ใช้ URL ของรูปภาพ */
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
        .register-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }
        .register-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .input-group {
            position: relative;
            margin: 15px 0;
        }
        .input-group input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: 0.3s;
        }
        .input-group input:focus {
            border-color: #00c6ff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 198, 255, 0.5);
        }
        .input-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }
        .register-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #6e8efb;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .register-btn:hover {
            background: #6e8efb;
        }
        .message {
            margin-bottom: 15px;
            font-size: 14px;
        }
        .message a {
            color: #0072ff;
            text-decoration: none;
            font-weight: bold;
        }
        .message a:hover {
            text-decoration: underline;
        }
        .login-link {
            margin-top: 10px;
            font-size: 14px;
        }
        .login-link a {
            color: #0072ff;
            text-decoration: none;
            font-weight: bold;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2></h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
        <form method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
                <i class="fa fa-user"></i>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="อีเมล" required>
                <i class="fa fa-envelope"></i>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="รหัสผ่าน" required>
                <i class="fa fa-lock"></i>
            </div>
            <button type="submit" class="register-btn">สมัครสมาชิก</button>
        </form>
        <p class="login-link">มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
    </div>
</body>
</html>
