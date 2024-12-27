<?php
include 'admin_class.php';
$action = new Action();

$action_type = isset($_GET['action']) ? $_GET['action'] : '';

// Debug
error_log("AJAX action: " . $action_type);
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

switch($action_type) {
    case 'login':
        echo $action->login();
        break;
    case 'save_menu':
        echo $action->save_menu();
        break;
    case 'delete_menu':
        echo $action->delete_menu();
        break;
    default:
        echo 0;
        break;
}
?>