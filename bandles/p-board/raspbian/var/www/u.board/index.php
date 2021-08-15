<?php
require_once(realpath(dirname(__FILE__).'/common.php'));

$Pass = $Config['pass'];
$Timeout = $Config['timeout'];

$Body = '<div class="atom"></div>
<div class="container">
    <div class="text input">Введите пароль</div>
    <div class="pass input" data-len="' .strlen($Pass). '" data-pass="' .md5($Pass). '" data-timeout="' .$Timeout. '"></div>
    <div class="alert hidden">Пароль неверный</div>
    <div class="success hidden">Верный ввод пароля</div>
</div>';

print '<html>
    <head>
        <link rel="stylesheet" href="res/u.board.css"/>
        <script src="res/jquery-3.6.0.min.js"></script>
        <script src="res/jquery.md5.js"></script>
        <script src="res/u.board.js"></script>
    </head>
    <body>'.$Body.'</body>
</html>';
?>