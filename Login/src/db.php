<?php
$host = "db";
$user = "user1";
$password = "user1232";
$dbname = "login_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
