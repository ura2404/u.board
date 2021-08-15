<?php
$Config = '/boot/u.board/config.json';
if(!file_exists($Config)) die('Config not found');

$Config = json_decode(file_get_contents($Config),true);
?>