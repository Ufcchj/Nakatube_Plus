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

// Function to get user profile information
function getUserProfile($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT username, email, bio FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username, $email, $bio);
    $stmt->fetch();

    $profileData = array(
        'username' => $username,
        'email' => $email,
        'bio' => $bio
    );

    return $profileData;
}

// Example: Display user profile
$userIdToDisplay = 1; // Replace with the actual user ID

$userProfile = getUserProfile($userIdToDisplay);

echo "Username: " . $userProfile['username'] . "<br>";
echo "Email: " . $userProfile['email'] . "<br>";
echo "Bio: " . $userProfile['bio'] . "<br>";

// Close the database connection
$conn->close();
?>
