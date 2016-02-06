var errorAddress = function(data){
    console.warn('ERRO FATAL: ',data);
};

var setCidades = function(data){
    $('#address_form_cidade').html(data).fadeIn();
};

var setEstados = function(data){
    $('#address_form_estado').html(data).fadeIn();
};

var getAjaxList = function(url, method, data, setMethod){
    Pace.track(function(){
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: setMethod,
            error: errorAddress
        });
    });
};

window.onload = function(){
    
    $(function(){
        $('.cep').inputmask({"mask": "99999-999"}); 
    });
    
    $(function(){
        $('form[name=address_form]').submit(function(e){
           e.preventDefault();
           ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize());
           document.address_form.reset();
        });
    });

    $('#address_form_estado').change(function(){
        getAjaxList($(this).data('url'), $(this).data('method'), $(this).serialize(), setCidades);
    });
    
    $('#address_form_pais').change(function(){
        getAjaxList($(this).data('url'), $(this).data('method'), $(this).serialize(), setEstados);
    });
        
};


