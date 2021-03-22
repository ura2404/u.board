<?php

$Root = realpath(dirname(__FILE__).'/..');
$Config = json_decode(file_get_contents($Root.'/config.json'),true);

echo $Config['u.board']['data'][$argv[1]]['value'];
?>