<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>ค้นหาผู้ใช้</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main class="main-content" style="padding:20px;">
        <h2 style="margin-bottom:20px;">ค้นหาผู้ใช้</h2>
        <div style="background:#fff;padding:20px;border:1px solid #ddd;margin-bottom:20px;">
            <form method="GET" style="display:flex;gap:8px;">
                <input type="text" name="q" placeholder="ค้นหาชื่อผู้ใช้..."
                    value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"
                    style="flex:1;padding:10px;border:1px solid #ccc;">
                <button type="submit" style="padding:10px 20px;background:#7c3aed;color:#fff;">ค้นหา</button>
            </form>
        </div>
        <?php
        if (isset($_GET['q']) && strlen(trim($_GET['q'])) > 0) {
            $q = trim($_GET['q']);
            $stmt = $conn->prepare("SELECT id, username, role FROM users WHERE username LIKE ? AND deleted_at IS NULL LIMIT 10");
            $s = "%" . $q . "%";
            $stmt->bind_param("s", $s);
            $stmt->execute();
            $result = $stmt->get_result();
            echo '<div style="background:#fff;padding:20px;border:1px solid #ddd;">';
            echo '<h3 style="margin-bottom:12px;">ผลการค้นหา (' . $result->num_rows . ' รายการ)</h3>';
            if ($result->num_rows > 0) {
                echo '<table><tr style="border-bottom:2px solid #ddd;">
                <th style="text-align:left;padding:8px;">#ID</th><th style="text-align:left;padding:8px;">ชื่อผู้ใช้</th>
                <th style="text-align:left;padding:8px;">บทบาท</th><th style="text-align:left;padding:8px;">สถานะ</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    $rt = $row['role'] === 'admin' ? 'ผู้ดูแลระบบ' : 'ผู้ใช้ปกติ';
                    echo "<tr style='border-bottom:1px solid #eee;'><td style='padding:8px;'>#{$row['id']}</td>
                    <td style='padding:8px;'>{$row['username']}</td><td style='padding:8px;'>{$rt}</td>
                    <td style='padding:8px;'>ใช้งาน</td></tr>";
                }
                echo '</table>';
            } else {
                echo '<p style="color:#888;">ไม่พบผู้ใช้ที่ตรงกับการค้นหา</p>';
            }
            echo '</div>';
        }
        ?>
    </main>
</body>

</html>