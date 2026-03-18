<?php include('header.php'); ?>

<div style="background: linear-gradient(135deg, #1e522e 0%, #27ae60 100%); color: white; padding: 100px 20px; text-align: center; border-bottom: 5px solid #f1c40f;">
    <h1 style="font-size: 3.5rem; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">Turn Your Trash into Treasure ♻️</h1>
    <p style="font-size: 1.3rem; margin-bottom: 35px; max-width: 800px; margin-left: auto; margin-right: auto; opacity: 0.9;">
        Join our community in cleaning the planet. Dispose of dry waste responsibly and get rewarded with exclusive coupons.
    </p>
    <div style="display: flex; justify-content: center; gap: 20px;">
        <a href="dashboard.php" style="background: white; color: #27ae60; padding: 15px 35px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">Start Recycling</a>
        <a href="shop.php" style="background: transparent; color: white; border: 2px solid white; padding: 13px 35px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 1.1rem;">Visit Shop</a>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container" style="margin-top: 50px; text-align: center;">
    <h2 style="font-size: 2.2rem; color: #2c3e50; margin-bottom: 10px; font-weight: 700;">What Can You Recycle?</h2>
    <p style="color: #7f8c8d; margin-bottom: 40px;">Dispose of these items to earn Treasure Points.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 25px;">
        <?php
        // Category Name => Font Awesome Icon Class
        $categories = [
    ['Paper Waste', 'fa-file-lines'], 
    ['Plastic Bottles', 'fa-bottle-water'], 
    ['Cardboard', 'fa-box-open'], 
    ['Glass Bottles', 'fa-wine-glass'], 
    ['Metal Cans', 'fa-faucet-drip'], // Reliable icon for metal/steel
    ['Old Clothes', 'fa-shirt'], 
    ['E-Waste', 'fa-microchip'],    // Better icon for electronics
    ['Rubber Tires', 'fa-compact-disc'], // Looks exactly like a tire/rubber ring
    ['Wood Waste', 'fa-tree'], 
    ['Plastic Bags', 'fa-bag-shopping']
];

        foreach ($categories as $cat) {
            echo "
            <a href='guidelines.php' style='text-decoration: none; color: inherit;'>
                <div class='cat-card' style='background: white; border: 1px solid #e0e0e0; padding: 30px 20px; border-radius: 12px; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center;'>
                    <i class='fa-solid {$cat[1]}' style='font-size: 2.5rem; color: #27ae60; margin-bottom: 15px;'></i>
                    <div style='font-weight: 600; color: #34495e; font-size: 1.1rem;'>{$cat[0]}</div>
                </div>
            </a>";
        }
        ?>
    </div>
</div>

<style>
    .cat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        border-color: #27ae60 !important;
    }
    .cat-card:hover i {
        color: #1e522e !important;
    }
</style>

...