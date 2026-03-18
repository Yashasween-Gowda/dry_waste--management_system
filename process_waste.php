<?php
//session_start(); // Mandatory for $_SESSION
include('db.php');

if(isset($_POST['submit_waste'])) {
    // Check if user is logged in
    if(!isset($_SESSION['user_id'])) {
        die("Please log in first.");
    }

    $user_id = $_SESSION['user_id'];
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];
    
    // Handle Image Upload
    $target_dir = "uploads/";
    // Create directory if it doesn't exist
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

    $file_name = time() . "_" . basename($_FILES["waste_photo"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["waste_photo"]["tmp_name"], $target_file)) {
        // Ensure column names match your database (waste_posts table)
        $sql = "INSERT INTO waste_posts (user_id, image_path, latitude, longitude, status) 
                VALUES ('$user_id', '$target_file', '$lat', '$lng', 'pending')";
        
        if(mysqli_query($conn, $sql)) {
            echo "<script>alert('Pickup Scheduled Successfully!'); window.location='dashboard.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>