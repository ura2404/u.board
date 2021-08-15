$(document).ready(function(){
    
    var SliderTimer = $("meta[name='slidertimer']").attr('content') * 1000;
    var SliderCount = $('.splide .splide__list').length;

    var AdvTimer = $("meta[name='advtimer']").attr('content') * 1000;
    var AdvIndex = 0;
    var AdvCount = $('#adv').find('data').length;

console.log(SliderCount);
console.log(AdvCount);
    
    if(SliderCount){
        var splide = new Splide( '.splide' ,{
            //type   : 'loop',
            type   : 'fade',
            //type   : 'slide',

            autoplay : true,
            interval : SliderTimer,
            rewind   : true,

            arrows : false,
        
            pagination : false,
            pauseOnHover : false,
            pauseOnFocus : false,
        
            //perPage: 2,
            //focus    : 'center',
    
            //autoWidth : true,
            //autoHeight: true,
        
            //height : '50%',
            //width: '50%',
            //fixedHeight : '50%',
        
            arrows : false,
        
	}).mount();
    }

    var _fun = function(){
        var ToggleInterval = 1000;
        
        var I = setInterval(function(){
            clearInterval(I);
    
            if(SliderCount){
                var SliderIndex = splide.index;
                $('#slider').fadeToggle(ToggleInterval,function(){
                    var Src = $('#adv').find('data').eq(AdvIndex).attr('src');
                    var Player = '<video autoplay="true" _loop="true" muted="muted"><source src="'+ Src +'" type="video/mp4" /></video>';
                    $('#adv').append(Player).find('video').on('ended',function(){
                        if(++AdvIndex > AdvCount-1) AdvIndex = 0;
                        splide.go(SliderIndex);
                        $(this).remove();

                        $('#slider').fadeToggle(ToggleInterval,function(){
                            _fun();
                        });
                    });
                });
            }
            else{
                var Src = $('#adv').find('data').eq(AdvIndex).attr('src');
                var Player = '<video autoplay="true" _loop="true" muted="muted"><source src="'+ Src +'" type="video/mp4" /></video>';
                $('#adv').append(Player).find('video').on('ended',function(){
                    if(++AdvIndex > AdvCount-1) AdvIndex = 0;
                    $(this).remove();
                    _fun();
                });
            }



        },AdvTimer);
    };
    
    if(AdvCount) _fun();
});