<?php
include 'db.php';

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        echo "✅ Post deleted successfully.";
    } else {
        echo "❌ Error deleting post: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // After delete, redirect back to homepage
    header("Location: index.php");
    exit();
} else {
    echo "❌ No post ID specified.";
}
?>
