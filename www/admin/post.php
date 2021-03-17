<?php
    $Root = realpath(dirname(__FILE__).'/../..');
    $ConfigFileName = $Root.'/config.json';
    $Config = json_decode(file_get_contents($ConfigFileName),true);

    array_map(function($code,$value) use(&$Config){
        if(!array_key_exists($code,$Config['u.board']['data'])) return;
        $Config['u.board']['data'][$code]['value'] = trim($value);
    },array_keys($_POST),array_values($_POST));
    
    var_dump($Config);
    
    file_put_contents($ConfigFileName,
        json_encode($Config,
            JSON_PRETTY_PRINT             // форматирование пробелами
            | JSON_UNESCAPED_SLASHES      // не экранировать /
            | JSON_UNESCAPED_UNICODE      // не кодировать текст
        )
    );
?>