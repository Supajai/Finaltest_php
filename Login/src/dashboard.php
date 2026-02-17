<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
if ($_SESSION['role'] !== 'admin') {
    header("Location: search.php");
    exit();
}
include "db.php";
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main class="main-content" style="padding:20px;">
        <h2 style="margin-bottom:20px;">แดชบอร์ด</h2>
        <p style="margin-bottom:20px;">ยินดีต้อนรับ
            <?php echo htmlspecialchars($_SESSION['username'] ?? 'ผู้ดูแลระบบ'); ?>
        </p>

        <!-- Stats -->
        <div style="display:flex;gap:16px;margin-bottom:20px;flex-wrap:wrap;">
            <div style="background:#fff;padding:20px;flex:1;min-width:150px;border:1px solid #ddd;">
                <p style="color:#888;font-size:14px;">สถานะระบบ</p>
                <p style="font-size:24px;font-weight:700;color:green;">✓ ปกติ</p>
            </div>
        </div>

        <!-- Recent Users -->
        <div style="background:#fff;padding:20px;border:1px solid #ddd;">
            <h3 style="margin-bottom:16px;">ผู้ใช้ล่าสุด</h3>
            <table>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="text-align:left;padding:8px;">#ID</th>
                    <th style="text-align:left;padding:8px;">ชื่อผู้ใช้</th>
                    <th style="text-align:left;padding:8px;">บทบาท</th>
                    <th style="text-align:left;padding:8px;">สถานะ</th>
                </tr>
                <?php
                $result = $conn->query("SELECT id, username, role FROM users WHERE deleted_at IS NULL ORDER BY id DESC LIMIT 5");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $rt = $row['role'] === 'admin' ? 'ผู้ดูแลระบบ' : 'ผู้ใช้ปกติ';
                        echo "<tr style='border-bottom:1px solid #eee;'>
                        <td style='padding:8px;'>#{$row['id']}</td>
                        <td style='padding:8px;'>{$row['username']}</td>
                        <td style='padding:8px;'>{$rt}</td>
                        <td style='padding:8px;'>ใช้งาน</td>
                    </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='padding:16px;text-align:center;color:#888;'>ไม่มีผู้ใช้</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Quick Links -->
        <div style="margin-top:20px;background:#fff;padding:20px;border:1px solid #ddd;">
            <h3 style="margin-bottom:12px;">ลิงก์ด่วน</h3>
            <a href="userlist.php"
                style="display:inline-block;padding:8px 16px;background:#7c3aed;color:#fff;margin-right:8px;">จัดการผู้ใช้</a>
            <a href="search.php"
                style="display:inline-block;padding:8px 16px;background:#2563eb;color:#fff;margin-right:8px;">ค้นหาผู้ใช้</a>
            <a href="Restore.php"
                style="display:inline-block;padding:8px 16px;background:#16a34a;color:#fff;">คืนค่าผู้ใช้</a>
        </div>
    </main>
</body>

</html>