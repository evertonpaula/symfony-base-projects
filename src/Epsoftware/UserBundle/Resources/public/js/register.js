$(function () {
    $('.icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});

$(function(){
   $("input").focusin(function(){
       var $div = $(this).closest('div');
       $div.find('ul').fadeOut(250);
       $div.removeClass('has-error');
   });
});

$(document).ready(function(){
    $('#modal_terms').on('show.bs.modal',function(){
       $.post($(this).attr('href'), function(data){
           $(this).find(".modal-content").html(data).fadeIn(250);
       });
   }); 
});
