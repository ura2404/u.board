<?php
require_once(realpath(dirname(__FILE__).'/../common.php'));

$GPIO = $Config['gpio'];
$Value = isset($_GET[1]) ? 1 : 0;

system('echo '.$Value.' > /sys/class/gpio/gpio'.$GPIO.'/value');

/*
$fp = fopen('/sys/class/gpio/gpio'.$GPIO.'/value', 'wt');
var_dump($fp);

if($fp) $test = fwrite($fp, "1");
var_dump($test);
*/
?>