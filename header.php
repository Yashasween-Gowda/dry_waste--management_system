<?php 
// 1. Session start is handled here once for the whole site
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

include('db.php'); 

// 2. Get the current filename for the active class
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Dry Waste Management</title>
</head>
<body>

<nav>
  <div> <a href="index.php" style="display: flex; align-items: center; text-decoration: none;">
    <img src="assets/logo.jpeg" alt="Trash2Treasure" 
         style="height: 80px; width: auto; object-fit: contain; margin-right: 10px; transition: transform 0.3s ease;border-radius:18px;">
    
    <span style="color: #27ae60; font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px;">
        Trash2Treasure
    </span>
</a></div>
    <!--div class="logo">♻️ Trash2Treasure</div>-->
    <div>
        <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
        <a href="guidelines.php" class="<?php echo ($current_page == 'guidelines.php') ? 'active' : ''; ?>">Guidelines</a>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="shop.php" class="<?php echo ($current_page == 'shop.php') ? 'active' : ''; ?>">E-Shop</a>
            
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'driver'): ?>
                <a href="driver_dashboard.php" class="<?php echo ($current_page == 'driver_dashboard.php') ? 'active' : ''; ?>" style="color: #27ae60; font-weight: bold;">🚚 Driver Panel</a>
            <?php else: ?>
                <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Post Waste</a>
            <?php endif; ?>

            <a href="coupons.php" class="<?php echo ($current_page == 'coupons.php') ? 'active' : ''; ?>">My Coupons</a>

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin_panel.php" class="<?php echo ($current_page == 'admin_panel.php') ? 'active' : ''; ?>" style="color: #f1c40f;">★ Admin Panel</a>
            <?php endif; ?>

            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php" class="<?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Login</a>
            <a href="register.php" class="<?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">Register</a>
        <?php endif; ?>
    </div>
</nav>