<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/access_control.php');
// Only allow admin (type = 1)
// checkAccess(1);

include('admin_class.php');
$action = new Action();
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/navbar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1>Welcome back Administrator!</h1>
            </div>

            <!-- Only show full admin dashboard to admin users -->
            <?php if($action->isAdmin()): ?>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Active Menu</h5>
                            <h2><?php echo $action->getActiveMenuCount(); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Inactive Menu</h5>
                            <h2><?php echo $action->getInactiveMenuCount(); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Orders for Verification</h5>
                            <h2><?php echo $action->getPendingOrdersCount(); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Confirmed Orders</h5>
                            <h2><?php echo $action->getConfirmedOrdersCount(); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>