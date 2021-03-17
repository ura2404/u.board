<?php
    $Root = realpath(dirname(__FILE__).'/../..');
    $Config = json_decode(file_get_contents($Root.'/config.json'),true)['u.board'];
    $TemplateCode = json_decode(file_get_contents($Root.'/config.json'),true)['u.board']['data']['template']['value'];
    $Template = json_decode(file_get_contents($Root.'/templates/'.$TemplateCode.'/config.json'),true)['template'];
    //var_dump($Config);die();
    
    /*
    //var_dump($Template);
    //var_dump($Root.'/templates/'.$Template.'index.php');
    
    chdir($Root.'/www');
    symlink($Root.'/templates/'.$Template.'/index.php','index.php');
    symlink($Root.'/templates/'.$Template.'/data','data');
    symlink($Root.'/templates/'.$Template.'/tpl','tpl');
    */

    $_form = function($config){
        $_color = function($code,$data){
            echo '<input class="h-8" type="color" name="' .$code. '" value="' .$data['value']. '"/>';
        };
        
        $_integer = function($code,$data){
            echo '<input class="h-8" type="text" name="' .$code. '" value="' .$data['value']. '"/>';
        };
        
        $_element = function($code,$data) use($_color,$_integer){
            echo '<div>' .$data['name']. '</div>';
            if($data['type'] === 'color') $_color($code,$data);
            elseif($data['type'] === 'integer') $_integer($code,$data);
        };
        
        echo '<form class="cm-form grid grid-cols-2 gap-1.5" method="post">';
        array_map(function($code,$data) use($_element){
            if($data['type'] === 'group'){
                echo '<div class="col-span-2 bg-gray-400 text-white">' .$data['name']. '</div>';
                array_map(function($code,$data) use($_element){
                    $_element($code,$data);
                },array_keys($data['list']),array_values($data['list']));
                echo '<div class="col-span-2 h-4"></div>';
            }
            else $_element($code,$data);
        },array_keys($config['data']),array_values($config['data']));
        echo '<form>';
    };

    $_main = function() use($Root,$Config,$TemplateCode,$_form){
        $_template = function($code) use($Root){
            $Path = $Root.'/templates/'.$code;
            if(!file_exists($Path) || !file_exists($Path.'/config.json')) return;
            $Config = json_decode(file_get_contents($Path.'/config.json'),true)['template'];
            return $Config;
        };
        
        echo '<form class="cm-form grid grid-cols-2 gap-1.5" method="post">';
        array_map(function($code,$data) use($Root,$TemplateCode,$_template){
            echo '<div>' .$data['name']. '</div>';
            
            if($data['type'] === 'menu'){
                if($code === 'template'){
                    echo '<div class="flex">';
                    echo '<select name="' .$code. '" class="cm-edit cursor-pointer">';
                    
                    $Templates = array_filter(scandir($Root.'/templates/'),function($value){
                        return $value == '.' || $value == '..' ? false : true;
                    });
                    
                    array_map(function($value) use($code,$TemplateCode,$_template){
                        var_dump($value);
                        echo '<option value="' .$value. '"' .($TemplateCode === $value ? 'selected="selected"' : null). '>' .($_template($value))['name']. '</option>';
                    },$Templates);
                    
                    echo '</select>';
                    echo '<i class="cm-tpl-edit ml-2 my-auto fas fa-cog text-gray-700 cursor-pointer"></i>';
                    echo '</div>';
                }
            }
            else{
                echo '<input name="' .$code. '" class="cm-edit cursor-pointer" value="' .$data['value']. '">';
            }
            
        },array_keys($Config['data']),array_values($Config['data']));
        echo '</form>';
    };
    
    $_template = function() use($Template,$_form){
        echo '<div class="grid grid-cols-2 gap-1.5 auto-rows-max mb-6">';
        echo '<div>Шаблон</div>';
        echo '<div>' .$Template['name']. '</div>';
        echo '<div class="col-span-2 bg-blue-400 text-white">'.$Template['descriptor']. '</div>';
        echo '</div>';
        
        $_form($Template);
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
        <header class="container font-sans mx-auto bg-gray-700 text-white h-10 flex">
            <div class="cm-template flex-grow overflow-x-hidden">
                <span class="text-2xl whitespace-nowrap">
                    <?php //echo $Config['name']; ?>
                    u.board
                    
                </span>
            </div>
            <div class="cm-control text-right flex">
                <i class="cm-home my-auto fas fa-home"></i>
                <i class="cm-check my-auto fas fa-2x fa-check"></i>
            </div>
        </header>
        <div id="main" class="container mx-auto mt-6 px-3">
            <?php if(isset($_GET['t'])) $_template(); else $_main(); ?>
        </div>
        
        <div id="power" class="flex cursor-pointer mt-10 mb-10">
            <i class="cm-power fas fa-3x fa-power-off mx-auto"></i>
        </div>
        
        <div id="cm-message" class="text-center">
            <span class="cm-ok bg-green-600 text-white py-3 bg-opacity-80">OK</span>
            <span class="cm-error bg-red-600 text-white py-3 bg-opacity-80">Error</span>
        </div>
    </body>
</html>