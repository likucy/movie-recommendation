<?php
// index.php 或你展示电影的页面
require 'conn.php';

// 获取所有电影数据
$sql = "SELECT * FROM movies";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>电影推荐系统</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div class="container">
    <header>
        <h1><i class="fas fa-film"></i> 在线电影推荐</h1>
        <p class="tagline">点击封面跳转豆瓣 / TMDB / 哔哩哔哩等电影链接</p>
    </header>

    <div class="movie-grid">
        <?php while ($movie = mysqli_fetch_assoc($result)): ?>
            <div class="movie-card">
                <a href="movie_detail.php?id=<?= $movie['id'] ?>" target="_blank">
                    <img src="image/<?php echo str_replace(' ', '_', htmlspecialchars($movie['title'])); ?>.jpg"
                         alt="<?= htmlspecialchars($movie['title']) ?>" class="movie-poster">
                </a>
                <div class="movie-info">
                    <div class="movie-title" style="color: inherit; text-decoration: none;">
                        <?= htmlspecialchars($movie['title']) ?>
                    </div>
                    <div class="movie-details">
                        <span><?= $movie['type'] ?> / <?= $movie['area'] ?></span>
                        <div class="movie-rating">
                            <span class="stars">★</span> <?= $movie['rating'] ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <footer>
        <p>点击电影即可跳转至在线观看平台</p>
    </footer>
</div>
</body>
</html>