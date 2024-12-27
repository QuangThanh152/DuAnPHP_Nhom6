<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAccess($requiredType = null) {
    // Check if user is logged in
    if(!isset($_SESSION['login_id'])) {
        header("Location: index.php");
        exit;
    }

    // If specific access type is required
    if($requiredType !== null) {
        if(!isset($_SESSION['login_type']) || $_SESSION['login_type'] != $requiredType) {
            // Redirect to appropriate page based on user type
            if(isset($_SESSION['login_type'])) {
                if($_SESSION['login_type'] == 1) {
                    header("Location: home.php");
                } else {
                    header("Location: staff_home.php");
                }
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
}
?>