var _t = function(cl){
    $('#cm-message').addClass(cl);
    setTimeout(function(){
        $('#cm-message').removeClass(cl);
    },1300);
};

console.log(document.referrer);

$(document).ready(function(){
    $('.cm-check').on('click',function(){
        $.ajax({
            method : 'post',
            url : '../admin/post.php',
            data : $('.cm-form').serializeArray()
            
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
        
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);        
        if(!urlParams.has('t')) window.location.href = document.location + '?t';
    });
});