
<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $image_url = trim($_POST["image_url"]);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO news (title, content, image_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $image_url);

        if ($stmt->execute()) {
            $message = "News posted successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Title and content are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post News - Varendra Alo</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 40px; }
        form { background: white; padding: 20px; max-width: 600px; margin: auto; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="text"], textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { background: #222; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        input[type="submit"]:hover { background: #444; }
        .message { margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>

<h2 style="text-align:center;">📰 Post a News Article</h2>

<form action="" method="POST">
    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

    <label for="title">News Title:</label>
    <input type="text" name="title" id="title" required>

    <label for="content">Content:</label>
    <textarea name="content" id="content" rows="7" required></textarea>

    <label for="image_url">Image URL (optional):</label>
    <input type="text" name="image_url" id="image_url" placeholder="e.g. images/news1.jpg">

    <input type="submit" value="Post News">
</form>

</body>
</html>