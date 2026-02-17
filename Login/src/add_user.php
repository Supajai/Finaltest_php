<?php
include 'db.php';

// ---- ตั้งค่าตรงนี้ ----
$username = "admin";    // ชื่อผู้ใช้
$password = "1234";     // รหัสผ่าน (จะถูก hash อัตโนมัติ)
$role = "admin";    // admin หรือ user
// -----------------------

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hash, $role);

if ($stmt->execute()) {
    echo "เพิ่มผู้ใช้ '$username' สำเร็จ!<br>";
    echo "รหัสผ่าน: $password<br>";
    echo "Hash: $hash<br>";
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

$stmt->close();
$conn->close();
?>