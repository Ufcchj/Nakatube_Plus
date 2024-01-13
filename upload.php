<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["video"])) {
    $targetDir = "videos/";
    $targetFile = $targetDir . basename($_FILES["video"]["name"]);
    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is a video
    $check = getimagesize($_FILES["video"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        $uploadOk = 0;
    }

    // Check file size (you can adjust the size limit)
    if ($_FILES["video"]["size"] > 50000000) {
        $uploadOk = 0;
    }

    // Allow certain video file formats
    if ($videoFileType != "mp4") {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your video was not uploaded.";
    } else {
        // Upload the video to the specified directory
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFile)) {
            echo "The video has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your video.";
        }
    }
} else {
    echo "Invalid request.";
}
?>
