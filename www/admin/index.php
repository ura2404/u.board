<?php
    $Root = realpath(dirname(__FILE__).'/../..');
    $Config = json_decode(file_get_contents($Root.'/config.json'),true)['u.board'];
    $TemplateCode = json_decode(file_get_contents($Root.'/config.json'),true)['u.board']['data']['template']['value'];
    $Template = json_decode(file_get_contents($Root.'/templates/'.$TemplateCode.'/config.json'),true)['template'];
    //var_dump($Config);die();
    
    $Home = 'http://'. $_SERVER['SERVER_ADDR'] . '/u.board/admin';
    
    /*
    //var_dump($Template);
    //var_dump($Root.'/templates/'.$Template.'index.php');
    
    chdir($Root.'/www');
    symlink($Root.'/templates/'.$Template.'/index.php','index.php');
    symlink($Root.'/templates/'.$Template.'/data','data');
    symlink($Root.'/templates/'.$Template.'/tpl','tpl');
    */

    $_form = function($mode,$config,$html=[]){
        $_color = function($code,$data){
            echo '<input class="cm-edit h-10" type="color" name="' .$code. '" value="' .$data['value']. '"/>';
        };
        
        $_integer = function($code,$data){
            echo '<input class="cm-edit h-8 px-1" type="text" name="' .$code. '" value="' .$data['value']. '"/>';
        };
        
        $_text = function($code,$data){
            echo '<input class="cm-edit h-8 px-1" type="text" name="' .$code. '" value="' .$data['value']. '"/>';
        };
        
        $_combo = function($code,$data) use($html){
            echo '<div class="flex">';
            
            echo '<select name="' .$code. '" class="cm-edit cursor-pointer">';
            if(isset($html[$code])) echo $html[$code];
            echo '</select>';
            
            if($code === 'template') echo '<i class="cm-tpl-edit ml-2 my-auto fas fa-cog text-gray-700 cursor-pointer"></i>';
            echo '</div>';
        };
        
        $_pics = function($code,$data){
            echo '<div class="cm-pics col-span-2 mt-5 flex flex-wrap __justify-around justify-center">';
            
            if(is_array($data['value'])) array_map(function($pic,$status){
                echo '<div class="cm-pic bg-gray-50 my-1 mx-1 flex flex-col">';
                
                echo '  <div class="h-32 w-32"><img class="m-auto mt-0 max-w-full max-h-full __flex-grow" src="../data/pics/' .$pic. '"/></div>';
                echo '  <input type="hidden" name="pics[' .$pic. ']" value="' .$status. '"/>';
                
                echo '  <div class="flex justify-between">';
                echo '    <i class="cm-on ' .($status ? null : 'disable '). 'fas fa-toggle-off text-green-500 cursor-pointer"></i>';
                echo '    <i class="cm-del far fa-trash-alt text-gray-500 cursor-pointer"></i>';
                echo '  </div>';
                
                echo '</div>';
            },array_keys($data['value']),array_values($data['value']));
            
            // шаблон для новой картинки
            /*
            echo '<div class="cm-pic cm-template bg-gray-50 my-1 mx-1 flex flex-col">';
            
            echo '  <div class="h-32 w-32"><img class="m-auto mt-0 max-w-full max-h-full" _src="../data/pics/"/></div>';
            
            echo '  <div class="flex justify-between">';
            echo '    <div class="cm-size text-sm"></div>';
            echo '      <i class="cm-del far fa-trash-alt text-gray-500 cursor-pointer"></i>';
            echo '    </div>';
            echo '  </div>';
            
            
            echo '  <div class="cm-add h-32 w-32 __bg-gray-50 my-1 mx-1 flex cursor-pointer">';
            echo '    <i class="fas fa-3x fa-plus m-auto text-gray-400"></i>';
            echo '  </div>';
            */
            // шаблон
            
            //echo '  <input class="cm-files" type="file" style="display:none" accept="image/*" multiple onchange="handleFiles(this.files)"/>';
            echo '  <div class="px-3 py-10">';
            echo '    <input name="pics[]" class="cm-edit" type="file" accept="image/*" multiple="multiple"/>';
            echo '  </div>';
            
            echo '</div>';
        };

        $_videos = function($code,$data){
            echo '<div class="cm-videos col-span-2 mt-5 flex flex-wrap __justify-around justify-center">';
            
            if(is_array($data['value'])) array_map(function($video,$status){
                echo '<div class="cm-video bg-gray-50 my-1 mx-1 flex flex-col justify-between">';
                echo '<div class="h-32 w-40">';
                echo '<video class="__flex-grow" controls __autoplay="true" _loop="true" __muted="muted"><source src="../data/videos/' .$video.'" type="video/mp4" /></video>';                
                echo '</div>';
                echo '<input type="hidden" name="videos[' .$video. ']" value="' .$status. '"/>';
                
                echo '<div class="flex justify-between">';
                echo '<i class="cm-on ' .($status ? null : 'disable '). 'fas fa-toggle-off text-green-500 cursor-pointer"></i>';
                echo '<i class="cm-del far fa-trash-alt text-gray-500 cursor-pointer"></i>';
                echo '</div>';
                
                echo '</div>';
            },array_keys($data['value']),array_values($data['value']));
            
            /*
            echo '<div class="cm-add h-32 w-32 __bg-gray-50 my-1 mx-1 flex">';
            echo '<i class="fas fa-3x fa-plus m-auto text-gray-400"></i>';
            echo '</div>';
            */
            
            echo '  <div class="px-3 py-10">';
            echo '    <input name="videos[]" class="cm-edit" type="file" accept="video/*" multiple="multiple"/>';
            echo '  </div>';

            echo '</div>';
        };
        
        $_element = function($code,$data) use($_color,$_integer,$_text,$_combo){
            echo '<div class="pl-3">' .$data['name']. '</div>';
            if($data['type'] === 'color') $_color($code,$data);
            elseif($data['type'] === 'integer') $_integer($code,$data);
            elseif($data['type'] === 'text') $_text($code,$data);
            elseif($data['type'] === 'combo') $_combo($code,$data);
        };
        
        // --- --- --- ---
        echo '<form class="cm-form grid grid-cols-2 gap-1.5" method="post" enctype="multipart/form-data" action="post.php">';
        echo '<input type="hidden" name="m" value="' .$mode. '"/>';
        array_map(function($code,$data) use($_element,$_pics,$_videos){
            if($code{0} === '_') return;
            if($data['type'] === 'separator'){
                echo '<div class="col-span-2 h-4"></div>';
                echo '<div class="col-span-2 bg-gray-400 text-white px-3">' .$data['value']. '</div>';
            }
            elseif($code === 'pics') $_pics($code,$data);
            elseif($code === 'videos') $_videos($code,$data);
            else $_element($code,$data);
        },array_keys($config['data']),array_values($config['data']));
        echo '<form>';
    };

    $_main = function() use($Root,$Config,$TemplateCode,$_form){
        $_templates = function() use($Root,$TemplateCode){
            $TemplateCodes = array_filter(scandir($Root.'/templates/'),function($value){
                return $value == '.' || $value == '..' ? false : true;
            });
            $TemplateNames = array_map(function($code) use($Root){
                $Path = $Root.'/templates/'.$code;
                $Config = json_decode(file_get_contents($Path.'/config.json'),true)['template'];
                return $Config['name'];
            },$TemplateCodes);
            
            $Templates = array_combine($TemplateCodes,$TemplateNames);
            
            $Arr = array_map(function($code,$name) use($TemplateCode){
                return '<option value="' .$code. '"' .($TemplateCode === $code ? 'selected="selected"' : null). '>' .$name. '</option>';
            },array_keys($Templates),array_values($Templates));
            
            return implode('',$Arr);
        };
        
        $_rotate = function() use($Config){
            $Arr =  [
                0 => 0,
                1 => 90,
                2 => 180,
                3 => 270
            ];
            
            $Rotate = $Config['data']['rotate']['value'];
            
            return implode('',array_map(function($key,$value) use($Rotate){
                return '<option value="' .$key. '"' .($key == $Rotate ? 'selected="selected"' : null). '>' .$value. '</option>';
            },array_keys($Arr),array_values($Arr)));
        };
        
        
        $_form('m',$Config,[
            'template' => $_templates(),
            'rotate' => $_rotate(),
        ]);
    };
    
    $_template = function() use($Template,$_form){
        echo '<div class="grid grid-cols-2 gap-1.5 auto-rows-max mb-2 bg-blue-200 _text-white">';
        echo '<div class="px-3 col-span-2">Шаблон: <span class="underline">' .$Template['name']. '</span></div>';
        echo '<div class="col-span-2 bg-blue-200 px-3">'.$Template['descriptor']. '</div>';
        echo '</div>';
        
        $_form('t',$Template);
    };
?>
<html>
    <head>
        <title>u.board admin</title>
        <link rel="icon" href="../res/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="../res/tailwind/tailwind.min.css"/>
        <link rel="stylesheet" type="text/css" href="../res/fontawesome.com/5.15.2/css/all.css"/>
        <link rel="stylesheet" type="text/css" href="../admin/main.css"/>
        
        <script type="text/javascript" src="../res/jquery/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../admin/main.js"></script>
    </head>
    <body>
        <div id="header" class="container fixed top-0 left-0 right-0 mx-auto bg-gray-700 text-white h-10 px-3 flex justify-between">
            <div class="__mr-auto overflow-x-hidden flex">
                <span class="my-auto text-2xl whitespace-nowrap">u.board</span>
            </div>
            <div class="cm-control flex">
                <a class="cm-home my-auto cursor-pointer flex h-full text-2xl" href="<?php echo $Home; ?>">
                    <i class="fas fa-home my-auto"></i>
                </a>
                <i class="cm-check my-auto cursor-pointer text-2xl fas fa-check"></i>
            </div>
        </div>
        
        <div id="main" class="container mx-auto mt-16">
            <?php if(isset($_GET['t'])) $_template(); else $_main(); ?>
        </div>
        
        <?php if(!isset($_GET['t'])) {?>
        <div id="power" class="flex flex-row mt-5 mb-5 justify-around">
            <i class="cm-reload fas fa-3x fa-sync-alt m-auto cursor-pointer p-5 hover:bg-gray-200"></i>
            <i class="cm-power fas fa-3x fa-power-off m-auto cursor-pointer p-5 hover:bg-gray-200"></i>
        </div>
        <?php } ?>
        
        <div id="cm-message" class="flex">
            <span class="cm-ok bg-green-600 text-white py-3 bg-opacity-80 flex"><span class="m-auto">OK</span></span>
            <span class="cm-error bg-red-600 text-white py-3 bg-opacity-80 flex"><span class="m-auto">Error</span></span>
        </div>
    </body>
</html>