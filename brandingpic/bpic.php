<?php 
header('Content-type: image/jpeg'); 

// Create the image 
//$im = imagecreatetruecolor(1200, 600); 
$im = imagecreatefromjpeg('branding.jpg');
// Create some colors 
$white = imagecolorallocate($im, 255, 255, 255); 
$grey = imagecolorallocate($im, 128, 128, 128); 
$black = imagecolorallocate($im, 0, 0, 0);

//imagefilledrectangle($im, 593, 608, 715, 732, $white); 
// The text to draw 

// Replace path by your own font path 
$font = 'simkai.ttf'; 
// Add some shadow to the text 
$text=$_GET['text'];//要生成的文字水印的文字

imagettftext($im, 14, 0, 300, 20, $white, $font, $text);
$pic = imagecreatefromjpeg('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$_GET['ticket']);
$qrcode=imagecreate (190, 190);
imagecopyresampled($qrcode,$pic,0,0,0,0,190,190,430,430);
imagecopymerge($im,$qrcode,160,362,0,0,190,190,100); 
//imagettftext($im, 12, 0, 51, 101, $grey, $font, $text); 
// Add the text 
//imagettftext($im, 12, 0, 50, 100, $black, $font, $text); 
// Using imagepng() results in clearer text compared with imagejpeg() 
imagejpeg($im);  
imagedestroy($pic);

imagedestroy($im); 

?> 