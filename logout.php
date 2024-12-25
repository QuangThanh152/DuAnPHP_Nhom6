<?php
session_start();
unset($_SESSION['user']);
session_destroy();
header("Location: /php-Workspace/DuAn_WebMonAn_Nhom6/login");
exit();
?>
