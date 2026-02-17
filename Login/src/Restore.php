<?php
session_start();
include "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
if ($_SESSION["role"] !== "admin") {
    header("Location: search.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $uid = intval($_POST["id"]);
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ? AND deleted_at IS NOT NULL");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        header("Location: Restore.php");
        exit();
    }
    $r = $conn->prepare("UPDATE users SET deleted_at = NULL WHERE id = ?");
    $r->bind_param("i", $uid);
    if ($r->execute()) {
        header("Location: Restore.php");
        exit();
    }
}
$result = $conn->query("SELECT id, username, role FROM users WHERE deleted_at IS NOT NULL ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>คืนค่าผู้ใช้</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main class="main-content" style="padding:20px;">
        <h2 style="margin-bottom:20px;">ผู้ใช้ที่ถูกลบ</h2>
        <div style="background:#fff;padding:20px;border:1px solid #ddd;">
            <table>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="text-align:left;padding:8px;">#ID</th>
                    <th style="text-align:left;padding:8px;">ชื่อผู้ใช้</th>
                    <th style="text-align:left;padding:8px;">บทบาท</th>
                    <th style="text-align:left;padding:8px;">จัดการ</th>
                </tr>
                <?php if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        $rt = $row['role'] === 'admin' ? 'ผู้ดูแลระบบ' : 'ผู้ใช้ปกติ'; ?>
                        <tr style="border-bottom:1px solid #eee;">
                            <td style="padding:8px;">#<?php echo $row['id']; ?></td>
                            <td style="padding:8px;"><?php echo $row['username']; ?></td>
                            <td style="padding:8px;"><?php echo $rt; ?></td>
                            <td style="padding:8px;">
                                <form method="POST" action="" style="display:inline;"
                                    onsubmit="return confirm('คืนค่าผู้ใช้นี้?');">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit"
                                        style="padding:6px 12px;background:#16a34a;color:#fff;">คืนค่า</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="4" style="padding:16px;text-align:center;color:#888;">ไม่มีผู้ใช้ที่ถูกลบ</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </main>
</body>

</html>