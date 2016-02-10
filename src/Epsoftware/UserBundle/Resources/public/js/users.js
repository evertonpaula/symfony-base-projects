var callbackUsers = function(data){
    var $div = $("#modal").find('.modal-content');
    if(data.error){
        $("#modal").modal("hide");
        $div.html("");
        callback(data);
    }else{
        var $html = $(data);
        $div.html($html).show();
    }
};

$(document).ready(function(){
    var table = $('#users').DataTable({
        language: dataTable.laguage.pt_br
    });
    new $.fn.dataTable.Responsive(table);
       
    $(function(){
        $("body").on('click', '.delete', function(){
            var parameters = {url: $(this).data("url"), id: $(this).data("id"), divToRemove :$(this).closest("tr")};
            var deleteUsuario = function(parameters){
                $.post(parameters.url, {id: parameters.id}, function(data){
                    if(data.success){$(parameters.divToRemove).remove();}
                    callback(data);
                });
            };
            confirm("Você realmente deseja excluir este usuário?", deleteUsuario, parameters);
        });
    });
    
    $(function(){
        $("body").on('click', '.action', function(){
            $("#modal").modal("show");
            loader($("#modal").find('.modal-content'));
            $.post($(this).data("url"), {id: $(this).data("id")}, callbackUsers);
        });
    });
});