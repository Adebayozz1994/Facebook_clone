<?php
// Start the session to store user data after login
session_start();

require("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create connection to the database
    $connection = new mysqli('localhost', 'root', '', 'facebook_clone');

    // Check the connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Query to fetch user based on email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify if the password matches
    if ($user && password_verify($password, $user['password'])) {
        // Successful login, store user information in session
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        
        // Redirect to dashboard.php
        header("Location: dashboard.php");
        exit;  // Exit to prevent further code execution
    } else {
        // If login fails, show error message
        echo "Invalid email or password.";
    }

    // Close the database connection
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
