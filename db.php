<?php
// Database configuration
$host = "localhost";
$user = "root";     // Default XAMPP username
$pass = "";         // Default XAMPP password is empty
$dbname = "dry_waste_management"; // Make sure this matches your DB name in phpMyAdmin

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session so login information is remembered across pages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>