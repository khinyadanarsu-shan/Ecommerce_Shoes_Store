<?php
session_start();
$code = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 6);
$_SESSION["captcha"] = $code;

header('Content-Type: image/png');
$image = imagecreatetruecolor(130, 40);
$bg = imagecolorallocate($image, 255, 255, 255);
$text = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 130, 40, $bg);
imagettftext($image, 20, 0, 10, 30, $text, __DIR__ . '/arial.ttf', $code);
imagepng($image);
imagedestroy($image);
?>