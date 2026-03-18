<?php 
include('header.php'); 

// Redirect if not logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<div class="container">
    <h2>My Rewards 🎟️</h2>
    <p>Every time you contribute dry waste, you earn discounts for our shop!</p>

    <div style="margin-top: 30px;">
        <h3>Available Coupons</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <?php
            $active_sql = "SELECT * FROM coupons WHERE user_id = '$user_id' AND is_used = 0";
            $active_res = mysqli_query($conn, $active_sql);

            if(mysqli_num_rows($active_res) > 0) {
                while($row = mysqli_fetch_assoc($active_res)) {
                    echo "<div style='border: 2px dashed var(--primary); padding: 15px; border-radius: 10px; background: #f9f9f9; text-align: center;'>
                            <span style='font-size: 0.8rem; color: #666;'>CODE:</span>
                            <h2 style='margin: 5px 0; color: var(--primary);'>{$row['coupon_code']}</h2>
                            <p style='font-weight: bold; margin: 0;'>Value: \${$row['discount_value']}</p>
                            <a href='shop.php'><button style='margin-top: 10px; padding: 5px 10px; font-size: 0.8rem;'>Use in Shop</button></a>
                          </div>";
                }
            } else {
                echo "<p style='color: #666;'>You don't have any active coupons. Post some waste to earn rewards!</p>";
            }
            ?>
        </div>
    </div>

    <hr style="margin: 40px 0; border: 0; border-top: 1px solid #eee;">

    <div style="margin-top: 20px;">
        <h3>Coupon History (Used)</h3>
        <table style="width: 100%; border-collapse: collapse; color: #777;">
            <tr style="border-bottom: 1px solid #ddd; text-align: left;">
                <th style="padding: 10px;">Code</th>
                <th style="padding: 10px;">Value</th>
            </tr>
            <?php
            $history_sql = "SELECT * FROM coupons WHERE user_id = '$user_id' AND is_used = 1";
            $history_res = mysqli_query($conn, $history_sql);

            while($h = mysqli_fetch_assoc($history_res)) {
                echo "<tr style='border-bottom: 1px solid #eee;'>
                        <td style='padding: 10px;'>{$h['coupon_code']}</td>
                        <td style='padding: 10px;'>\${$h['discount_value']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</div>