<?php include('header.php'); ?>

<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: #f8f9fa; font-family: 'Inter', sans-serif;">
    <div style="background: white; padding: 50px; border-radius: 30px; box-shadow: 0 15px 50px rgba(0,0,0,0.05); text-align: center; max-width: 500px; width: 90%;">
        
        <div style="width: 100px; height: 100px; background: #e8f5e9; color: #27ae60; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 3rem;">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h1 style="color: #2c3e50; margin-bottom: 10px;">Order Placed!</h1>
        <p style="color: #7f8c8d; line-height: 1.6; margin-bottom: 30px;">
            Thank you for your purchase. Your order has been received and is being processed. By choosing sustainable products, you're making a real difference for the planet! 🌍
        </p>

        <div style="background: #fdfdfd; border: 1px dashed #ddd; padding: 20px; border-radius: 15px; margin-bottom: 30px;">
            <p style="margin: 0; color: #555; font-size: 0.9rem;">Order Status</p>
            <h3 style="margin: 5px 0; color: #27ae60;">Confirmed & Pending</h3>
        </div>

        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="dashboard.php" style="flex: 1; background: #2c3e50; color: white; text-decoration: none; padding: 15px; border-radius: 12px; font-weight: bold; font-size: 0.9rem;">
                Go to Dashboard
            </a>
            <a href="shop.php" style="flex: 1; background: #27ae60; color: white; text-decoration: none; padding: 15px; border-radius: 12px; font-weight: bold; font-size: 0.9rem;">
                Keep Shopping
            </a>
        </div>
        
        <p style="margin-top: 25px;">
            <a href="my_orders.php" style="color: #27ae60; text-decoration: none; font-size: 0.9rem; font-weight: 600;">View My Orders →</a>
        </p>
    </div>
</div>

<?php include('footer.php'); ?>