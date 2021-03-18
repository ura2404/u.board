<?php
    $Root = dirname(__FILE__);
    $Config = json_decode(file_get_contents($Root.'/config.json'),true)['template'];

    $SliderBcolor = $Config['data']['bcolor1']['value'];
    $SliderTimer = $Config['data']['timer1']['value'];
    
    $AdvBcolor = $Config['data']['bcolor2']['value'];
    $AdvTimer = $Config['data']['timer2']['value'];
?>
<html>
    <head>
        <title>u.board</title>
        <link rel="icon" href="res/favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="res/jquery/jquery-3.6.0.min.js"></script>
        <!--link rel="stylesheet" type="text/css" href="res/jeasyui/1.5.1/themes/bootstrap/theme-cm.css"/-->
        
        <script type="text/javascript" src="res/splide/js/splide.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="res/splide/css/splide.min.css"/>
        <link rel="stylesheet" type="text/css" href="res/splide/css/themes/splide-default.min.css"/>
        
        <script type="text/javascript" src="tpl/main.js"></script>
        <link rel="stylesheet" type="text/css" href="tpl/main.css"/>
        
        <meta name="advtimer" content="<?php echo $AdvTimer; ?>" />
        <meta name="slidertimer" content="<?php echo $SliderTimer; ?>" />
    </head>
    
    <body>
        <div id="adv" style="background-color:<?php echo $AdvBcolor; ?>">
            <?php
                $Data = $Config['data']['video']['value'];
                foreach($Data as $video){
                    echo '<data src="data/adv/' .$video. '"></data>';
                }
            ?>
        </div>
        
        <div id="slider" style="background-color:<?php echo $SliderBcolor; ?>">
            <div class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php
                            $Data = $Config['data']['pic']['value'];
                            foreach($Data as $pic){
                                echo '<li class="splide__slide">';
                                echo '<img src="data/pics/'. $pic .'">';
                                echo '</li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        
    </body>
</html>