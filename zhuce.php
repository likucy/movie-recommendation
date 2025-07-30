<?php
session_start();
require 'conn.php';

// 获取表单数据
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$captcha = strtolower($_POST['captcha']); // 转换为小写

// 验证验证码（不区分大小写）
if ($captcha != strtolower($_SESSION['captcha'])) {
    die("验证码错误");
}

// 验证密码匹配
if ($password !== $confirm_password) {
    die("两次密码不一致");
}

// 检查用户名是否已存在
$check_sql = "SELECT id FROM users WHERE username = '$username'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    die("用户名已存在");
}

// 哈希密码
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 插入新用户
$insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
if ($conn->query($insert_sql)) {
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['username'] = $username;
    header("Location: dianying.php");
    exit();
} else {
    die("注册失败: " . $conn->error);
}
require 'deng.html';
?>