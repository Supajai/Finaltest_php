<?php
include 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    if (strlen($username) < 3 || strlen($password) < 4) {
        $msg = 'ชื่อผู้ใช้ต้องมีอย่างน้อย 3 ตัว และรหัสผ่านอย่างน้อย 4 ตัว';
    } else {
        $chk = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $chk->bind_param("s", $username);
        $chk->execute();
        if ($chk->get_result()->num_rows > 0) {
            $msg = 'ชื่อผู้ใช้นี้ถูกใช้แล้ว';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $stmt->bind_param("ss", $username, $hash);
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $msg = 'เกิดข้อผิดพลาด';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>สมัครสมาชิก</title>
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
        <h2 style="text-align:center;margin-bottom:20px;">สมัครสมาชิก</h2>
        <?php if ($msg): ?>
            <p style="color:red;text-align:center;margin-bottom:12px;">
                <?php echo $msg; ?>
            </p>
        <?php endif; ?>
        <form method="POST">
            <label>ชื่อผู้ใช้</label>
            <input type="text" name="username" placeholder="กรอกชื่อผู้ใช้" required
                style="width:100%;padding:10px;margin:8px 0 16px;border:1px solid #ccc;">
            <label>รหัสผ่าน</label>
            <input type="password" name="password" placeholder="กรอกรหัสผ่าน" required
                style="width:100%;padding:10px;margin:8px 0 16px;border:1px solid #ccc;">
            <button type="submit"
                style="width:100%;padding:10px;background:#16a34a;color:#fff;font-size:16px;">สมัครสมาชิก</button>
        </form>
        <p style="text-align:center;margin-top:16px;"><a href="index.php" style="color:#4f46e5;">มีบัญชีแล้ว?
                เข้าสู่ระบบ</a></p>
    </div>
</body>

</html>