<?php
include 'db.php';
// Only fetch approved posts
$sql = "SELECT * FROM news WHERE status = 'approved' ORDER BY date_published DESC";
$query = "SELECT * FROM news WHERE approved = 1 ORDER BY id DESC";


$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Varendra Alo - News Portal</title>
    <link rel="stylesheet" href="style.css">
 <style>

    /* General Page */
    body {
    font-family: 'Helvetica Neue', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

header {
    background:rgb(233, 83, 24);
    color: white;
    padding: 20px 0;
    text-align: center;
    border-bottom: 4px solid #b71c1c;
}

header h1 {
    margin: 0;
    font-size: 40px;
    font-weight: bold;
}

.navbar ul {
    display: flex;
    justify-content: center;
    padding: 0;
    margin: 10px 0;
    list-style: none;
    background:rgb(71, 68, 68);
}

.navbar ul li {
    margin: 0 15px;
}

.navbar ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 15px;
    display: block;
    transition: background 0.3s;
}

.navbar ul li a:hover {
    background:rgba(221, 205, 205, 0.77);
    border-radius: 5px;
}

.news-section {
    max-width: 100%;
    margin: 30px ;
    padding: 0 20px;
}

.news-item {
    background: white;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 8px;
    box-shadow: 0 0px 0px rgba(0,0,0,0.1);
}

.news-item img {
    width: 50%;
    height: auto;
    border-radius: 6px;
    margin-bottom: 10px;
}

.news-item h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #212121;
}

.news-item p {
    color: #444;
    line-height: 1.6;
}

.news-item hr {
    margin: 15px 0;
    border: none;
    border-top: 1px solid #ddd;
}

form textarea {
    width: 100%;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 4px;
}

form button {
    background-color: #007BFF;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 5px;
}

form button:hover {
    background-color: #0056b3;
}

footer {
    background: #212121;
    color: white;
    text-align: center;
    padding: 10px 0;
    font-size: 14px;
    margin-top: 30px;
}



</style>
</head>
<body>

<header>
    <h1 id="t1">VARENDRA ALO  🕯</h1>
    <nav class="navbar">
    
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php">Categories</a></li>
            <li><a href="admin.php">Admin</a></li>


        </ul>
    </nav>


</header>

<main>
<div class="navbar">
    <div class="news-section">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $title = htmlspecialchars($row['title']);
                $content = htmlspecialchars(substr($row['content'], 0, 100000));
                $date = date('F j, Y', strtotime($row['date_published']));
                $image = htmlspecialchars($row['image_url']);

                echo "<div class='news-item'>";
                if (!empty($image)) {
                    echo "<img src='$image' alt='News Image'>";
                }
                echo "<h2>$title</h2>";
                echo "<p><strong>Published:</strong> $date</p>";
                echo "<p>$content</p>";

                echo "<div style='margin-top:10px;'>";

               // Like button
                echo "<form action='like.php' method='get' style='display:inline;'>";
                echo "<input type='hidden' name='id' value='$id'>";
                echo "<button type='submit' style='padding:8px 15px; border:none; border-radius:5px; margin-right:10px; cursor:pointer;'>Like ($row[likes])</button>";
                echo "</form>";

               // Comment form
                echo "<form action='comment.php' method='post' style='margin-top:10px;'>";
                echo "<input type='hidden' name='news_id' value='$id'>";
                echo "<textarea name='comment' rows='2' placeholder='Write a comment...' style='width:100%; border-radius:5px;'></textarea><br>";
                echo "<button type='submit' style='margin-top:5px; padding:5px 15px;  border:none; border-radius:5px;'>💬 Submit Comment</button>";
                echo "</form>";

                // Fetch and show comments
                $comment_result = $conn->query
                ("SELECT c.comment_text, c.created_at, u.username
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.news_id = $id 
                ORDER BY c.created_at DESC");

        if ($comment_result && $comment_result->num_rows > 0) {
                echo "<div style='margin-top: 20px;'>";
                echo "<h4 style='margin-bottom: 10px;'>Comments:</h4>";

            while ($comment_row = $comment_result->fetch_assoc()) {

                $username = htmlspecialchars($comment_row['username']);
                $comment = nl2br(htmlspecialchars($comment_row['comment_text']));
                $created_at = date("F j, Y, g:i a", strtotime($comment_row['created_at']));

                echo "<div style='padding: 10px 0; border-top: 1px solid #ddd;'>";
                echo "<strong style='color: #333;'>$username</strong> ";
                echo "<small style='color: #999;'>($created_at)</small>";
                echo "<p style='margin: 5px 0;'>$comment</p>";
                echo "</div>";
    }

                echo "</div>";
}

// Post Delete Link
echo "<div style='margin-top: 15px;'>";
echo "<a href='delete_post.php?id=" . urlencode($id) . "' style='color: red; text-decoration: none; font-weight: bold;'>Delete This Post</a>";
echo "</div>";
        }
           } else {
               echo "<p>No news available.</p>";
            }
        ?>
    </div>
</main>
<a href="post_news.php" style="
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #007BFF;
    color: white;
    padding: 12px 20px;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
">➕ Post News</a>

<footer>
    <p>&copy; 2025 Varendra Alo News. All rights reserved.</p>
    <p>Phone: 01758803068</p>
    <a href="mailto:shaimahmedsizer@gmail.com" target="_blank">Email</a>
    <a href="https://www.linkedin.com/in/md-sizer-813a7224b/" target="_blank">LinkedIn</a>
    <a href="https://www.facebook.com/share/164KQduCQW/" target="_blank">Facebook</a>
</footer>

</body>
</html>

<?php $conn->close(); ?>
