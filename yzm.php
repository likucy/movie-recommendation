<?php
session_start();
// 创建验证码图像
$width = 120; // 增加宽度以适应字母
$height = 40;
$image = imagecreatetruecolor($width, $height);

// 设置背景色（浅灰色）
$bg_color = imagecolorallocate($image, 230, 230, 230);
imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

// 生成字母数字混合验证码
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
$captcha = '';
$length = 4; // 验证码长度

for ($i = 0; $i < $length; $i++) {
    $captcha .= $chars[rand(0, strlen($chars) - 1)];
}

// 存储小写的验证码（用于不区分大小写验证）
$_SESSION['captcha'] = strtolower($captcha);

// 添加干扰点（彩色点）
for ($i = 0; $i < 50; $i++) {
    $dot_color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
    imagesetpixel($image, rand(0, $width), rand(0, $height), $dot_color);
}

// 添加干扰线
for ($i = 0; $i < 3; $i++) {
    $line_color = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// 添加验证码文本（显示混合大小写）
$text_color = imagecolorallocate($image, 50, 50, 50);
// 使用 TrueType 字体以获得更好的效果（需要确保字体文件存在）
$font = 'arial.ttf'; // 替换为实际字体文件路径

// 如果字体文件不存在，使用 imagestring
if (file_exists($font)) {
    for ($i = 0; $i < $length; $i++) {
        $angle = rand(-10, 10);
        $x = 15 + $i * 30;
        $y = 30;
        imagettftext($image, 18, $angle, $x, $y, $text_color, $font, $captcha[$i]);
    }
} else {
    // 后备方案：使用默认字体
    imagestring($image, 5, 30, 12, $captcha, $text_color);
}

// 输出图像
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>