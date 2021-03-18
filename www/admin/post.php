<?php
    $Mode = $_POST['m'];
    $Data = $_POST['d'];

    $Root = realpath(dirname(__FILE__).'/../..');
    $ConfigFile = $Root.'/config.json';
    $Config = json_decode(file_get_contents($ConfigFile),true);
    $TemplateCode = $Config['u.board']['data']['template']['value'];
    $TemplateFile = $Root.'/templates/'.$TemplateCode.'/config.json';
    $Template = json_decode(file_get_contents($TemplateFile),true);
    
    var_dump($TemplateCode);
    
    $_main = function() use($Data,$ConfigFile,$Config){
        array_map(function($val) use(&$Config){
            $code = $val['name'];
            $value = $val['value'];
            if(!array_key_exists($code,$Config['u.board']['data'])) return;
            $Config['u.board']['data'][$code]['value'] = trim($value);
        },$Data);
        
        file_put_contents($ConfigFile,
            json_encode($Config,
                JSON_PRETTY_PRINT             // форматирование пробелами
                | JSON_UNESCAPED_SLASHES      // не экранировать /
                | JSON_UNESCAPED_UNICODE      // не кодировать текст
            )
        );
    };
    
    $_template = function() use($Data,$TemplateFile,$Template){
        array_map(function($val) use(&$Template){
            $code = $val['name'];
            $value = $val['value'];
            if(!array_key_exists($code,$Template['template']['data'])) return;
            $Template['template']['data'][$code]['value'] = trim($value);
        },$Data);
        
        file_put_contents($TemplateFile,
            json_encode($Template,
                JSON_PRETTY_PRINT             // форматирование пробелами
                | JSON_UNESCAPED_SLASHES      // не экранировать /
                | JSON_UNESCAPED_UNICODE      // не кодировать текст
            )
        );
    };
    
    if($Mode === 'm') $_main(); else $_template();
?>