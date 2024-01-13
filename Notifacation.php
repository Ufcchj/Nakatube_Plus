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

// Function to send a notification
function sendNotification($userId, $message) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $userId, $message);
    $stmt->execute();
}

// Example: Send a notification
$recipientUserId = 2; // Replace with the actual recipient's user ID
$notificationMessage = "You have a new friend request!"; // Replace with the actual notification message

sendNotification($recipientUserId, $notificationMessage);

echo "Notification sent successfully.";

// Function to retrieve user notifications
function getUserNotifications($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = $result->fetch_all(MYSQLI_ASSOC);

    return $notifications;
}

// Example: Display user notifications
$userWithNotificationsId = 2; // Replace with the actual user ID

$userNotifications = getUserNotifications($userWithNotificationsId);

foreach ($userNotifications as $notification) {
    echo "Message: " . $notification['message'] . "<br>";
    echo "Created at: " . $notification['created_at'] . "<br><br>";
}

// Close the database connection
$conn->close();
?>
