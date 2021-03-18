var _t = function(cl){
    $('#cm-message').addClass(cl);
    setTimeout(function(){
        $('#cm-message').removeClass(cl);
    },1300);
};

//console.log(document.referrer);

$(document).ready(function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    
    $('.cm-check').on('click',function(){
        var Data = urlParams.has('t') ? {
            m : 't',
            d : $('.cm-form').serializeArray()
        } : {
            m : 'm',
            d : $('.cm-form').serializeArray()
        };
        
        $.ajax({
            method : 'post',
            url : '../admin/post.php',
            data : Data
        })
        .done(function(data){
            $('body').removeClass('cm-edit');
            _t('cm-ok');
            
        })
        .fail(function(data, textStatus, jqXHR){
            $('body').removeClass('cm-edit');
            _t('cm-error');
        });
    });
    
    $('.cm-edit').on('change',function(){
        $('body').addClass('cm-edit');
    });
    
    $('.cm-tpl-edit').on('click',function(){
        if($('body').hasClass('cm-edit')) return;
        
        if(!urlParams.has('t')) window.location.href = document.location + '?t';
    });
});