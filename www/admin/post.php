<?php
    $Mode = $_POST['m'];
    unset($_POST['m']);
    $Data = $_POST;
    
    var_dump($_FILES);
    var_dump($Data);

    $Root = realpath(dirname(__FILE__).'/../..');
    $ConfigFile = $Root.'/config.json';
    $Config = json_decode(file_get_contents($ConfigFile),true);
    $TemplateCode = $Config['u.board']['data']['template']['value'];
    $TemplateFile = $Root.'/templates/'.$TemplateCode.'/config.json';
    $Template = json_decode(file_get_contents($TemplateFile),true);
    
    $_post = function($configName,$config,$node) use($Data){
        array_map(function($code,$value) use(&$config,$node){
            if(!array_key_exists($code,$config[$node]['data'])) return;
            $config[$node]['data'][$code]['value'] = is_array($value) ? $value : trim($value);
        },array_keys($Data),array_values($Data));
        
        file_put_contents($configName,
            json_encode($config,
                JSON_PRETTY_PRINT             // форматирование пробелами
                | JSON_UNESCAPED_SLASHES      // не экранировать /
                | JSON_UNESCAPED_UNICODE      // не кодировать текст
            )
        );
    
    };
    
    if($Mode === 'm'){
        $ConfigName = $Root.'/config.json';
        $Config = json_decode(file_get_contents($ConfigName),true);
        $_post($ConfigName,$Config,'u.board');
    }
    else{
        $ConfigName = $Root.'/config.json';
        $Config = json_decode(file_get_contents($ConfigName),true);
        $TemplateCode = $Config['u.board']['data']['template']['value'];
        $TemplateName = $Root.'/templates/'.$TemplateCode.'/config.json';
        $Template = json_decode(file_get_contents($TemplateName),true);
        $_post($TemplateName,$Template,'template');
    } 
?>