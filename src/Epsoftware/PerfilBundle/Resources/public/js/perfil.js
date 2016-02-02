var callback = function(data){
    console.log(data);
};

$(function(){
   $('.date').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',
        clearBtn: true
    });
});

$(function(){
   $('.cpf').inputmask({"mask": "999.999.999-99"});
   $('.telefone').inputmask({"mask": "(99) 9999-9999"});
   $('.celular').inputmask({"mask": "(99) 99999-9999"});
   $('.date').find('input').inputmask({"mask": "99/99/9999"});
});

$(function(){
    var current_skin = $('body').attr('data-theme');
    $('#setting_form_theme').change(function() {
        var skinName = $("#setting_form_theme option:selected").text();
        $('body').removeClass(current_skin);
        $('body').addClass(skinName);
        current_skin = skinName;
    });
});


$(function(){
    $('form[name=profile_form]').submit(function(e){
       e.preventDefault();
       $.post($(this).attr('action'), $(this).serialize(), callback);
    });
});