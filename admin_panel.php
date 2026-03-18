<?php 
include('header.php'); 

// 1. Security Check
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container'><h2>Access Denied. Admins Only.</h2></div>";
    exit();
}

if(isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $cat = $_POST['p_cat']; // From new dropdown
    $price = $_POST['p_price'];
    $stock = $_POST['p_stock']; // Keep stock management
    $desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
    
    // 2. Handle Image Upload
    $target_dir = "product_images/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = time() . "_" . basename($_FILES["p_img"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["p_img"]["tmp_name"], $target_file)) {
        // 3. Database Insert (Includes Category and Stock)
        $sql = "INSERT INTO products (product_name, category, price, description, product_image, stock_count) 
                VALUES ('$name', '$cat', '$price', '$desc', '$file_name', '$stock')";
        
        if(mysqli_query($conn, $sql)) {
            $success = "Treasure listed successfully!";
        } else {
            $error = "Database Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Failed to upload image. Check folder permissions.";
    }
}
?>

<div class="container" style="max-width: 600px;">
    <h2>Admin: Add New Upcycled Treasure</h2>
    
    <?php if(isset($success)) echo "<p style='color:green; font-weight:bold;'>✅ $success</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:red; font-weight:bold;'>❌ $error</p>"; ?>

    <form method="POST" enctype="multipart/form-data" style="display:grid; gap:12px;">
        <input type="text" name="p_name" placeholder="Product Name" required>
        
        <label><b>Created From (Waste Category):</b></label>
        <select name="p_cat" required style="padding: 10px; border-radius: 5px;">
            <option value="Paper Waste">Paper Waste</option>
            <option value="Plastic Bottles">Plastic Bottles</option>
            <option value="Cardboard Boxes">Cardboard Boxes</option>
            <option value="Glass Bottles">Glass Bottles</option>
            <option value="Metal Cans">Metal Cans</option>
            <option value="Old Clothes">Old Clothes</option>
            <option value="E-Waste">E-Waste</option>
            <option value="Rubber Tires">Rubber Tires</option>
            <option value="Wood Waste">Wood Waste</option>
            <option value="Plastic Bags">Plastic Bags</option>
        </select>

        <div style="display: flex; gap: 10px;">
            <input type="number" name="p_price" placeholder="Price ($)" step="0.01" style="flex:1;" required>
            <input type="number" name="p_stock" placeholder="Stock" style="flex:1;" required>
        </div>

        <textarea name="p_desc" placeholder="Describe how this was made from waste..." rows="4" required></textarea>
        
        <label><b>Product Image:</b></label>
        <input type="file" name="p_img" accept="image/*" required>
        
        <button type="submit" name="add_product" style="background: #27ae60; color:white; padding:15px; border:none; border-radius:5px; cursor:pointer; font-weight:bold;">
            LIST PRODUCT IN SHOP
        </button>
    </form>
</div>