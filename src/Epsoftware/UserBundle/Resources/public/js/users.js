var modalContent = $("#modal").find('.modal-content');
var modal =  $("#modal");

var callbackUsers = function(data){
    if(data.message){
        modal.modal("hide");
        modalContent.html("");
        callback(data);
    }else{
        var $html = $(data);
        modalContent.html($html).show();
    }
};

var callbackAccess = function(data){
    if(data.message){
        modal.modal("hide");
        modalContent.html("");
        callback(data);
    }else{
        var $html = $(data);
        modalContent.html($html);
        
        var form = $('form[name=admin_user_access]');
        form.find('.icheck').each(function(){
            $(this).iCheck({
                checkboxClass: 'icheckbox_polaris',
                increaseArea: '-10%', // optional);
                labelHover: true
            });
        });
    }
};

$(document).ready(function(){
    
    var table = $('#users').DataTable({
        responsive: true,
        language: dataTable.laguage.pt_br,
        ajax: {
            url: '/api/data/table/users',
            dataSrc: 'users'
        },
        columns: [
            { data: 'name' },
            { data: 'email' },
            { data: 'created' },
            { data: 'enable' },
            { data: 'locked' },
            { data: 'acountExpired' },
            { data: 'credentialExpired' },
            { data: 'action' }
        ]
    });
    //new $.fn.dataTable.Responsive(table);
    
    
    $(function(){
       $('body').on('submit', 'form[name=admin_user_access]', function(e){
           e.preventDefault();
           ajax($(this).attr('action'), $(this).attr('method'), $(this).serialize(),callback);
       });
    });
    
    $(function(){
       $('body').on('click', '.refactorPassword', function(e){
            e.preventDefault();
            var parameters = {url: $(this).data("url")};
            var newPassword = function(parameters){
                $.get(parameters.url, null, function(data){
                    callback(data);
                });
            };
            confirm("Você realmente deseja enviar uma nova senha a este usuário?", newPassword, parameters);
        });
    });
    
    $(function(){
        $("body").on('click', '.info', function(e){
            e.preventDefault();
            loader(modalContent);
            modal.modal("show");
            $.get($(this).data("url"), null, callbackUsers);
        });
    });
    
    $(function(){
        $("body").on('click', '.access', function(e){
            e.preventDefault();
            loader(modalContent);
            modal.modal("show");
            $.get($(this).data("url"), null, callbackAccess);
        });
    });
    
     $(function(){
        $("body").on('click', '.delete', function(e){
            e.preventDefault();
            var parameters = {url: $(this).data("url"), divToRemove : $(this).closest("tr")};
            var deleteUsuario = function(parameters){
                $.get(parameters.url, null, function(data){
                    callback(data);
                    if(data.success){$(parameters.divToRemove).remove();}
                });
            };
            confirm("Você realmente deseja excluir este usuário?", deleteUsuario, parameters);
        });
    });
});