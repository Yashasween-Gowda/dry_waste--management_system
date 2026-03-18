<?php include('header.php'); ?>

<div class="container" style="margin-top: 30px;">
    <h2 style="border-bottom: 3px solid #27ae60; padding-bottom: 10px; margin-bottom: 30px; color: #2c3e50;">
        ♻️ Sustainable Treasures
    </h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px;">
        <?php
        // Fetch products from database
        $res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
        
        if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
                // Realistic random ratings
                $rating = rand(4, 5); 
                $reviews = rand(10, 100);
                ?>
                
                <div class="product-card" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.05);" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    
                    <div style="width: 100%; height: 220px; background: #fdfdfd; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #f0f0f0;">
                        <img src="product_images/<?php echo $row['product_image']; ?>" 
                             style="max-width: 90%; max-height: 90%; object-fit: contain; border-radius: 8px;">
                    </div>

                    <div style="padding: 15px; display: flex; flex-direction: column; flex-grow: 1;">
                        <span style="font-size: 11px; color: #27ae60; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                            🌱 <?php echo htmlspecialchars($row['category']); ?>
                        </span>

                        <h3 style="font-size: 17px; color: #2c3e50; margin: 8px 0 4px 0; font-weight: 600; min-height: 45px; line-height: 1.3;">
                            <?php echo htmlspecialchars($row['product_name']); ?>
                        </h3>

                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <span style="color: #ffa41c; font-size: 14px;">
                                <?php 
                                for($i=1; $i<=5; $i++) {
                                    echo ($i <= $rating) ? "★" : "☆";
                                }
                                ?>
                            </span>
                            <span style="font-size: 12px; color: #007185; margin-left: 8px;">
                                (<?php echo $reviews; ?> reviews)
                            </span>
                        </div>

                        <p style="font-size: 13px; color: #7f8c8d; margin-bottom: 15px; height: 36px; overflow: hidden; line-height: 1.4;">
                            <?php echo htmlspecialchars($row['description']); ?>
                        </p>

                        <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <div>
                                <span style="font-size: 22px; font-weight: 700; color: #2c3e50;">
                                    ₹<?php echo number_format($row['price'], 2); ?>
                                </span>
                                <p style="font-size: 11px; color: <?php echo ($row['stock_count'] > 0) ? '#c45500' : 'red'; ?>; margin: 2px 0;">
                                    <?php echo ($row['stock_count'] > 0) ? "Only " . $row['stock_count'] . " left in stock!" : "Out of Stock"; ?>
                                </p>
                            </div>
                        </div>

                        <a href="checkout.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                            <button style="width: 100%; background: #2c3e50; color: white; border: none; padding: 12px; border-radius: 8px; font-size: 14px; cursor: pointer; font-weight: bold; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                🛒 Buy Now
                            </button>
                        </a>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "<div style='grid-column: 1/-1; text-align: center; padding: 50px;'>
                    <p style='color: #7f8c8d; font-size: 1.2rem;'>Our eco-shelves are currently empty. Check back soon!</p>
                  </div>";
        }
        ?>
    </div>
</div>

<style>
    /* Adding a subtle hover effect to the Buy button */
    .product-card button:hover {
        background: #34495e !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>

<?php include('footer.php'); ?>