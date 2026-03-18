<?php 
//session_start(); // Required to access user data
include('db.php'); 

// Redirect if not logged in
if(!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

include('header.php'); 
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="container" style="margin-top: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px;">
        <div>
            <h2 style="margin: 0; color: #2c3e50;">Welcome back, <span style="color: #27ae60;"><?php echo $_SESSION['user_name']; ?></span>! 👋</h2>
            <p style="margin: 5px 0 0 0; color: #7f8c8d;">Ready to turn some more trash into treasure today?</p>
        </div>
        <a href="shop.php" style="background: #27ae60; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.3s; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-cart-shopping"></i> Browse E-Shop
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 30px;">
        
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border-top: 5px solid #27ae60;">
            <h3 style="margin-top: 0; color: #2c3e50; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-cloud-arrow-up" style="color: #27ae60;"></i> Post New Dry Waste
            </h3>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

            <form action="process_waste.php" method="POST" enctype="multipart/form-data">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #34495e;">Select Waste Image:</label>
                <div style="border: 2px dashed #dcdde1; padding: 20px; text-align: center; border-radius: 10px; margin-bottom: 25px; background: #f8f9fa;">
                    <input type="file" name="waste_photo" accept="image/*" required style="cursor: pointer;">
                    <p style="font-size: 0.8rem; color: #95a5a6; margin-top: 10px;">PNG, JPG or JPEG (Max 2MB)</p>
                </div>

                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #34495e;">Confirm Pickup Location:</label>
                <p style="font-size: 0.85rem; color: #7f8c8d; margin-bottom: 15px;">
                    <i class="fa-solid fa-location-dot"></i> Drag the marker or click the map for your exact address.
                </p>

                <input type="hidden" id="lat" name="latitude">
                <input type="hidden" id="lng" name="longitude">

                <button type="submit" name="submit_waste" style="width: 100%; background: #27ae60; color: white; border: none; padding: 15px; border-radius: 8px; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);">
                    Schedule Pickup
                </button>
            </form>
        </div>

        <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #eee; background: white; padding: 10px;">
            <div id="map" style="height: 100%; min-height: 500px; border-radius: 10px;"></div>
        </div>

    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize map centered on Bangalore
    var map = L.map('map').setView([12.9716, 77.5946], 13); 

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Initial marker
    var marker = L.marker([12.9716, 77.5946], {draggable: true}).addTo(map);

    // Function to update hidden inputs
    function updateCoords(lat, lng) {
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
    }

    // Set initial values
    updateCoords(12.9716, 77.5946);

    // Get current location automatically
    map.locate({setView: true, maxZoom: 16});

    map.on('locationfound', function(e) {
        marker.setLatLng(e.latlng);
        updateCoords(e.latlng.lat, e.latlng.lng);
    });

    // Update coordinates when marker is dragged
    marker.on('dragend', function(event) {
        var position = marker.getLatLng();
        updateCoords(position.lat, position.lng);
    });

    // Update coordinates on map click
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoords(e.latlng.lat, e.latlng.lng);
    });
</script>

<?php include('footer.php'); ?>