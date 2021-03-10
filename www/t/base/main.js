var AdvInterval = 5000;
var Player = '<video autoplay="true" _loop="true" muted="muted"><source src="data/play.mp4" type="video/mp4" /></video>';

var _fun = function(){
    var I = setInterval(function(){
        $('body').addClass('video')
        $('.splide').fadeToggle(1000,function(){
            clearInterval(I);
            $('body').append(Player).find('video').on('ended',function(){
                $(this).remove();
                $('body').removeClass('video');
                $('.splide').fadeToggle(1000,function(){
                    _fun();
                });
            });
        });
    },AdvInterval);
};

var _slider = function(){
    new Splide( '.splide' ,{
        
        autoplay : true,
        interval : 2000,
        rewind   : true,
        
        pagination : false,
        pauseOnHover : false,
        pauseOnFocus : false,
        
        //perPage: 2,
        
        //focus    : 'center',
        
        
        //type   : 'loop',
        type   : 'fade',
        //type   : 'slide',
        
        //autoWidth : true,
        //autoHeight: true,
        
        //height : '50%',
        //width: '50%',
        //fixedHeight : '50%',
        
        arrows : false,
        
    }).mount();
};

$(document).ready(function(){
    _slider(); 
    _fun();
});