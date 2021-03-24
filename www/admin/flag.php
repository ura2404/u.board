<?php
    $Root = realpath(dirname(__FILE__).'/../..');
    $Flag = $_POST['f'];
    
    $Path = $Root.'/flag';
    
    $Files = array_filter(scandir($Path),function($file){ return !($file == '.' || $file == '..' || $file{0} == '.'); });

    if(!count($Files)) file_put_contents($Path.'/'.$Flag,$Flag);
?>