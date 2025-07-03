<?php
include 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM news WHERE status = 'pending' ORDER BY date_published DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Approve Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(239, 239, 239);
            color: #333;
        }

        header {
            background-color: #1a1a1a;
            color: white;
            padding: 20px 0;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        header h1 {
            font-size: 28px;
            letter-spacing: 1px;
        }

        nav {
            background-color:rgb(240, 93, 25);
            text-align: center;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav a:hover {
            color:rgb(192, 249, 34);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .post-card {
            background-color:rgb(255, 255, 255);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            padding: 25px;
            transition: transform 0.2s ease;
        }

        .post-card:hover {
            transform: translateY(-5px);
        }

        .post-card h2 {
            margin-bottom: 10px;
            color: #e60000;
        }

        .post-card p {
            line-height: 1.6;
        }

        .buttons {
            margin-top: 20px;
        }

        .buttons a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            margin-right: 15px;
            font-weight: bold;
            display: inline-block;
        }

        .approve {
            background-color: #28a745;
            color: white;
        }

        .approve:hover {
            background-color: #218838;
        }

        .delete {
            background-color: #dc3545;
            color: white;
        }

        .delete:hover {
            background-color: #c82333;
        }

        .no-posts {
            text-align: center;
            font-size: 20px;
            color: #555;
            margin-top: 80px;
        }

        .home-link {
            display: inline-block;
            margin: 40px auto;
            background-color: #007BFF;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 3px 6px rgba(0,0,0,0.2);
        }

        .home-link:hover {
            background-color: #0056b3;
        }

        footer {
            background:rgb(0, 0, 0);
            color: #ccc;
            text-align: center;
            padding: 20px 0;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            nav a {
                margin: 0 10px;
                font-size: 14px;
            }

            .buttons a {
                display: block;
                margin-bottom: 10px;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<header>
    <h1> Admin Dashboard - Pending Posts</h1>
</header>

<nav>
    <a href="index.php"> Home</a>
    <a href="login.php">Logout</a>

</nav>

<div class="container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $title = htmlspecialchars($row['title']);
            $content = htmlspecialchars(substr($row['content'], 0, 500));
            $date = date('F j, Y', strtotime($row['date_published']));

            echo "<div class='post-card'>";
            echo "<h2>$title</h2>";
            echo "<p><strong>Published:</strong> $date</p>";
            echo "<p>$content...</p>";
            echo "<div class='buttons'>
                    <a class='approve' href='approve_post.php?id=$id'>Approve</a>
                    <a class='delete' href='delet_post.php?id=$id' onclick=\"return confirm('Are you sure you want to delete this post?');\"> Delete</a>
                  </div>";
            echo "</div>";
        }
    } else {
        echo "<p class='no-posts'>There are no pending posts to approve.</p>";
    }
    ?>

    <a href="index.php" class="home-link">← Back to Home</a>
</div>

</body>
</html>

<?php $conn->close(); ?>
