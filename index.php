<?php

// Bao gồm các file cần thiết
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Core/Router.php'; // Đảm bảo rằng đường dẫn đúng

// Bao gồm các routes
$router = require __DIR__ . '/src/Core/routes.php';

// Xử lý request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->match($uri);
?>
