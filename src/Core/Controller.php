<?php
namespace App\Core;

class Controller {
    protected function render($view_name, $data = []) {
        // Giải nén dữ liệu để sử dụng trong view
        extract($data);

        // Đảm bảo rằng đường dẫn file view là an toàn và tồn tại
        $file = APPROOT . "/src/View/" . $view_name . ".php";
        
        if (is_readable($file)) {
            include $file;
        } else {
            die('<h1> 404 Page not found </h1>');
        }
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}
?>
