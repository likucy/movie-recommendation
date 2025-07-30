<?php
// 电影展示页面
session_start(); // 启动会话（检查用户登录状态）
// 未登录用户重定向到首页（index.php）
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 包含数据库连接文件
require 'conn.php';

// 从数据库获取所有电影数据
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
$movies = array();
// 将查询结果转为数组
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $movies[] = $row; // 逐行添加到数组
    }
} else {
    $movies = []; // 无数据时设为空数组
}

// 从URL参数获取筛选条件
$selectedType = $_GET['type'] ?? '';   // 电影类型
$selectedArea = $_GET['area'] ?? '';   // 地区
$selectedYear = $_GET['year'] ?? '';   // 年份
$highRating = $_GET['rating'] ?? '';   // 是否按评分排序

// 初始化为所有电影
$filteredMovies = $movies;

// 按类型筛选（使用array_filter函数）
if (!empty($selectedType)) {
    $filteredMovies = array_filter($filteredMovies, function($movie) use ($selectedType) {
        return $movie['type'] == $selectedType; // 匹配所选类型
    });
}

// 按地区筛选（同上原理）
if (!empty($selectedArea)) {
    $filteredMovies = array_filter($filteredMovies, function($movie) use ($selectedArea) {
        return $movie['area'] == $selectedArea; // 匹配所选地区
    });
}

// 按年份筛选
if (!empty($selectedYear)) {
    $filteredMovies = array_filter($filteredMovies, function($movie) use ($selectedYear) {
        return $movie['year'] == $selectedYear; // 检查电影年份是否匹配
    });
}

// 按评分降序排序
if ($highRating == 'high') {
    usort($filteredMovies, function($a, $b) {
        return $b['rating'] <=> $a['rating']; // 降序排列
    });
}

// 获取所有电影的类型/地区/年份（用于生成筛选选项）
$allTypes = array_unique(array_column($movies, 'type')); // array_column提取列值
$allAreas = array_unique(array_column($movies, 'area')); // array_unique去重
$allYears = array_unique(array_column($movies, 'year'));
rsort($allYears); // 年份从新到旧排序
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <!-- 页面基础设置 -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>电影推荐系统</title>
    <!-- 引入字体图标和样式 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="user-info">
    <span>欢迎, <?php echo $_SESSION['username']; ?>!</span>
    <div class="user-actions">  <!-- 添加这个包裹容器 -->
        <a href="logout.php"> <!-- 退出链接 -->
            <i class="fas fa-sign-out-alt"></i> 退出
        </a>
        <a href="#" onclick="confirmDelete()" class="delete-account">  <!-- 添加注销账号链接 -->
            <i class="fas fa-user-times"></i> 注销账号
        </a>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm("确定要永久注销您的账号吗？此操作将删除所有数据且不可恢复！")) {
            window.location.href = "delete_account.php";
        }
    }
</script>

<div class="container">
    <!-- 页面标题 -->
    <header>
        <h1><i class="fas fa-film"></i> 电影推荐系统</h1>
        <p class="tagline">发现您喜欢的电影</p>
    </header>

    <!-- 筛选区域 -->
    <div class="filters">
        <!-- 类型筛选 -->
        <div class="filter-row">
            <div class="filter-title">电影类型</div>
            <div class="filter-options">
                <?php foreach ($allTypes as $type): ?>
                    <!-- 动态生成类型筛选按钮 -->
                    <a href="dianying.php?type=<?= $type ?>&area=<?= $selectedArea ?>&year=<?= $selectedYear ?>"
                       class="filter-btn <?= ($selectedType == $type) ? 'active' : '' ?>">
                        <?= $type ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 地区筛选 -->
        <div class="filter-row">
            <div class="filter-title">拍摄地区</div>
            <div class="filter-options">
                <?php foreach ($allAreas as $area): ?>
                    <!-- 动态生成地区筛选按钮 -->
                    <a href="dianying.php?type=<?= $selectedType ?>&area=<?= $area ?>&year=<?= $selectedYear ?>"
                       class="filter-btn <?= ($selectedArea == $area) ? 'active' : '' ?>">
                        <?= $area ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 年份筛选 -->
        <div class="filter-row">
            <div class="filter-title">上映年份</div>
            <div class="filter-options">
                <?php foreach ($allYears as $year): ?>
                    <!-- 动态生成年份筛选按钮 -->
                    <a href="dianying.php?type=<?= $selectedType ?>&area=<?= $selectedArea ?>&year=<?= $year ?>"
                       class="filter-btn <?= ($selectedYear == $year) ? 'active' : '' ?>">
                        <?= $year ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 评分排序 -->
        <div class="filter-row">
            <div class="filter-title">排序</div>
            <div class="filter-options">
                <!-- 高分推荐按钮 -->
                <a href="dianying.php?type=<?= $selectedType ?>&area=<?= $selectedArea ?>&year=<?= $selectedYear ?>&rating=high"
                   class="rating-btn">
                    <i class="fas fa-star"></i> 高分推荐
                </a>
            </div>
        </div>

        <!-- 当前筛选条件展示 -->
        <?php if (!empty($selectedType) || !empty($selectedArea) || !empty($selectedYear) || !empty($highRating)): ?>
            <div class="active-filters">
                <?php if (!empty($selectedType)): ?>
                    <!-- 类型筛选标签 -->
                    <div class="filter-tag">
                        <span>类型: <?= $selectedType ?></span>
                        <!-- 清除类型筛选的链接 -->
                        <a href="dianying.php?type=&area=<?= $selectedArea ?>&year=<?= $selectedYear ?>&rating=<?= $highRating ?>"
                           class="close"><i class="fas fa-times"></i></a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($selectedArea)): ?>
                    <!-- 地区筛选标签 -->
                    <div class="filter-tag">
                        <span>地区: <?= $selectedArea ?></span>
                        <a href="dianying.php?type=<?= $selectedType ?>&area=&year=<?= $selectedYear ?>&rating=<?= $highRating ?>"
                           class="close"><i class="fas fa-times"></i></a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($selectedYear)): ?>
                    <!-- 年份筛选标签 -->
                    <div class="filter-tag">
                        <span>年份: <?= $selectedYear ?></span>
                        <a href="dianying.php?type=<?= $selectedType ?>&area=<?= $selectedArea ?>&year=&rating=<?= $highRating ?>"
                           class="close"><i class="fas fa-times"></i></a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($highRating)): ?>
                    <!-- 评分排序标签 -->
                    <div class="filter-tag">
                        <span>按评分排序</span>
                        <a href="dianying.php?type=<?= $selectedType ?>&area=<?= $selectedArea ?>&year=<?= $selectedYear ?>&rating="
                           class="close"><i class="fas fa-times"></i></a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- 显示搜索结果数量 -->
    <div class="results-count">
        找到 <span class="count-number"><?= count($filteredMovies) ?></span> 部电影
    </div>

    <!-- 电影展示网格 -->
    <div class="movie-grid">
        <?php if (count($filteredMovies) > 0) : ?>
            <?php foreach ($filteredMovies as $movie) : ?>
                <!-- 单个电影卡片 -->
                <div class="movie-card">
                    <!-- 电影海报 -->
                    <a href="movie_detail.php?id=<?= $movie['id'] ?>" target="_blank">
                        <img src="image/<?php echo htmlspecialchars($movie['poster']); ?>"
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             class="movie-poster">
                    </a>


                    <div class="movie-info">
                        <!-- 电影标题 -->
                        <div class="movie-title" style="color: inherit; text-decoration: none;">
                            <?php echo htmlspecialchars($movie['title']); ?>
                        </div>

                        <div class="movie-details">
                            <span><?php echo htmlspecialchars($movie['type']); ?></span>
                            <span><?php echo htmlspecialchars($movie['year']); ?></span>
                        </div>

                        <div class="movie-details">
                            <span><?php echo htmlspecialchars($movie['area']); ?></span>

                            <!-- 电影评分展示 -->
                            <div class="movie-rating">
                            <span class="stars">
                                <?php
                                $rating = floatval($movie['rating']);
                                $fullStars = floor($rating);
                                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);

                                // 满星
                                for ($i = 0; $i < $fullStars; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }

                                // 半星
                                if ($hasHalfStar) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                }

                                // 空星
                                for ($i = 0; $i < $emptyStars; $i++) {
                                    echo '<i class="far fa-star"></i>';
                                }
                                ?>
                            </span>
                                <?php echo htmlspecialchars($rating); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <!-- 无结果提示 -->
            <div class="no-results">
                <i class="fas fa-film fa-3x"></i>
                <h3>没有找到符合条件的电影</h3>
                <p>请尝试其他筛选条件</p>
                <p class="suggestion">或者告诉我们您想看的电影，我们会继续努力</p>
                <a href="want.html" class="wish-btn">
                    <i class="fas fa-plus-circle"></i> 推荐电影
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- 页脚 -->
    <footer>
        <p>© 李凯航 电影推荐系统 | 为您精选优质电影</p>
    </footer>
</div>
</body>
</html>