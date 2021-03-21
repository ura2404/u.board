<?php
    $Mode = $_POST['m'];
    unset($_POST['m']);
    $Data = $_POST;
    
    //var_dump('=============================================================');
    //echo '<pre>'.print_r($_FILES,1).'</pre>';
    //var_dump('==========================');
    //echo '<pre>'.print_r($Data,1).'</pre>';
    //var_dump('=============================================================');
    //die();

    $Root = realpath(dirname(__FILE__).'/../..');
    /*
    $ConfigFile = $Root.'/config.json';
    $Config = json_decode(file_get_contents($ConfigFile),true);
    $TemplateCode = $Config['u.board']['data']['template']['value'];
    $TemplateFile = $Root.'/templates/'.$TemplateCode.'/config.json';
    $Template = json_decode(file_get_contents($TemplateFile),true);
    */
    
    $_post = function($data,$configName,$config,$node){
        //echo "\n\n--- data---\n";
        //echo '<pre>'.print_r($data,1).'</pre>';
        //echo "--- data---\n";
        
        array_map(function($code,$value) use($data,$node,&$config){
            if(isset($data[$code])) $config[$node]['data'][$code]['value'] = $data[$code];
            else $config[$node]['data'][$code]['value'] = null;
        },array_keys($config[$node]['data']),array_values($config[$node]['data']));
        
        /*
        array_map(function($code,$value) use(&$config,$node){
            if(!array_key_exists($code,$config[$node]['data'])) unset($config[$node]['data'][$code]);
            $config[$node]['data'][$code]['value'] = is_array($value) ? $value : trim($value);
        },array_keys($data),array_values($data));
        */
        
        //echo "\n\n--- config---\n";
        //echo '<pre>'.print_r($config,1).'</pre>';
        //echo "--- config---\n";
        //return;
        
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
            //var_dump('*************************************************************');
            //var_dump($tag);
            //var_dump($_FILES[$tag]);
            //var_dump('*************************************************************');
            
            return array_map(function($name,$tmp){
                return [ 'name' => $name, 'tmp' => $tmp ];
            },$_FILES[$tag]['name'],$_FILES[$tag]['tmp_name']);
        };
        
        $_put = function($tag,$folder) use($_prepare){
            $Ret = [ $tag =>[] ];
            $Files = $_prepare($tag);
            //var_dump('-------------------------------------------------------------');
            //var_dump($Files);
            //var_dump('-------------------------------------------------------------');
            
            foreach($Files as $file){
                $Src = $file['tmp'];
                $Dst = $folder.'/'.$file['name'];
                //var_dump($Src);
                //var_dump($Dst);
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
        $Path = $Root.'/www/data/'.$tag;
        $Files = array_filter(scandir($Path),function($value){
            return $value == '.' || $value == '..' ? false : true;
        });
        /*
        array_map(function($file) use($Path,$Root,$tag,$data){
            if(!isset($data[$tag]) || !array_key_exists($file,$data[$tag]['value'])) unlink($Path.'/'.$file);
            
        },$Files);
        */
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
        //var_dump($Files);
        
        if(isset($Files['pics']) && count($Files['pics'])) array_map(function($file) use(&$Data){
            $Data['pics'][$file] = 1;
        },$Files['pics']);
        
        if(isset($Files['videos']) && count($Files['videos'])) array_map(function($file) use(&$Data){
            $Data['videos'][$file] = 1;
        },$Files['videos']);
        
        //echo "------- Data -----\n";
        //echo '<pre>'.print_r($Data,1).'</pre>';
        //echo "------- Data -----\n";
        
        $_post($Data,$TemplateName,$Template,'template');
        $_purge('pics',$Data);
        $_purge('videos',$Data);
    } 
    
    header('Location: '.$_SERVER['HTTP_REFERER']);
?>