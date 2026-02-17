<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';
    $username = $_POST['username'];
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        die("ไม่พบชื่อผู้ใช้ในระบบ");
    }
    $row = $result->fetch_assoc();
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+15 minutes"));
    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expire = ? WHERE id = ?");
    $stmt->bind_param("ssi", $token, $expires, $row['id']);
    $stmt->execute();
    echo '<body style="display:flex;align-items:center;justify-content:center;height:100vh;font-family:sans-serif;background:#f5f5f5;">
    <div style="background:#fff;padding:30px;text-align:center;border:1px solid #ddd;">
        <h2 style="margin-bottom:16px;">ลิงก์รีเซ็ตรหัสผ่าน</h2>
        <a href="reset_password.php?token=' . $token . '" style="color:#007bff;">คลิกที่นี่เพื่อรีเซ็ต</a>
    </div></body>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>รีเซ็ตรหัสผ่าน</title>
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
        <h2 style="text-align:center;margin-bottom:20px;">รีเซ็ตรหัสผ่าน</h2>
        <form action="" method="post">
            <label>ชื่อผู้ใช้</label>
            <input type="text" name="username" placeholder="กรอกชื่อผู้ใช้" required
                style="width:100%;padding:10px;margin:8px 0 16px;border:1px solid #ccc;">
            <button type="submit"
                style="width:100%;padding:10px;background:#16a34a;color:#fff;font-size:16px;">รีเซ็ตรหัสผ่าน</button>
        </form>
        <p style="text-align:center;margin-top:16px;"><a href="index.php" style="color:#16a34a;">กลับไปเข้าสู่ระบบ</a>
        </p>
    </div>
</body>

</html>