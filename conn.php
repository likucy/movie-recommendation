<?php
// 数据库配置
header("Content-type:text/html;charset=utf-8");

// 创建数据库连接
$conn = mysqli_connect("127.0.0.1","root","root","movie_db");

// 检查连接
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}
mysqli_set_charset($conn,"utf8");

