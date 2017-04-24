<?php
$file=array("php /var/www/html/getnow/btc.php","php /var/www/html/getnow/EURUSD.php","php /var/www/html/getnow/GBPUSD.php","php /var/www/html/getnow/USDJPY.php","php /var/www/html/getnow/USOil.php","php /var/www/html/getnow/XAGUSD.php","php /var/www/html/getnow/XAUUSD.php");
foreach($file as $f){
//$shell .=$f.";";
popen($f,"r");
}
//echo $shell;
?>