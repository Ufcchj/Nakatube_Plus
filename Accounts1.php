<?php
// Connect to the database (replace placeholders with your actual database credentials)
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to securely hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify user login
function verifyLogin($username, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if (password_verify($password, $hashedPassword)) {
        return true; // Login successful
    } else {
        return false; // Incorrect password
    }
}

// Example of user registration
$username = "user123";
$password = "password123"; // You should validate and hash the password before storing

$hashedPassword = hashPassword($password);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);
$stmt->execute();

echo "User registered successfully.";

// Example of user login
$loginUsername = "user123";
$loginPassword = "password123";

if (verifyLogin($loginUsername, $loginPassword)) {
    echo "Login successful.";
} else {
    echo "Incorrect username or password.";
}

// Close the database connection
$conn->close();
?>
