$(document).ready(function(){
    
    var table = $('#logs').DataTable({
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
        
    //new $.fn.dataTable.Responsive(table);
    
    $(function(){
       $(".reflash").click(function(e){
           e.preventDefault();
           table.ajax.reload();
       });
    });
});