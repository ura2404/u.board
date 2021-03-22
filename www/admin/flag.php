<?php
    $Root = realpath(dirname(__FILE__).'/../..');
    $Flag = $_POST['f'];
    
    $Path = $Root.'/flag';
    
    $Files = scandir($Path);
    
    if(count($Files)==2) file_put_contents($Path.'/'.$Flag,$Flag);
?>