<?php

// ==========================================
// 1. Class แม่ (Parent Class) - มีความสามารถพื้นฐาน
// ==========================================
class User {
    public $username;
    public $role;

    public function __construct($username, $role = 'user') {
        $this->username = $username;
        $this->role = $role;
    }

    public function showProfile() {
        return "👤 ฉันชื่อ " . $this->username . " (ตำแหน่ง: " . $this->role . ")";
    }
}

// ==========================================
// 2. Class ลูก (Child Class) - สืบทอดมาจาก User
// ==========================================
// คำว่า 'extends' คือหัวใจหลัก แปลว่า Admin สืบทอดมาจาก User
class Admin extends User {
    
    // ลูกสามารถมีตัวแปรของตัวเองเพิ่มได้ (แม่ไม่มี)
    public $accessLevel; 

    // Constructor ของลูก
    public function __construct($username, $accessLevel) {
        // อัญเชิญ Constructor ของแม่ (User) มาช่วยจัดการ $username ให้หน่อย
        parent::__construct($username, 'admin',); 
        
        // ส่วนอันนี้ลูกจัดการเอง
        $this->accessLevel = $accessLevel;
    }

    // ฟังก์ชันนี้ลูกขอ "เขียนทับ (Override)" ของแม่ เพราะอยากโชว์โปรไฟล์แบบเท่ๆ
    public function showProfile() {
        return "👑 ฉันคือแอดมินชื่อ " . $this->username . " (สิทธิ์ระดับ: " . $this->accessLevel . ")";
    }

    // ฟังก์ชันพิเศษ มีแค่ลูก (Admin) เท่านั้นที่ทำได้! แม่ (User) ทำไม่ได้
    public function banUser($targetUser) {
        return "🚨 " . $this->username . " ได้ทำการแบนผู้ใช้ชื่อ " . $targetUser . " ออกจากระบบ!";
    }
}

// ==========================================
// ลองนำมาใช้งานจริง
// ==========================================

// สร้างผู้ใช้ทั่วไป (ใช้ Class แม่)
$normalUser = new User("Somchai");
echo $normalUser->showProfile(); 
// ผลลัพธ์: 👤 ฉันชื่อ Somchai (ตำแหน่ง: user)
echo "<br><br>";

// สร้างแอดมิน (ใช้ Class ลูก)
$superAdmin = new Admin("Somsri", "สูงสุด (Level 10)");
echo $superAdmin->showProfile(); 
// ผลลัพธ์: 👑 ฉันคือแอดมินชื่อ Somsri (สิทธิ์ระดับ: สูงสุด (Level 10))
echo "<br>";

// ลองให้แอดมินใช้พลังพิเศษ (แบนคนอื่น)
echo $superAdmin->banUser("Somchai");
// ผลลัพธ์: 🚨 Somsri ได้ทำการแบนผู้ใช้ชื่อ Somchai ออกจากระบบ!

// หมายเหตุ: ถ้าลองสั่ง $normalUser->banUser("Somsri") ระบบจะ Error ทันที เพราะ User ธรรมดาไม่มีสิทธิ์นี้!

?>