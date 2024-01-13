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

// Function to create a post
function createPost($userId, $content) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO posts (user_id, content, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $userId, $content);
    $stmt->execute();
}

// Example: Create a post
$authorUserId = 1; // Replace with the actual author's user ID
$postContent = "This is a sample post."; // Replace with the actual post content

createPost($authorUserId, $postContent);

echo "Post created successfully.";

// Function to get user feed
function getUserFeed($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT username, content, created_at FROM posts
                            INNER JOIN users ON posts.user_id = users.id
                            WHERE user_id IN (SELECT friend_id FROM friendships WHERE user_id = ?)
                            ORDER BY created_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $feed = $result->fetch_all(MYSQLI_ASSOC);

    return $feed;
}

// Example: Display user feed
$userFeedUserId = 1; // Replace with the actual user ID

$userFeed = getUserFeed($userFeedUserId);

foreach ($userFeed as $post) {
    echo "Username: " . $post['username'] . "<br>";
    echo "Content: " . $post['content'] . "<br>";
    echo "Created at: " . $post['created_at'] . "<br><br>";
}

// Close the database connection
$conn->close();
?>
