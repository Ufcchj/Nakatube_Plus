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

// Function to search for users
function searchUsers($query) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username LIKE ?");
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = $result->fetch_all(MYSQLI_ASSOC);

    return $users;
}

// Example: Perform a user search
$searchQuery = "john"; // Replace with the actual search query

$searchResults = searchUsers($searchQuery);

foreach ($searchResults as $user) {
    echo "User ID: " . $user['id'] . "<br>";
    echo "Username: " . $user['username'] . "<br><br>";
}

// Close the database connection
$conn->close();
?> 
