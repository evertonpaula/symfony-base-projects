var errorAddress = function(data){
    console.warn('ERRO FATAL: ',data);
};

var setOptions = function(data, select){
    $(select).html(data).fadeIn();
};

var getFormEdit = function(data){
    var $html = $(data);
    var modal = $("#modal_address_edit").find('.modal-content');
        $(modal).html($html).fadeIn();
    };

var getAjaxList = function(url, method, data, setOptions, select){
    Pace.track(function(){
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function(data){setOptions(data,select);},
            error: errorAddress
        });
    });
};

window.onload = function(){
    
    $(function(){
        $('.cep').inputmask({"mask": "99999-999"}); 
    });
    
    $(function(){
        $('body').on('submit', '.addressAdd', function(e){
           e.preventDefault();
           if(ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize()));
               document.address_form.reset();
        });
    });
    
    $(function(){
        $('body').on('submit','.addressEdit', function(e){
           e.preventDefault();
           ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize());
        });
    });
    
    $(function(){
        $('body').on('change', '.address_form_estado' ,function(){
            var $form = $(this).closest('form');
            var $select = $form.find('select.address_form_cidade');
            getAjaxList($(this).data('url'), $(this).data('method'), $(this).serialize(), setOptions, $select);
        });
    });
    
    $(function(){
        $('body').on('change', '.address_form_pais', function(){
            var $form = $(this).closest('form');
            var $select = $form.find('select.address_form_estado');
            getAjaxList($(this).data('url'), $(this).data('method'), $(this).serialize(), setOptions, $select);
        });
    });
    
    $(function(){
        $("body").on('click', '.listAddress', function(){
            var id = {id : $(this).data("id")};
            $.post($(this).data('url'), id, getFormEdit);
        });
    });
};
    
