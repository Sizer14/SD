<?php
session_start();
include 'db.php';
$categories = $conn->query("SELECT * FROM categories");

$cat_result = $conn->query("SELECT * FROM categories");
$stmt = $conn->prepare("INSERT INTO news (title, content, image_url, author, category_id, approved) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssii", $title, $content, $image_url, $author, $category_id, $approved);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Safely get the role
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $author = $_SESSION['username'];
    $approved = ($role === 'admin') ? 1 : 0;

    $image_path = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . uniqid() . "_" . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            $message = "❌ Failed to upload image.";
        }
    }

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO news (title, content, image_url, author, approved) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $title, $content, $image_path, $author, $approved);

        if ($stmt->execute()) {
            $message = "✅ News posted successfully!";
            if ($approved == 0) {
                $message .= " Waiting for admin approval.";
            }
        } else {
            $message = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "❗ Title and content are required.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post News</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 40px; }
        form { background: white; padding: 20px; max-width: 600px; margin: auto; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="text"], textarea, input[type="file"] {
            width: 100%; padding: 10px; margin-bottom: 15px;
            border: 1px solid #ccc; border-radius: 4px;
        }
        input[type="submit"] {
            background: #222; color: white; padding: 10px 20px;
            border: none; cursor: pointer;
        }
        input[type="submit"]:hover { background: #444; }
        .message { margin-bottom: 15px; font-weight: bold; }
        a.back-link {
            display: block; margin-bottom: 20px; text-align: center;
            text-decoration: none; color: #007BFF;
        }
    </style>
</head>
<body>

<a href="index.php" class="back-link">← Back to Home</a>

<form action="" method="POST" enctype="multipart/form-data">
    <h2>📝 Post a News Article</h2>
    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

    <label for="title">News Title:</label>
    <input type="text" name="title" id="title" required>

    <label for="content">Content:</label>
    <textarea name="content" id="content" rows="7" required></textarea>

    <label for="image">Upload Image (optional):</label>
    <input type="file" name="image" id="image" accept="image/*">

    <input type="submit" value="Post News">

    <label for="category_id">Select Category:</label>
<select name="category_id">
    <option value="">Select Category</option>
    <?php while($cat = $categories->fetch_assoc()): ?>
        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
    <?php endwhile; ?>
</select>






</form>

</body>
</html>
