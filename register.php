<?php include('header.php'); 

if(isset($_POST['register'])) {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (full_name, email, password, role) VALUES ('$name', '$email', '$pass', '$role')";
    if(mysqli_query($conn, $sql)) {
        header("Location: login.php");
    } else {
        $error = "Registration failed. Email might already exist.";
    }
}
?>

<div class="container" style="max-width: 400px;">
    <h2>Create Account</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="user">I want to give waste</option>
            <option value="driver">I am a Delivery Partner</option>
        </select>
        <button type="submit" name="register">Register</button>
    </form>
</div>