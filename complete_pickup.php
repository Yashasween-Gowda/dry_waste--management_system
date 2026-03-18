<?php
//session_start();
include('db.php');

if(isset($_POST['complete'])) {
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    
    // 1. Calculate Coupon Value ($2 per kg)
    $discount = $weight * 2.00;
    $coupon_code = "TRASH" . strtoupper(substr(md5(time()), 0, 6));

    // 2. Update Waste Post 
    // IMPORTANT: Check your database if the column is 'weight' or 'weight_kg'
    $update_sql = "UPDATE waste_posts SET status='collected', weight_kg='$weight' WHERE id=$post_id";
    mysqli_query($conn, $update_sql);

    // 3. Issue Coupon to the USER who posted the waste
    $sql = "INSERT INTO coupons (user_id, coupon_code, discount_value, is_used) 
            VALUES ('$user_id', '$coupon_code', '$discount', 0)";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Collection Successful! Weight: $weight kg. Coupon Generated: $coupon_code'); 
                window.location='driver_dashboard.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>