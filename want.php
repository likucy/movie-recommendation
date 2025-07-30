[file name]: want.php
[file content begin]
<?php
session_start();

// 检查用户是否登录
if (!isset($_SESSION['user_id'])) {
    header("Location: deng.html");
    exit();
}

require 'conn.php';

// 获取表单数据
$movie_name = $_POST['movie_name'];
$reason = $_POST['reason'];
$user_id = $_SESSION['user_id'];

// 检查该用户是否已经推荐过同名电影
$check_sql = "SELECT id FROM recommendations WHERE user_id = '$user_id' AND movie_name = '$movie_name'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    // 如果存在，更新推荐理由
    $row = $check_result->fetch_assoc();
    $rec_id = $row['id'];
    $update_sql = "UPDATE recommendations SET reason = '$reason' WHERE id = '$rec_id'";

    if ($conn->query($update_sql)) {
        echo "<script>alert('推荐更新成功！');window.location.href='dianying.php';</script>";
    } else {
        echo "<script>alert('推荐更新失败: " . $conn->error . "');history.back();</script>";
    }
} else {
    // 如果不存在，插入新推荐
    $insert_sql = "INSERT INTO recommendations (user_id, movie_name, reason) 
            VALUES ('$user_id', '$movie_name', '$reason')";

    if ($conn->query($insert_sql)) {
        echo "<script>alert('推荐成功！');window.location.href='dianying.php';</script>";
    } else {
        echo "<script>alert('推荐失败: " . $conn->error . "');history.back();</script>";
    }
}
?>
[file content end]