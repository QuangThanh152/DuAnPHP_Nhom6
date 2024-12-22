<?php
function view($view, $data = [])
{   
  $file = APPROOT . '/src/View/' . $view . '.php';
  
  if (is_readable($file)) {
    if (isset($data['products'])) {
      $products = $data['products'];
    } else if (isset($data['product'])) {
      $product = $data['product'];
    } else if (isset($data['categories'])) {
      $categories = $data['categories'];
    } else if (isset($data['category'])) {
      $category = $data['category'];
    } else {
      echo 'The key does not exist in the array.';
    }
    require_once $file;
  } else {
    die('<h1> 404 Page not found </h1>');
  }
}

// Các hàm tiện ích khác
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function format_price($price) {
    return number_format($price, 2, '.', ',') . ' VND';
}

function is_logged_in() {
    return isset($_SESSION['user']);
}
?>
