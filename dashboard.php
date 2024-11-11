<?php
// Start the session to check if the user is logged in
session_start();

// Include database connection or necessary files
require("config.php");

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get user id from session (assuming user_id is stored in session after login)
$user_id = $_SESSION['user_id'];

// Create connection to the database
$connection = new mysqli('localhost', 'root', '', 'facebook_clone');

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch user details based on the logged-in user's ID
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch the user data
} else {
    // Redirect to login if no user found
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
        }
        .user-info {
            margin-top: 20px;
        }
        .user-info p {
            font-size: 18px;
        }
        .logout-btn {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome to Your Dashboard, <?php echo $user['first_name']; ?>!</h1>
    
    <div class="user-info">
        <p><strong>First Name:</strong> <?php echo $user['first_name']; ?></p>
        <p><strong>Last Name:</strong> <?php echo $user['last_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Address:</strong> <?php echo $user['address']; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $user['phone_number']; ?></p>
        <p><strong>Gender:</strong> <?php echo $user['gender']; ?></p>
    </div>

    <a href="login.php"><button class="logout-btn">Logout</button></a>
</div>

</body>
</html>

<?php
// Close the connection
$connection->close();
?>
