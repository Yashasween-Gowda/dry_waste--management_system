<?php 
include('header.php'); 
// Check if user is a driver; if not, redirect to standard dashboard
if($_SESSION['role'] !== 'driver') { header("Location: dashboard.php"); exit(); }
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="container" style="margin-top: 30px;">
    <div style="background: #2c3e50; color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="margin: 0;">🚚 Driver Command Center</h2>
        <p style="margin: 10px 0 0 0; opacity: 0.8;">Assign weights and collect waste to generate user coupons.</p>
    </div>

    <div style="background: white; padding: 10px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 40px;">
        <div id="driverMap" style="height: 450px; border-radius: 10px;"></div>
    </div>

    <h3 style="color: #2c3e50; border-bottom: 3px solid #27ae60; padding-bottom: 10px; display: inline-block;">📋 Pending Collections</h3>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; margin-top: 20px;">
        <?php
        $requests = mysqli_query($conn, "SELECT * FROM waste_posts WHERE status='pending' ORDER BY id DESC");
        if(mysqli_num_rows($requests) > 0) {
            while($row = mysqli_fetch_assoc($requests)) {
                ?>



<a href="https://www.google.com/maps/search/?api=1&query=<?php echo $row['latitude']; ?>,<?php echo $row['longitude']; ?>" 
   target="_blank" 
   style="color: #3498db; text-decoration: none; font-size: 0.85rem; font-weight: bold; margin-bottom: 10px; display: block;">
   <i class="fa-solid fa-route"></i> Get Directions
</a>


                <div style="background: white; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; transition: 0.3s; box-shadow: 0 2px 5px rgba(0,0,0,0.05);" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    
                    <div style="height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="<?php echo $row['image_path']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div style="padding: 20px;">
                        <p style="font-size: 12px; color: #7f8c8d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
                            📍 Lat: <?php echo $row['latitude']; ?> | Lng: <?php echo $row['longitude']; ?>
                        </p>

                        <form action="complete_pickup.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                            <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            
                            <div style="display: flex; align-items: center; gap: 10px; background: #f1f2f6; padding: 10px; border-radius: 8px;">
                                <i class="fa-solid fa-weight-hanging" style="color: #27ae60;"></i>
                                <input type="number" name="weight" placeholder="Actual Weight (kg)" required step="0.1" 
                                       style="border: none; background: transparent; width: 100%; outline: none; font-size: 1rem;">
                            </div>

                            <button type="submit" name="complete" style="background: #27ae60; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                                ✅ Mark Collected & Reward User
                            </button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p style='color: #7f8c8d;'>No pending pickups at the moment. Good job!</p>";
        }
        ?>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('driverMap').setView([12.9716, 77.5946], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    <?php
    // Re-run query to place markers
    $markers = mysqli_query($conn, "SELECT latitude, longitude, id FROM waste_posts WHERE status='pending'");
    while($m = mysqli_fetch_assoc($markers)) {
        echo "L.marker([{$m['latitude']}, {$m['longitude']}]).addTo(map).bindPopup('Collection ID: {$m['id']}');";
    }
    ?>
</script>

<?php include('footer.php'); ?>