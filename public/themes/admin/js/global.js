/*
created by James Ha
officeday.net
*/

(function($){
    $.fn.login = function(option){
        var theId = option.theId;

        $(''+theId).submitAjaxForm({ theId:theId,refresh:1});
       // return false;
    }
    $.fn.loading = function(status = true) {
        if(status) {
            $(this).attr('disabled', true)
            $(this).append('<span class="spinner-border spinner-border-sm ml-1" role="status" aria-hidden="true"></span>');
        } else {
            $(this).attr('disabled', false)
            $(this).find('.spinner-border').remove();
        }
    }
}(jQuery));

(function($){
    $.fn.submitAjaxForm = function(option){
        var getUrl=$(''+option.theId).attr('action');
       // console.log(option.theId);
        var refresh=option.refresh;
           $('body').append('<div class="loadingEffect"></div>');
            $.ajax({
                url: getUrl,
                type: 'POST',
                data:$(''+option.theId).serialize(),
                success: function(result){
              //  alert('test');
                    $('.loadingEffect').remove();
                    //var result = JSON.parse(data);
                    if(result.status==1)
                    {
                        
                       toastr.success(result.msg, result.title);
                       
                        if(refresh==1)
                        {
                            window.setTimeout(function(){location.reload()},3000);
                        }

                    }
                    else
                    { 

                    	 toastr.error(result.msg, result.title);
                    }

                    return false;

                },
                error: function(data) {
                	$('.loadingEffect').remove();
                	toastr.error('Failed', 'Failed');
                }
               
            });

    return false;
    }
}(jQuery));
$(document).ready(function() {
    $(".add-pages-title").change(function() {
        $('.pages-slug').val(doDashes($(this).val()));
    });
})
function doDashes(str) {
    var from = "àáãảạăằắẳẵặâầấẩẫậèéẻẽẹêềếểễệđùúủũụưừứửữựòóỏõọôồốổỗộơờớởỡợìíỉĩịäëïîöüûñç",
        to = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeduuuuuuuuuuuoooooooooooooooooiiiiiaeiiouunc";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(RegExp(from[i], "gi"), to[i]);
    }

    str = str.toLowerCase()
        .trim()
        .replace(/[^a-z0-9\-]/g, '-')
        .replace(/-+/g, '-');

    return str;
}
function alertMsg(theURL,msg)
{

    if (confirm(msg))
    {
        window.location.href=theURL;
    }
    else
    {
        return false;
    }
}

function alertDelete(element, msg) {
    if (confirm(msg)) {
        $(element).parent('form').submit()
    }
    else
    {
        return false;
    }
}

function addSettingHaveImage(theClass){
    var action =jQuery(''+theClass).attr('action');
    var content = jQuery('.editor').html();
    var myEditor = document.querySelector('.editor');
    var content = myEditor.children[0].innerHTML;
    // console.log(content);return false;
    var dataForm = new FormData();
    var form_data = $(''+theClass).serializeArray();
    // console.log(form_data);return false;
    jQuery.each(form_data, function (key, input) {
      dataForm.append(input.name, input.value);
    });
    var file_data = jQuery('input[name="setting_image"]')[0].files;
    // console.log(file_data[0]);
    // return false;

    dataForm.append("setting_image", file_data[0]);
    dataForm.append("setting_content", content);

    jQuery.ajax({
      type: 'POST',
      url: action,
      processData: false,
      contentType: false,
      data: dataForm,
    }).done(function( response ) {
     var data = jQuery.parseJSON(response);
     if(data.status==1)
     {
       // window.location =rootDomain+'/admin/'+data.setting_key;
        toastr.success(data.msg, 'success');
     }
     else{
        toastr.error(data.msg, 'error');
     }
     return false;
  });
  return false;
}
function addSettingNoImage(theClass){
    var action =jQuery(''+theClass).attr('action');
    var dataForm = new FormData();
    var form_data = $(''+theClass).serializeArray();
    // console.log(form_data);return false;
    jQuery.each(form_data, function (key, input) {
      dataForm.append(input.name, input.value);
    });
    jQuery.ajax({
        type: 'POST',
        url: action,
        processData: false,
        contentType: false,
        data:dataForm,
      }).done(function( response ) {
       var data = jQuery.parseJSON(response);
       if(data.status==1)
       {
        toastr.success(data.msg, 'success');
          //window.location =rootDomain+'/admin/'+data.setting_key;
          
       }
       else{
          toastr.error(data.msg, 'error');
       }
       return false;
    });
    return false;
}