<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: search.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: 'Kanit', sans-serif;
            background: #f5f5f5
        }

        a {
            text-decoration: none;
            color: inherit
        }

        button {
            cursor: pointer;
            border: none;
            font-family: inherit
        }
    </style>
</head>

<body style="display:flex;align-items:center;justify-content:center;min-height:100vh;">
    <div style="background:#fff;padding:30px;width:360px;border:1px solid #ddd;">
        <h2 style="text-align:center;margin-bottom:20px;">เข้าสู่ระบบ</h2>
        <form action="ck_login.php" method="POST">
            <label>ชื่อผู้ใช้</label>
            <input type="text" name="username" placeholder="กรอกชื่อผู้ใช้" required
                style="width:100%;padding:10px;margin:8px 0 16px;border:1px solid #ccc;">
            <label>รหัสผ่าน</label>
            <input type="password" name="password" placeholder="กรอกรหัสผ่าน" required
                style="width:100%;padding:10px;margin:8px 0 16px;border:1px solid #ccc;">
            <button type="submit"
                style="width:100%;padding:10px;background:#4f46e5;color:#fff;font-size:16px;">เข้าสู่ระบบ</button>
        </form>
        <p style="text-align:center;margin-top:16px;"><a href="forgot.php" style="color:#4f46e5;">ลืมรหัสผ่าน?</a></p>
        <p style="text-align:center;margin-top:8px;"><a href="register.php" style="color:#16a34a;">สมัครสมาชิก</a></p>
    </div>
</body>

</html>