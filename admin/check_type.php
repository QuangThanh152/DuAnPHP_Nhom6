<?php
session_start();
echo isset($_SESSION['login_type']) ? $_SESSION['login_type'] : 0;
?>