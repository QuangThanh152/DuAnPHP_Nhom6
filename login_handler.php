<?php
require 'vendor/autoload.php';
require 'config/credentials.php';

session_start();

use App\Controllers\LoginController;

$loginController = new LoginController();
$loginController->login($_POST['username'], $_POST['password']);
?>
