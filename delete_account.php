<?php
session_start();

// 验证用户登录状态
if (!isset($_SESSION['user_id'])) {
    header("Location: deng.html");
    exit();
}

require 'conn.php';

$user_id = $_SESSION['user_id'];

// 删除用户的推荐记录
$delete_recs = "DELETE FROM recommendations WHERE user_id = '$user_id'";
$conn->query($delete_recs);

// 删除用户账号
$delete_user = "DELETE FROM users WHERE id = '$user_id'";
if ($conn->query($delete_user)) {
    // 清除会话并重定向
    session_unset();
    session_destroy();
    echo "<script>alert('账号已成功注销！');window.location.href='deng.html';</script>";
} else {
    echo "<script>alert('账号注销失败: " . $conn->error . "');history.back();</script>";
}
?>
[file content end]
