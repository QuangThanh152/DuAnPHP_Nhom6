<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đồ Án PHP - Nhóm 6</title>
    <!-- font chữ -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <!-- font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth; 
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            line-height: 1.5;
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <!-- Include components -->
    <div id="header"><?php include '../partials/header.php'; ?></div>
    <div id="banner"><?php include '../partials/banner.php'; ?></div>
    <div id="menu"><?php include '../partials/menu.php'; ?></div>
    
    <div id="footer"><?php include '../partials/footer.php'; ?></div>

    <script src="../Components/JS/main.js"></script>
</body>
</html>
