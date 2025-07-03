<?php
include 'db.php';

// Fetch all categories
$categories_result = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>News by Category - Varendra Alo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #b71c1c;
        }

        .category-section {
            margin-bottom: 40px;
        }

        .category-title {
            font-size: 24px;
            color: #d84315;
            border-bottom: 2px solid #d84315;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .news-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .news-item h3 {
            margin: 0;
            color: #333;
        }

        .news-item p {
            color: #555;
            margin-top: 8px;
        }

        .back-link {
            text-align: center;
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>📰 All News by Category</h1>

<?php while ($category = $categories_result->fetch_assoc()): ?>
    <div class="category-section">
        <div class="category-title"><?= htmlspecialchars($category['name']) ?></div>

        <?php
        $cat_id = $category['id'];
        $posts_result = $conn->query("SELECT * FROM news WHERE category_id = $cat_id AND status = 'approved' ORDER BY date_published DESC");

        if ($posts_result && $posts_result->num_rows > 0):
            while ($news = $posts_result->fetch_assoc()):
        ?>
            <div class="news-item">
                <h3><?= htmlspecialchars($news['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars(substr($news['content'], 0, 250))) ?>...</p>
            </div>
        <?php endwhile; else: ?>
            <p>No approved news in this category yet.</p>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

<div class="back-link">
    <a href="index.php">← Back to Home</a>
</div>

<?php $conn->close(); ?>
</body>
</html>
