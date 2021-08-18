$(document).ready(function(){
    var
    $Text = $('.text'),
    $Input = $('.input'),
    $Alert = $('.alert'),
    $Success = $('.success'),
    $Mask = $('.mask'),
    PassLength = $('.pass').data('pass').reduce((r,c) => r += c.toString().length,0),
    PassValue = $('.pass').data('pass').map((p) => {
        return p-3;
    }).join(''),
    Timeout =  $('.pass').data('timeout'),
    _timer = function(){
        var Timer = setTimeout(() => {
            location.reload();
        },Timeout * 1000)
    },
    _alert = function(){
        $('body').off('keydown').addClass('alert');
        $Text.text('Пароль неверный');
        _timer();

        /*$Input.hide(0,() => {
            $Alert.show(0,() => {
                $Alert.addClass('show');
                _timer();
            });
        });*/
    },
    _success = function(){
        $('body').off('keydown').addClass('success');;
        $.post('res/g.php?1');
        $Text.text('Верный ввод пароля');

        /*$Input.hide(0,() => {
            $Success.show(0,() => {
                $Success.addClass('show');
                _timer();
            });
        });*/
    };

    // --- --- --- --- ---
    $.post('res/g.php');

    let P = ''
    $('body').focus().on('keydown',function(e){
        if(e.key != parseInt(e.key)) return;

        P += e.key;
        $('.pass').text(P);

        if(P.length == PassLength && P != PassValue) _alert();
        else if(P.length == PassLength && P == PassValue) _success();
    })
});