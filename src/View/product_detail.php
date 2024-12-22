<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Detail</title>
    <style>
        .product-detail {
            width: 50%;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            text-align: left;
        }
        .product-detail img {
            width: 100%;
        }
        .product-detail h2 {
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>Product Detail</h1>
    <?php if (isset($product) && $product): ?>
        <div class="product-detail">
            <h2><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><strong>Category ID:</strong> <?php echo htmlspecialchars($product['category_id'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Price:</strong> <?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($product['status'], ENT_QUOTES, 'UTF-8'); ?></p>
            <img src="<?php echo htmlspecialchars('/php-Workspace/DuAn_WebMonAn_Nhom6/assets/img/' . basename($product['img_path']), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
</body>
</html>
