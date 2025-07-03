<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['news_id'], $_POST['comment'], $_SESSION['user_id'])) {
    $news_id = intval($_POST['news_id']);
    $comment = trim($_POST['comment']);
    $user_id = $_SESSION['user_id'];

    if (!empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO comments (news_id, user_id, comment_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $news_id, $user_id, $comment);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: index.php");
    exit();
}
?>




