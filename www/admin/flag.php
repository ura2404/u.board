<?php
    $Root = realpath(dirname(__FILE__).'/../..');
    $Flag = $_POST['f'];
    
    $Path = $Root.'/flag/'.$Flag;
    
    $Files = scandir($Path);
    
    if(!count($Files)) file_put_contents($Path,$Flag);
?>