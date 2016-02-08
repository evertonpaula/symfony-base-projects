window.onload = function(){
    
    var errorAddress = function(data){
        console.warn('ERRO FATAL: ',data);
    };

    var setOptionsAddress = function(data, select){
        $(select).html(data).fadeIn();
    };

    var getFormEditAddress = function(data){
        if(data.warning || data.error){
            callMesageAddress(data);
        }else{
            var $modal = $("#modal_address_edit").find('.modal-content');
            var $html = $(data);
            $($modal).html($html).fadeIn();
        }
    };

    var getListAddress = function(url, method, data, setOptions, select){
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
    
    var callMesageAddress = function(data){
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
    
    var addNewAddressToList = function(parameters){
        if(parameters.callback){
            var $data = $(parameters.view);
            $("#listAddress").append($data).fadeIn();
        }
        callback(parameters);
    };
   
    var addEditAddressToList = function(parameters){
        if(parameters.callback){
            var $data = $(parameters.view),
                $new = $($data.find('.info-box')),
                $address = $new.data('address');
            var $local = $('[data-address~="'+$address+'"]');
                $local.replaceWith($new);
        }
        callback(parameters);
    };
    
    $(function(){
        $('.cep').inputmask({"mask": "99999-999"}); 
    });

    $(function(){
        $('body').on('submit', 'form.addressAdd', function(e){
            e.preventDefault();
            ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize(),addNewAddressToList);
            document.forms.address_form.reset();
        });
    });

    $(function(){
        $('body').on('submit','.addressEdit', function(e){
           e.preventDefault();
           ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize(), addEditAddressToList);
        });
    });

    $(function(){
        $('body').on('change', '.address_form_estado' ,function(){
            var $form = $(this).closest('form');
            var $select = $form.find('select.address_form_cidade');
            $($select).html('<option value selected="selected">Carregando...</option>');
            getListAddress($(this).data('url'), $(this).data('method'), $(this).serialize(), setOptionsAddress, $select);
        });
    });

    $(function(){
        $('body').on('change', '.address_form_pais', function(){
            var $form = $(this).closest('form');
            var $select = $form.find('select.address_form_estado');
            $($select).html('<option value selected="selected">Carregando...</option>');
            getListAddress($(this).data('url'), $(this).data('method'), $(this).serialize(), setOptionsAddress, $select);
        });
    });

    $(function(){
        $("body").on('click', '.listAddress', function(){
            loader($("#modal_address_edit").find('.modal-content'));
            $.post($(this).data('url'), null, getFormEditAddress);
        });
    });
    
    $(function(){
        $("body").on('click', '.deleteAddress', function(){
            var parameters = {url: $(this).data('url'), divToRemove :$(this).closest('div.col-sm-12')};
            var deleteAddress = function(parameters){
                ajax(parameters.url, "POST", null);
                $(parameters.divToRemove).remove();
            };
            confirm("Você realmente deseja excluir este endereço?", deleteAddress, parameters);
        });
    });
    
};