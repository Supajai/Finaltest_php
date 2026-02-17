<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $pw = $_POST['password'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expire > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        die("โทเค็นไม่ถูกต้องหรือหมดอายุ");
    }
    $row = $result->fetch_assoc();
    $hash = password_hash($pw, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expire = NULL WHERE id = ?");
    $stmt->bind_param("si", $hash, $row['id']);
    $stmt->execute();
    echo '<body style="display:flex;align-items:center;justify-content:center;height:100vh;font-family:sans-serif;background:#f5f5f5;">
    <div style="background:#fff;padding:30px;text-align:center;border:1px solid #ddd;">
        <h2 style="color:green;margin-bottom:12px;">✅ ตั้งรหัสผ่านใหม่เรียบร้อย</h2>
        <a href="index.php" style="color:#007bff;">กลับไปเข้าสู่ระบบ</a>
    </div></body>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>ตั้งรหัสผ่านใหม่</title>
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
        <?php
        if (!isset($_GET['token'])) {
            echo '<p style="color:red;">โทเค็นไม่ถูกต้อง</p>';
            exit;
        }
        $token = $_GET['token'];
        $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expire > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        if ($stmt->get_result()->num_rows !== 1) {
            echo '<p style="color:red;">โทเค็นไม่ถูกต้องหรือหมดอายุ</p>';
            exit;
        }
        ?>
        <h2 style="text-align:center;margin-bottom:20px;">ตั้งรหัสผ่านใหม่</h2>
        <form action="" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label>รหัสผ่านใหม่</label>
            <input type="password" name="password" placeholder="กรอกรหัสผ่านใหม่" required
                style="width:100%;padding:10px;margin:8px 0 16px;border:1px solid #ccc;">
            <button type="submit"
                style="width:100%;padding:10px;background:#2563eb;color:#fff;font-size:16px;">ตั้งรหัสผ่านใหม่</button>
        </form>
    </div>
</body>

</html>