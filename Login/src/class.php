<?php

// 1. สร้าง Class (แม่พิมพ์)
class User {
    
    // 2. สร้าง Properties (ตัวแปรที่เก็บข้อมูลของ Class นี้)
    public $username;
    public $role;

    // 3. สร้าง Constructor (ฟังก์ชันพิเศษที่จะทำงานอัตโนมัติ ตอนที่เราสร้าง Object ใหม่)
    public function __construct($inputName, $inputRole = 'user') {
        $this->username = $inputName; // เอาชื่อที่รับมา ใส่เข้าไปในตัวแปรของ Class
        $this->role = $inputRole;     // เอาตำแหน่งที่รับมา ใส่เข้าไป (ถ้าไม่ส่งมา จะเป็น 'user' ตามค่าเริ่มต้น)
    }

    // 4. สร้าง Methods (ฟังก์ชันการทำงานปกติ)
    public function showProfile() {
        return "สวัสดี! ฉันชื่อ " . $this->username . " ตำแหน่งคือ " . $this->role;
    }

    // ฟังก์ชันสำหรับเลื่อนขั้นเป็น Admin
    public function makeAdmin() {
        $this->role = 'admin';
        return $this->username . " ได้รับการเลื่อนขั้นเป็น Admin แล้ว!";
    }
}

// ==========================================
// วิธีนำ Class มาใช้งานจริง (สร้าง Object)
// ==========================================

// สร้างผู้ใช้คนที่ 1 (ใช้ค่าเริ่มต้น role = user)
$user1 = new User("Somchai"); 
echo $user1->showProfile(); 
// ผลลัพธ์: สวัสดี! ฉันชื่อ Somchai ตำแหน่งคือ user
echo "<br>";

// สร้างผู้ใช้คนที่ 2 (กำหนด role เองเป็น manager)
$user2 = new User("Somsri", "manager");
echo $user2->showProfile(); 
// ผลลัพธ์: สวัสดี! ฉันชื่อ Somsri ตำแหน่งคือ manager
echo "<br>";

// ลองให้ สมชาย เลื่อนขั้นเป็นแอดมิน!
echo $user1->makeAdmin();
// ผลลัพธ์: Somchai ได้รับการเลื่อนขั้นเป็น Admin แล้ว!
echo "<br>";

// ลองดูโปรไฟล์สมชายอีกครั้ง
echo $user1->showProfile();
// ผลลัพธ์: สวัสดี! ฉันชื่อ Somchai ตำแหน่งคือ admin

?>