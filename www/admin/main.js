var _t = function(cl){
    $('#cm-message').addClass(cl);
    setTimeout(function(){
        $('#cm-message').removeClass(cl);
    },1300);
};

/*
function renderImage(file,tag){
    if(!file.type.startsWith('image/')) return;
    
    var $Img = tag.find('img');
    $Img[0].file = file;
    console.log($Img);
    
    // генерируем новый объект FileReader
    var reader = new FileReader();

    // дабавляет атрибут src в изображение
    reader.onload = function(event) {
        the_url = event.target.result;
        $Img.attr('src',the_url);
    };
    
    // когда файл считывается он запускает событие OnLoad.
    reader.readAsDataURL(file);    
}
*/
/*
function handleFiles(files){
    var $Template = $('.cm-pic.cm-template');
    
    //console.log(files);
    
    for (var i = 0, numFiles = files.length; i < numFiles; i++) {
      var file = files[i];
      var $A = $Template.clone(true,true).removeClass('cm-template').find('img').addClass('cm-newpic').end().find('.cm-size').text(Math.round(file.size/1024) + ' kB').end().insertBefore($('.cm-pics .cm-add'));
      renderImage(file,$A);
    }    
}
*/
/*
function FileUpload(img, file) {
  const reader = new FileReader();
  this.ctrl = createThrobber(img);
  const xhr = new XMLHttpRequest();
  this.xhr = xhr;

  const self = this;
  this.xhr.upload.addEventListener("progress", function(e) {
        if (e.lengthComputable) {
          const percentage = Math.round((e.loaded * 100) / e.total);
          self.ctrl.update(percentage);
        }
      }, false);

  xhr.upload.addEventListener("load", function(e){
          self.ctrl.update(100);
          const canvas = self.ctrl.ctx.canvas;
          canvas.parentNode.removeChild(canvas);
      }, false);
  xhr.open("POST", "http://demos.hacks.mozilla.org/paul/demos/resources/webservices/devnull.php");
  xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');
  reader.onload = function(evt) {
    xhr.send(evt.target.result);
  };
  reader.readAsBinaryString(file);
}
//console.log(document.referrer);
*/

var _flag = function(value){
    $.ajax({
        method : 'post',
        url : '../admin/flag.php',
        data : {
            f : value
        }
    })
    .done(function(data){
        _t('cm-ok');
        
    })
    .fail(function(data, textStatus, jqXHR){
        _t('cm-error');
    });
    
};

$(document).ready(function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    
    $('.cm-check').on('click',function(){
        
        $('.cm-form').submit();
        return;
        
        /*
        //var Imgs = document.querySelectorAll('.cm-newpic');
        var Imgs = $('.cm-newpic');
        console.log(Imgs);
        
        if(Imgs.length) for(var i = 0; i < Imgs.length; i++){
            console.log(Imgs[i], Imgs[i].file);
            new FileUpload(Imgs[i], Imgs[i].file);
        }

        $.ajax({
            method : 'post',
            url : '../admin/post.php',
            data : $('.cm-form').serializeArray(),
        })
        .done(function(data){
            $('body').removeClass('cm-edit');
            _t('cm-ok');
            
        })
        .fail(function(data, textStatus, jqXHR){
            console.log('fail',data);
            $('body').removeClass('cm-edit');
            _t('cm-error');
        });
        */
    });
    
    $('.cm-edit').on('change',function(){
        $('body').addClass('cm-edit');
    });
    
    $('.cm-tpl-edit').on('click',function(){
        if($('body').hasClass('cm-edit')) return;
        
        if(!urlParams.has('t')) window.location.href = document.location + '?t';
    });
    
    $('.cm-pic .cm-on').on('click',function(){
        $(this).toggleClass('disable').closest('.cm-pic').find('input').attr('value',+!$(this).hasClass('disable'));
        $('body').addClass('cm-edit');
    });
    
    $('.cm-pic .cm-del').on('click',function(){
        $(this).closest('.cm-pic').remove();
        $('body').addClass('cm-edit');
    });
    
    $('.cm-pics .cm-add').on('click',function(e){
        e.preventDefault();
        
        $('.cm-pics .cm-files').click();
        
    });
    
    
    $('.cm-video .cm-on').on('click',function(){
        $(this).toggleClass('disable').closest('.cm-video').find('input').attr('value',+!$(this).hasClass('disable'));
        $('body').addClass('cm-edit');
    });
    
    $('.cm-video .cm-del').on('click',function(){
        $(this).closest('.cm-video').remove();
        $('body').addClass('cm-edit');
    });
    
    $('.cm-reload').on('click',function(){
        _flag('reload');
    });
    
    $('.cm-power').on('click',function(){
        _flag('power');
    });
    
});