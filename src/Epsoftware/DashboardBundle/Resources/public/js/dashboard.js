var animateNoty = {
    open: 'animated bounceInRight', // Animate.css class names
    close: 'animated bounceOutRight', // Animate.css class names
    easing: 'swing', // unavailable - no need
    speed: 500 // unavailable - no need
};

var loader = function(local){
    var $data = $('<div class="loader"><div class="battery"><div class="liquid"></div></div><h5 class="loader-h5">carregando</h5></div>');
    $(local).html($data);
};

var confirm = function(message, callback, parameters){
    noty({
        text: message + "<hr class='confirm-hr'>",
        layout: 'topCenter',
        type: 'confirm', // alert, success, error, information, warning
        theme: 'bootstrapTheme',
        modal: true,
        animation: {
            open: 'animated bounceInUp', // Animate.css class names
            close: 'animated bounceOutDown', // Animate.css class names
            easing: 'swing', // unavailable - no need
            speed: 500 // unavailable - no need
        },
        buttons: [
            { addClass: 'comfirm-button btn btn-sm btn-danger', text: 'Cancelar', onClick: function($noty) {
                    $noty.close();
                }
            },
            {addClass: 'comfirm-button btn btn-sm btn-primary', text: 'Sim', onClick: function($noty){
                    callback.call(this, parameters);
                    $noty.close();
                }
            }
        ]
    });
};

var success = function (data){
    return noty({
        text: data.message,
        layout: 'topRight',
        type: 'success', // alert, success, error, information, warning
        theme: 'bootstrapTheme',
        timeout: 4000,
        closeWith: ['click'],
        animation: animateNoty
    });
};
 
var error = function(data){
    return noty({
        text: data.message,
        layout: 'topRight',
        type: 'error',
        theme: 'bootstrapTheme',
        closeWith: ['click','backdrop'],
        timeout: 10000,
        animation: animateNoty
    });
};
 
var info = function(data){
    return noty({
        text: data.message,
        layout: 'topRight',
        type: 'information', // alert, success, error, information, warning
        theme: 'bootstrapTheme',
        timeout: 10000,
        closeWith: ['click'],
        animation: animateNoty
    });
 };
 
var warning = function(data){
    return noty({
        text: data.message,
        layout: 'topRight',
        type: 'warning', // alert, success, error, information, warning
        theme: 'bootstrapTheme',
        closeWith: ['click'],
        timeout: 10000,
        animation: animateNoty
    });
 };
 
var alert = function(message){
    return noty({
        text: message,
        layout: 'topCenter',
        type: 'alert', // alert, success, error, information, warning
        theme: 'bootstrapTheme',
        closeWith: ['click'],
        animation: animateNoty
    });
 };
 

var callback = function(data){
    
    if(data.success){
        success(data);
    }else if(data.warning){
        warning(data);
    }else if(data.info){
        info(data);
    }else if(data.error){
        var message = convertJson(data.message);
        if(message !== false){
            for(var i = 0; i < message.length; i++){
                error(message[i]);
            }
        }else{
            error(data);
        }
    }else if(data.upload_error){
        var message = convertJson(data.message);
        if(message !== false){
            for(var i = 0; i < message.callback.length; i++){
                error({"message" : message.callback[i]});
            }
        }else{
            error(data);
        }
    }
};

var isString = function(string){
    return (typeof(string) === "string") ? true : false;
};

var convertJson = function(str){
    try {
        var converted = JSON.parse(str);
        return converted;
    }catch(e){
        return false;
    }
};

var errorCallback = function(data){
    console.warn("ERRO FATAL: ", data);
};

var ajax = function(url, method, data, setCallback){
    Pace.track(function(){
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: (typeof setCallback === 'undefined') ? callback : setCallback,
            error: errorCallback
        });
    });
    
};

var upload = function(url, method, data, setCallback){
    Pace.track(function(){
        $.ajax({
            url: url,
            method: method,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: (typeof setCallback === 'undefined') ? callback : setCallback,
            error: errorCallback
        });
    });
};

$(document).ready(function(){
    
    var modalDash = $('#modal_dash');
    var modalDashContent = modalDash.find('.modal-content');

    var setModalContent = function(data){
        var $html = $(data);
        modalDashContent.html($html);
    };
    
    var setImageUser = function(data){
        callback(data);
        if(data.success){
            modalDash.modal("hide");
            $('body').find('img.user').each(function(){
               $(this).prop('src', data.image);
            });
        }
        
    };
    
    $(function(){
       $('.alter-image-user').click(function(e){
            e.preventDefault();
            modalDash.modal("show");
            loader(modalDashContent);
            ajax($(this).data('url'), "POST", null, setModalContent);
       });
    });
    
    $(function(){
        $('body').on('submit', 'form[name=upload_image_user]', function(e){
            e.preventDefault();
            var form = new FormData(this);
            upload($(this).attr('action'), "POST", form, setImageUser);
        });
    });
});