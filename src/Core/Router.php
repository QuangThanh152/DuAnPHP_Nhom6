<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function addRoute($pattern, $callback) {
        $this->routes[$pattern] = $callback;
    }
    
    public function match($uri) {
        // Sắp xếp routes theo độ cụ thể (các mẫu dài hơn trước)
        uksort($this->routes, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Loại bỏ phần match đầy đủ
                call_user_func_array($callback, $matches);
                return;
            }
        }
    }
}
?>
