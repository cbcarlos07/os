
$( document ).ready( function () {
    carregarTabela();
    loadTotal();
} );

$('.btn-novo').on('click',function () {
    console.log( 'Click' );
    var form = $('<form action="cadastrofornecedor.php" method="post">' +
        '</form>');
    $('body').append( form );
    form.submit();
});


function carregarTabela(){
    $.ajax({
        url : 'funcao/fornecedor.php',
        type: 'post',
        dataType: 'json',
        data : {
            acao : 'F'
        },
        success : function (data) {
            var linha = "";

            $.each( data, function (i, j) {
                var check = "";
                if( j.sn_ativo == 'S'  )
                    check = "<i class='fa fa-check'></i>";
                linha += "<tr>"+
                            "<td>"+j.cd_fornecedor+"</td>"+
                            "<td>"+j.nm_fantasia+"</td>"+
                            "<td>"+j.ds_sigla+"</td>"+
                            "<td>"+check+"</td>"+
                            "<td> <a href='#' class='btn btn-success btn-alterar' data-id='"+ j.cd_fornecedor +"'>Alterar</a> "+
                            " <a href='#' class='btn btn-danger btn-alterar' data-id='"+ j.cd_fornecedor +"'>Excluir</a> </td>"+
                         "</tr>"
            } );
            var tbody = $('.tbody');
            tbody.find('tr').remove();
            tbody.append( linha );

            pagingTable();

            $('.btn-alterar').on('click', function () {
                var id = $( this ).data('id');
                var form = $('<form action="alterarfornecedor.php" method="post">' +
                    '<input type="hidden" name="codigo" value="'+id+'">'+
                    '</form>');
                $('body').append( form );
                form.submit();
            });

        }
    });
}


function pagingTable() {
    $('#bem_table').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "pageLength": 10,
        "retrieve": true

    });
}

function loadTotal(  ) {
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    loadTotalMenu( usuario, funcion );

    setTimeout( function(){
        loadTotal();
    },30000 );
}