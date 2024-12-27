<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Food Ordering System</title>
    
    <!-- jQuery PHẢI được load đầu tiên -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>Admin Login</h1>
            <p>Food Ordering System</p>
        </div>

        <form id="login-form" action="" method="POST">
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user"></i> Username
                </label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       class="form-control" 
                       required>
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control" 
                       required>
            </div>

            <div id="alert-msg"></div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#login-form').submit(function(e){
        e.preventDefault();
        $('#alert-msg').html('');
        
        $.ajax({
            url: 'ajax.php?action=login',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if(resp == 1){
                    // Check user type from session and redirect accordingly
                    $.get('check_type.php', function(type) {
                        if(type == 1) {
                            window.location.href = 'home.php';
                        } else {
                            window.location.href = 'staff_home.php';
                        }
                    });
                } else {
                    $('#alert-msg').html('<div class="alert alert-danger">Username or password is incorrect.</div>');
                }
            },
            error: function(){
                $('#alert-msg').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
            }
        });
    });
});
</script>

</body>
</html>