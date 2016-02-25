var callbackInsertProfile = function(data){
    if(data.info){
        document.location.reload(true);
    }else{
        callback(data);
    }
};

$(function(){
   $('.date').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',
        clearBtn: true
    });
});

$(function(){
   $('.icheck').iCheck({
        checkboxClass: 'icheckbox_polaris',
        increaseArea: '-10%', // optional);
        labelHover: true
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
        var form = $(this).closest('form');
        ajax($(form).attr('action'),$(form).attr('method'),$(form).serialize());
    });
});

$(function(){
    var collpsed = "sidebar-collapse";
    var process = function($form){
        ajax($form.attr('action'),$form.attr('method'),$form.serialize());
    };
    $('#setting_form_menuNoCollapsed').on('ifChecked', function(event){
        process($(this).closest('form'));
        $('body').addClass(collpsed);
    });
    $('#setting_form_menuNoCollapsed').on('ifUnchecked', function(event){
        process($(this).closest('form'));
        $('body').removeClass(collpsed);
    });
});

$(function(){
    $('form[name=update_user_form]').submit(function(e){
        e.preventDefault();
        ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize(), callback);
    });
});

$(function(){
    $('form[name=profile_form]').submit(function(e){
       e.preventDefault();
       ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize(), callbackInsertProfile);
    });
});
