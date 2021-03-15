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
        <header class="container font-sans mx-auto bg-gray-700 text-white">
            <!-- <div class="grid justify-items-auto grid-cols-2 p-4"> -->
            <!-- <div class="grid auto-cols-fr grid-cols-3 p-4"> -->
            <div class="flex p-4">
                <div class="cm-template flex-grow overflow-x-hidden">
                    <span class="text-2xl whitespace-nowrap">
                        <?php //echo $Config['name']; ?>
                        u.board
                        
                    </span>
                </div>
                <div class="cm-control text-right flex">
                    <i class="cm-home my-auto fas fa-home"></i>
                    <i class="cm-check my-auto far fa-2x fa-check-circle"></i>
                </div>
            <div>
        </header>
        <div id="main" class="container mx-auto mt-6 p-4 grid grid-cols-2 gap-1.5">
            <?php
                //var_dump(array_values($Config['data']));die();
                
                $_template = function($code) use($Root){
                    $Path = $Root.'/templates/'.$code;
                    if(!file_exists($Path) || !file_exists($Path.'/config.json')) return;
                    $Config = json_decode(file_get_contents($Path.'/config.json'),true)['template'];
                    return $Config;
                };
                
                array_map(function($code,$data) use($Root,$_template){
                    echo '<div>' .$data['name']. '</div>';
                    
                    if($data['type'] === 'menu'){
                        if($code === 'template'){
                            $Template = $_template($data['value']);
                            echo '<div>';
                            echo '<div class="underline cursor-pointer">' .($Template ? $Template['name'] : null). '</div>';
                            
                            echo '<ul class="cm-menu">';
                            $Templaes = array_filter(scandir($Root.'/templates/'),function($value){
                                return $value == '.' || $value == '..' ? false : true;
                            });
                            array_map(function($value){
                                echo '<li>' .$value. '</li>';
                            },$Templaes);
                            echo '</ul>';
                            
                            echo '</div>';
                        }
                    }
                    else echo '<div class="underline cursor-pointer">' .$data['value']. '</div>';
                    
                },array_keys($Config['data']),array_values($Config['data']));
            /*
                foreach($Config['data'] as $code=>$data){
                    echo '<div>' .$data['name']. '</div>';
                    
                    if($type === 'menu'){
                        echo '<div class="cm-menu underline cursor-pointer">' .$Template['name']. '</div>';
                        
                        echo '<ul class="cm-menu">';
                        echo '<li>111</li>';
                        echo '<li>222</li>';
                        echo '</ul>';
                        
                        
                    }else echo '<div class="underline cursor-pointer">' .$data['value']. '</div>';
                }
            */
            ?>
        </div>
    </body>
</html>