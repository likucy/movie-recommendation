<?php
require 'conn.php';

if (!isset($_GET['id'])) {
    die("缺少电影 ID 参数");
}

$id = intval($_GET['id']);
$sql = "SELECT link FROM movies WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("找不到对应电影");
}

$row = mysqli_fetch_assoc($result);
$link = $row['link'];

if (!$link) {
    die("该电影尚未设置跳转链接");
}

header("Location: $link");
exit();
?>