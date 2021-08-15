<?php
    $Mode = $_POST['m'];
    unset($_POST['m']);
    $Data = $_POST;

    file_put_contents('/var/tmp/0000','qaz');
    file_put_contents('/var/tmp/111',print_r($_POST,1));
    file_put_contents('/var/tmp/222',print_r($_FILES,1));

    $Root = realpath(dirname(__FILE__).'/../..');

    $_post = function($data,$configName,$config,$node){
        
        array_map(function($code,$value) use($data,$node,&$config){
            if(isset($data[$code])) $config[$node]['data'][$code]['value'] = $data[$code];
            else $config[$node]['data'][$code]['value'] = null;
        },array_keys($config[$node]['data']),array_values($config[$node]['data']));
        
        file_put_contents($configName,
            json_encode($config,
                JSON_PRETTY_PRINT             // форматирование пробелами
                | JSON_UNESCAPED_SLASHES      // не экранировать /
                | JSON_UNESCAPED_UNICODE      // не кодировать текст
            )
        );
    };
    
    $_files = function() use($Root){
        $_prepare = function($tag){
            return array_map(function($name,$tmp){
                return [ 'name' => $name, 'tmp' => $tmp ];
            },$_FILES[$tag]['name'],$_FILES[$tag]['tmp_name']);
        };
        
        $_put = function($tag,$folder) use($_prepare){
            $Ret = [ $tag =>[] ];
            $Files = $_prepare($tag);
            
            foreach($Files as $file){
                $Src = $file['tmp'];
                $Dst = $folder.'/'.$file['name'];
                if(move_uploaded_file($Src, $Dst)) $Ret[$tag][] = $file['name'];
            }
            return $Ret;
        };
        
        $Files = [];
        $Files = array_merge_recursive($Files,$_put('pics',$Root.'/www/data/pics'));
        $Files = array_merge_recursive($Files,$_put('videos',$Root.'/www/data/videos'));
        
        return $Files;
    };
    
    $_purge = function($tag,$data) use($Root){
        $ConfigName = $Root.'/config.json';
        $Config = json_decode(file_get_contents($ConfigName),true);
        $TemplateCode = $Config['u.board']['data']['template']['value'];
        $TemplateName = $Root.'/templates/'.$TemplateCode.'/config.json';
        $Template = json_decode(file_get_contents($TemplateName),true);
        
        $Path = $Root.'/www/data/'.$tag;
        $Files = array_filter(scandir($Path),function($value){
            return $value == '.' || $value == '..' || $value{0} == '.' ? false : true;
        });
        
        array_map(function($file) use($tag,$Template,$Files,$Root,$Path){
            if(!array_key_exists($file,$Template['template']['data'][$tag]['value'])) unlink($Path.'/'.$file);
        },$Files);
    };
    
    if($Mode === 'm'){
        $ConfigName = $Root.'/config.json';
        $Config = json_decode(file_get_contents($ConfigName),true);
        $_post($Data,$ConfigName,$Config,'u.board');
    }
    else{
        $ConfigName = $Root.'/config.json';
        $Config = json_decode(file_get_contents($ConfigName),true);
        $TemplateCode = $Config['u.board']['data']['template']['value'];
        $TemplateName = $Root.'/templates/'.$TemplateCode.'/config.json';
        $Template = json_decode(file_get_contents($TemplateName),true);
        
        $Files = $_files();
        
        if(isset($Files['pics']) && count($Files['pics'])) array_map(function($file) use(&$Data){
            $Data['pics'][$file] = 1;
        },$Files['pics']);
        
        if(isset($Files['videos']) && count($Files['videos'])) array_map(function($file) use(&$Data){
            $Data['videos'][$file] = 1;
        },$Files['videos']);
        
        
        $_post($Data,$TemplateName,$Template,'template');
        $_purge('pics',$Data);
        $_purge('videos',$Data);
    } 
    
    header('Location: '.$_SERVER['HTTP_REFERER']);
?>