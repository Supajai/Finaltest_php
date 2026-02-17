<?php
include 'db.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// เตรียมคำสั่ง SQL เพื่อตรวจสอบผู้ใช้
$setsql = $conn->prepare("SELECT id, username, password , role FROM users WHERE username = ?"); 

$setsql->bind_param("s", $username);

// ดำเนินการคำสั่ง SQL
$setsql->execute();

$result = $setsql->get_result();

if($result->num_rows === 1){

    $row  = $result->fetch_assoc();
    
    // ตรวจสอบรหัสผ่าน
    if(password_verify($password, $row['password'])) {
        $_SESSION['user_id']  = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role']     = $row['role'];


        if($row['role'] === 'admin'){
            header("Location: dashboard.php");
            exit();
        } else {
            echo "ไม่มีสิทธิ์เข้าใช้งาน";
        }
        exit();

    } else {
        echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
} else {
    header("Location: index.php");
}

// ปิดการเชื่อมต่อ
$setsql->close();
$conn->close();



?>