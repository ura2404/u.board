<?php
    $Root = dirname(__FILE__);
    $Config = json_decode(file_get_contents($Root.'/config.json'),true)['u.board'];

    header('Location: t/'.$Config['template']);
?>