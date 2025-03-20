<?php
require 'config.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "❌ รหัสผ่านไม่ถูกต้อง!";
        }
    } else {
        $error = "❌ ไม่พบชื่อผู้ใช้!";
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
    <title>เข้าสู่ระบบ</title>
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
      background-image: url('https://scontent.fbkk33-3.fna.fbcdn.net/v/t1.15752-9/483124792_989165703178307_2720114282982913420_n.png?_nc_cat=111&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeGdVbswnh7ikmNbQhN3SEww-7lLIEVc-4_7uUsgRVz7j-W1YvDtRtxJbj_XxJXUKiYGDg1Mp8xSryX3yH5J68Oa&_nc_ohc=E6-ShMcBLdwQ7kNvgHafg9e&_nc_oc=AdgHO2MB-oRmhYPI6ktouktasaTnoxYj9_wDFRUq3ycy-fRcf3J2WsXTlIEx2XbHIYQ&_nc_zt=23&_nc_ht=scontent.fbkk33-3.fna&oh=03_Q7cD1wED5aQHoq-fUJlbFdPyXzzTokp56WYXdFKNW3eKg-lmXQ&oe=67FBB1E1'); /* ใช้ URL ของรูปภาพ */
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }
        .login-container h2 {
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
            border-color: #6e8efb;
            outline: none;
            box-shadow: 0 0 5px rgba(110, 142, 251, 0.5);
        }
        .input-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }
        .login-btn {
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
        .login-btn:hover {
            background: #5a7dfb;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .register-link {
            margin-top: 10px;
            font-size: 14px;
        }
        .register-link a {
            color: #6e8efb;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2></h2>
        <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
                <i class="fa fa-user"></i>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="รหัสผ่าน" required>
                <i class="fa fa-lock"></i>
            </div>
            <button type="submit" class="login-btn">เข้าสู่ระบบ</button>
        </form>
        <p class="register-link">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
    </div>
</body>
</html>
