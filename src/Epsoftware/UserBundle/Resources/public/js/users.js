$(document).ready(function(){
    
    var modalContent = $("#modal_user").find('.modal-content');
    var modal =  $("#modal_user");

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
    
    var callbackLogs = function(data){
        if(data.message){
            modal.modal("hide");
            modalContent.html("");
            callback(data);
        }else{
            var $html = $(data);
            modalContent.html($html);
            var $logs = modalContent.find("#logs");
            var table = $logs.DataTable({
                    responsive: true,
                    language: dataTable.laguage.pt_br,
                    ajax: {
                        url: $('#logs').data('url'),
                        dataSrc: 'logs'
                    },
                    columns: [
                        { data: 'created' },
                        { data: 'login' },
                        { data: 'name' },
                        { data: 'local' },
                        { data: 'acao' },
                        { data: 'descricao' }
                    ]
                });
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
            var user_permissions_form = $('form[name=user_permissions_form]');
            user_permissions_form.find(".icheck-permission").each(function(){
                $(this).iCheck({
                    checkboxClass: 'icheckbox_square-red',
                    radioClass: 'iradio_square-red',
                    increaseArea: '20%', // optional
                    labelHover: true
                });
            });
        }
    };
    
    
    var table_list_menus = $("#tableListMenus").DataTable({
        responsive: true,
        language: dataTable.laguage.pt_br
    });
    
    var table = $('#users').DataTable({
        responsive: true,
        language: dataTable.laguage.pt_br,
        ajax: {
            url: $('#users').data('url'),
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
       $(".reflash").click(function(e){
           e.preventDefault();
           table.ajax.reload();
       });
    });
    
    $(function(){
       $('body').on('submit', 'form[name=admin_user_access]', function(e){
           e.preventDefault();
           ajax($(this).attr('action'), $(this).attr('method'), $(this).serialize(),callback);
           table.ajax.reload();
       });
    });
    
    $(function(){
       $('body').on('submit', 'form[name=user_permissions_form]', function(e){
           e.preventDefault();
           ajax($(this).attr('action'), $(this).attr('method'), $(this).serialize(), callback);
        });
    });
    
    $(function(){
       $('body').on('click', '.refactorPassword', function(e){
            e.preventDefault();
            var parameters = {url: $(this).data("url"), table: table};
            var newPassword = function(parameters){
                $.get(parameters.url, null, function(data){
                    callback(data);
                    parameters.table.ajax.reload();
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
        $("body").on('click', '.logs', function(e){
            e.preventDefault();
            loader(modalContent);
            modal.modal("show");
            $.get($(this).data("url"), null, callbackLogs);
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