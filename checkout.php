<?php 
include('header.php'); 

// 1. Safety Check: Must be logged in
if(!isset($_SESSION['user_id'])) { 
    echo "<script>alert('Please login to checkout'); window.location='login.php';</script>";
    exit(); 
}

// 2. Get Product Details safely
if(!isset($_GET['id'])) {
    header("Location: shop.php");
    exit();
}

$product_id = mysqli_real_escape_string($conn, $_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch product details - matching the column names from your shop.php
$product_query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
$product = mysqli_fetch_assoc($product_query);

if(!$product) { 
    die("Product not found."); 
}

// 3. Fetch user's total available coupon value (Sum of all unused rewards)
$coupon_query = mysqli_query($conn, "SELECT SUM(discount_value) as total_credit FROM coupons WHERE user_id = '$user_id' AND is_used = 0");
$coupon_data = mysqli_fetch_assoc($coupon_query);
$available_credit = $coupon_data['total_credit'] ?? 0;

// Calculate the potential discount
$discount = min($available_credit, $product['price']);
$total_after_coupon = max(0, $product['price'] - $discount);
?>

<div class="container" style="margin-top: 50px; max-width: 850px;">
    <h2 style="text-align: center; color: #2c3e50; margin-bottom: 30px;">Complete Your Purchase 🛍️</h2>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; background: white; padding: 40px; border-radius: 24px; box-shadow: 0 15px 40px rgba(0,0,0,0.08); border: 1px solid #f0f0f0;">
        
        <div style="text-align: center;">
            <div style="background: #fdfdfd; padding: 20px; border-radius: 20px; border: 1px solid #f5f5f5; margin-bottom: 20px;">
                <img src="product_images/<?php echo $product['product_image']; ?>" 
                     style="width: 100%; max-height: 250px; object-fit: contain; border-radius: 15px;">
            </div>
            <h3 style="color: #2c3e50; margin: 15px 0 5px 0;"><?php echo htmlspecialchars($product['product_name']); ?></h3>
            <p style="color: #7f8c8d; font-size: 0.95rem; line-height: 1.5;">
                <?php echo htmlspecialchars($product['description']); ?>
            </p>
            <span style="display: inline-block; background: #e8f5e9; color: #27ae60; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">
                ♻️ <?php echo htmlspecialchars($product['category']); ?>
            </span>
        </div>

        <div style="border-left: 1px solid #eee; padding-left: 40px;">
            <h3 style="color: #2c3e50; margin-top: 0;">Order Summary</h3>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
            
            <div style="display: flex; justify-content: space-between; margin: 15px 0; font-size: 1.1rem;">
                <span style="color: #555;">Product Price:</span>
                <span style="font-weight: 700; color: #2c3e50;">₹<?php echo number_format($product['price'], 2); ?></span>
            </div>

            <div style="background: #f8f9fa; padding: 15px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #27ae60;">
                <p style="margin: 0; font-size: 0.9rem; color: #27ae60; font-weight: 600;">
                    <i class="fa-solid fa-wallet"></i> Reward Balance: ₹<?php echo number_format($available_credit, 2); ?>
                </p>
                <p style="margin: 5px 0 0 0; font-size: 0.8rem; color: #7f8c8d;">
                    You can use this balance to reduce the price.
                </p>
            </div>

            <form action="place_order.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="total_amount" value="<?php echo $product['price']; ?>">

                <p style="font-weight: 700; color: #2c3e50; margin-bottom: 15px; font-size: 0.95rem;">Select Payment Method:</p>
                
                <label style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 10px; margin-bottom: 12px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.borderColor='#27ae60'" onmouseout="this.style.borderColor='#ddd'">
                    <input type="radio" name="payment_method" value="cash" checked style="accent-color: #27ae60;">
                    <div>
                        <span style="display: block; font-weight: 600; font-size: 0.9rem;">Cash on Delivery</span>
                        <small style="color: #7f8c8d;">Pay full amount ₹<?php echo number_format($product['price'], 2); ?> at your door.</small>
                    </div>
                </label>

                <?php if($available_credit > 0): ?>
                <label style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 10px; margin-bottom: 25px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.borderColor='#27ae60'" onmouseout="this.style.borderColor='#ddd'">
                    <input type="radio" name="payment_method" value="coupon" style="accent-color: #27ae60;">
                    <div>
                        <span style="display: block; font-weight: 600; font-size: 0.9rem; color: #27ae60;">Apply Eco-Rewards</span>
                        <small style="color: #7f8c8d;">New Price: <strong>₹<?php echo number_format($total_after_coupon, 2); ?></strong></small>
                    </div>
                </label>
                <?php else: ?>
                <p style="font-size: 0.8rem; color: #e74c3c; margin-bottom: 25px;">
                    <i class="fa-solid fa-circle-info"></i> Recycle more to unlock reward discounts!
                </p>
                <?php endif; ?>

                <button type="submit" name="confirm_order" style="width: 100%; background: #27ae60; color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 800; cursor: pointer; font-size: 1.1rem; transition: 0.3s; box-shadow: 0 4px 15px rgba(39, 174, 96, 0.2);">
                    Confirm Order
                </button>
            </form>
            
            <p style="text-align: center; margin-top: 20px;">
                <a href="shop.php" style="color: #adb5bd; text-decoration: none; font-size: 0.9rem;">← Return to Shop</a>
            </p>
        </div>
    </div>
</div>

<style>
    label:has(input:checked) {
        border-color: #27ae60 !important;
        background-color: #f0fff4;
    }
</style>

<?php include('footer.php'); ?>