var success = function (data){
    return noty({
        text: data.message,
        layout: 'topRight',
        type: 'success', // alert, success, error, information, warning
        theme: 'bootstrapTheme',
        timeout: 4000,
        closeWith: ['click'],
         animation: {
            open: {right: 'toggle'}, // jQuery animate function property object
            close: {left: 'toggle'}, // jQuery animate function property object
            easing: 'swing', // easing
            speed: 500 // opening & closing animation speed
        }
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
         animation: {
            open: {right: 'toggle'}, // jQuery animate function property object
            close: {bottow: 'toggle'}, // jQuery animate function property object
            easing: 'swing', // easing
            speed: 500 // opening & closing animation speed
        }
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
         animation: {
            open: {right: 'toggle'}, // jQuery animate function property object
            close: {left: 'toggle'}, // jQuery animate function property object
            easing: 'swing', // easing
            speed: 500 // opening & closing animation speed
        }
    });
 };
 
var warning = function(data){
    return noty({
        text: data.message,
        layout: 'topRight',
        type: 'warning', // alert, success, error, information, warning
        theme: 'bootstrapTheme',
        closeWith: ['click'],
         animation: {
            open: {right: 'toggle'}, // jQuery animate function property object
            close: {left: 'toggle'}, // jQuery animate function property object
            easing: 'swing', // easing
            speed: 500 // opening & closing animation speed
        }
    });
 };
 
var alert = function(data){
    return noty({
        text: data.message,
        layout: 'top',
        type: 'alert', // alert, success, error, information, warning
        theme: 'bootstrapTheme',
        closeWith: ['click'],
         animation: {
            open: {right: 'toggle'}, // jQuery animate function property object
            close: {left: 'toggle'}, // jQuery animate function property object
            easing: 'swing', // easing
            speed: 500 // opening & closing animation speed
        }
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
        var message = JSON.parse(data.message);
        for(var i = 0; i < message.length; i++){
            error(message[i]);
        }
    }       
};



var errorCallback = function(data){
    console.warn("ERRO FATAL: ", data);
};

var ajax = function(url, method, data){
    Pace.track(function(){
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: callback,
            error: errorCallback
        });
    });
    
};