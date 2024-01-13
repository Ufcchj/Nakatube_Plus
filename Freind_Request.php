To create a basic PHP script for handling friend requests, you'll need a database to store relationships between users. Below is a simplified example using MySQL. Make sure to adapt it to your specific needs.

```php
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

// Function to send a friend request
function sendFriendRequest($senderId, $receiverId) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("ii", $senderId, $receiverId);
    $stmt->execute();
}

// Example: Send friend request
$senderUserId = 1; // Replace with the actual sender's user ID
$receiverUserId = 2; // Replace with the actual receiver's user ID

sendFriendRequest($senderUserId, $receiverUserId);

echo "Friend request sent successfully.";

// Function to accept a friend request
function acceptFriendRequest($requestId) {
    global $conn;

    $stmt = $conn->prepare("UPDATE friend_requests SET status = 'accepted' WHERE id = ?");
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
}

// Example: Accept friend request
$friendRequestId = 1; // Replace with the actual friend request ID

acceptFriendRequest($friendRequestId);

echo "Friend request accepted.";

// Close the database connection
$conn->close();
?>
```

This script includes functions for sending friend requests and accepting them. It assumes a database table named `friend_requests` with columns like `id`, `sender_id`, `receiver_id`, and `status`.

Make sure to customize the code based on your database schema and application requirements. Additionally, add error handling and security measures as needed.
