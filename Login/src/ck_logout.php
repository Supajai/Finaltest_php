<?php
session_start();
session_unset();
session_destroy();
header("Location: ck_login.php");
exit();
?>