$(document).ready(function(){
    var
    Pass = '',
    $Input = $('.input'),
    $Alert = $('.alert'),
    $Success = $('.success'),
    $Atom = $('.atom'),
    PassLength = $('.pass').data('len'),
    PassValue = $('.pass').data('pass'),
    Timeout =  $('.pass').data('timeout'),
    _timer = function(){
        var Timer = setTimeout(()=>{
            location.reload();
        },Timeout * 1000)
    },
    _alert = function(){
        $('body').off('keydown');
        $Atom.addClass('red');
        $Input.hide(0,() => {
            $Alert.show(0,() => {
                $Alert.addClass('show');
                _timer();
            });
        });
    },
    _success = function(){
        $('body').off('keydown');
        $.post('res/g.php?1');
        $Atom.addClass('green');
        $Input.hide(0,() => {
            $Success.show(0,() => {
                $Success.addClass('show');
                _timer();
            });
        });
    };

    $.post('res/g.php');
    $('body').focus().on('keydown',function(e){
        Pass += e.key;
        if(Pass.length < PassLength){
            $('.pass').text(Pass.replace(/./g,"*"));
        }
        else{
            console.log(Pass,$.md5(Pass));
            if($.md5(Pass) === PassValue) _success();
            else _alert();
        }
    })
});