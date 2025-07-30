<?php
session_start();
require 'conn.php';

// 获取表单数据
$username = $_POST['username'];
$password = $_POST['password'];
$captcha = strtolower($_POST['captcha']); // 转换为小写

// 验证验证码（不区分大小写）
if ($captcha != strtolower($_SESSION['captcha'])) {
    die("验证码错误");
}

// 查询用户
$sql = "SELECT id, password FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $username;
        header("Location: dianying.php");
        exit();
    } else {
        die("密码错误");
    }
} else {
    die("用户不存在");
}
?>