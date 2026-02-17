<?php
session_start();
include "db.php";
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "Access denied.";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    if ($_SESSION["role"] !== "admin") {
        die("Unauthorized access.");
    }
    $uid = intval($_POST["id"]);
    if ($uid == $_SESSION["user_id"]) {
        die("Invalid ID.");
    }
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ? AND deleted_at IS NULL");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $r = $stmt->get_result();
    if ($r->num_rows === 0) {
        die("User not found.");
    }

    $del = $conn->prepare("UPDATE users SET deleted_at = NOW(), is_deleted = 1 WHERE id = ?");
    $del->bind_param("i", $uid);
    if ($del->execute()) {
        header("Location: userlist.php");
        exit();
    }
}
$result = $conn->query("SELECT id, username, role FROM users WHERE deleted_at IS NULL");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>รายชื่อผู้ใช้</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main class="main-content" style="padding:20px;">
        <h2 style="margin-bottom:20px;">รายชื่อผู้ใช้ (<?php echo $result->num_rows; ?> คน)</h2>
        <div style="background:#fff;padding:20px;border:1px solid #ddd;">
            <table>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="text-align:left;padding:8px;">ID</th>
                    <th style="text-align:left;padding:8px;">ชื่อผู้ใช้</th>
                    <th style="text-align:left;padding:8px;">บทบาท</th>
                    <th style="text-align:left;padding:8px;">จัดการ</th>
                </tr>
                <?php if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        $rt = $row["role"] === "admin" ? "ผู้ดูแลระบบ" : "ผู้ใช้ปกติ"; ?>
                        <tr style="border-bottom:1px solid #eee;">
                            <td style="padding:8px;">#<?php echo $row["id"]; ?></td>
                            <td style="padding:8px;"><?php echo htmlspecialchars($row["username"]); ?></td>
                            <td style="padding:8px;"><?php echo $rt; ?></td>
                            <td style="padding:8px;">
                                <?php if ($row["id"] != $_SESSION["user_id"]): ?>
                                    <form method="POST" action="" onsubmit="return confirm('ลบผู้ใช้นี้?');"
                                        style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                        <button type="submit" style="padding:6px 12px;background:#dc2626;color:#fff;">ลบ</button>
                                    </form>
                                <?php else:
                                    echo '-';
                                endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="4" style="padding:16px;text-align:center;color:#888;">ไม่พบผู้ใช้</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </main>
</body>

</html>