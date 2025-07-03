<?php
include 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $news_id = intval($_GET['id']);

    // Check if user already liked
    $check = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND news_id = ?");
    $check->bind_param("ii", $user_id, $news_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        // Not liked yet ➔ Insert like
        $insert = $conn->prepare("INSERT INTO likes (user_id, news_id) VALUES (?, ?)");
        $insert->bind_param("ii", $user_id, $news_id);
        $insert->execute();
        $insert->close();

        // Also increase like count in news table
        $conn->query("UPDATE news SET likes = likes + 1 WHERE id = $news_id");
    }
    
    $check->close();
}

header("Location: index.php");
exit();
?>
