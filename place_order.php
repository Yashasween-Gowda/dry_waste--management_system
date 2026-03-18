<?php
session_start();
include('db.php');

// Safety Check: Ensure the user is logged in and the form was actually submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    
    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $amount = mysqli_real_escape_string($conn, $_POST['total_amount']);

    // 1. Handle Coupon Logic
    if ($method == 'coupon') {
        // Find how many coupons are needed to cover the cost (or just mark all current ones as used)
        // This query marks the user's unused coupons as 'used' because they are being traded for the product
        $update_coupons = "UPDATE coupons SET is_used = 1 WHERE user_id = '$user_id' AND is_used = 0";
        mysqli_query($conn, $update_coupons);
    }

    // 2. Insert the Order into the Database
    // Note: Ensure your 'orders' table has columns: user_id, product_id, method, amount, status
    $order_sql = "INSERT INTO orders (user_id, product_id, method, amount, status) 
                  VALUES ('$user_id', '$product_id', '$method', '$amount', 'Pending')";
    
    if (mysqli_query($conn, $order_sql)) {
        // 3. Success! Redirect to a confirmation page
        echo "<script>
                alert('Order placed successfully! Thank you for supporting the environment.');
                window.location='order_success.php';
              </script>";
    } else {
        // Show error if the database fails
        echo "Error placing order: " . mysqli_error($conn);
    }

} else {
    // If someone tries to access this file directly without posting the form
    header("Location: shop.php");
    exit();
}
?>