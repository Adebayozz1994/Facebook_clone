<?php
// require_once("config.php");
require_once("users.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];

    // Instantiate the User class to handle user creation
    $user = new User();
    $response = $user->createUser($first_name, $last_name, $email, $password, $address, $phone_number, $gender);

    // If the registration is successful, redirect to the login page
    if ($response['status']) {
        header("Location: login.php");  // Redirect to login.php
        exit;  // Make sure to exit after the redirect
    } else {
        // If there was an error, show the error message
        echo "Error: " . $response['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <label>First Name:</label><br>
        <input type="text" name="first_name" required><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br>

        <label>Address:</label><br>
        <input type="text" name="address"><br>

        <label>Phone Number:</label><br>
        <input type="text" name="phone_number"><br>

        <label>Gender:</label><br>
        <select name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>

    <!-- Optionally add a link to the login page -->
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
