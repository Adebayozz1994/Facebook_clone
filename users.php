<?php
require("config.php");

class User extends Config {
    public function __construct() {
        parent::__construct();
    }

    public function createUser($first_name, $last_name, $email, $password, $address, $phone_number, $gender) {
        $query = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `address`, `phone_number`, `gender`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $binder = array('sssssss', $first_name, $last_name, $email, $hashPassword, $address, $phone_number, $gender);

        // Check if email exists
        $emailQuery = "SELECT * FROM `users` WHERE `email` = ?";
        $emailBinder = array('s', $email);
        $emailResult = $this->checkIfExist($emailQuery, $emailBinder);

        if ($emailResult) {
            return [
                'status' => false,
                'message' => 'Email already exists'
            ];
        } else {
            $result = $this->create($query, $binder);
            return $result ? 
                ['status' => true, 'message' => 'User registered successfully'] :
                ['status' => false, 'message' => 'Error occurred'];
        }
    }
}

// Usage Example
$newUser = new User();
$response = $newUser->createUser("John", "Doe", "john@example.com", "password123", "123 Main St", "1234567890", "male");
echo json_encode($response);
?>