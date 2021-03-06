
$( document ).ready( function () {
    tabela();
    loadTotal();
} );


$('.btn-search').on('click', function () {
    tabela();
});

function tabela() {
    var tipo   = $('#tipo').val();
    $.ajax({
        url : 'funcao/tipo.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'D',
            item : tipo
        },
        success : function ( data ) {
            var tbody = $('.tbody');
            var corpo = "";
            $.each( data, function ( i, j ) {
                corpo += "<tr>" +
                    "<td>"+j.cd_tipo_equipamento+"</td>"+
                    "<td>"+j.ds_tipo_equipamento+"</td>"+
                    "<td> <a href='#' class='btn btn-success btn-alterar' data-id='"+ j.cd_tipo_equipamento +"'>Alterar</a> "+
                    " <a href='#' class='btn btn-danger btn-excluir' data-nome='"+j.ds_tipo_equipamento+"' data-id='"+ j.cd_tipo_equipamento +"'>Excluir</a> </td>"+
                    "</tr>";
            } );



            tbody.find('tr').remove();
            tbody.append( corpo );

            pagingTable();

            $('.btn-alterar').on('click', function () {
                var id = $( this ).data('id');
                //alert('Codigo: '+id);
                var form = $('<form action="tipoalt.php" method="post">' +
                    '<input type="hidden" name="codigo" value="'+id+'">'+
                    '</form>');
                $('body').append( form );
                form.submit();
            });

            $('.btn-excluir').on('click', function () {
                var id = $( this ).data('id');
                var nome = $( this ).data( 'nome' );
                var alerta = $('.alerta');
                alerta.empty();
                $('span.dsitem').text( nome );
                $('#delete').modal('show');
                $('.btn-yes').on('click', function () {
                    //console.log( "Remover" );
                    $.ajax({
                        url : 'funcao/tipo.php',
                        type: 'post',
                        dataType : 'json',
                        data : {
                            acao : 'G',
                            codigo : id
                        },
                        success : function (data) {
                            //    console.log( 'Remover: '+data );
                            if( data == true ){
                                var alerta = $('.alerta');
                                alerta.empty().html( '<p class="alert alert-success">Item removido com sucesso</p>' ).fadeIn();
                                setTimeout( function () {
                                    $('#delete').modal('hide');
                                    tabela();
                                },3000 );
                            }
                        }
                    });
                });

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

$('.btn-novo').on('click',function () {
    console.log( 'Click' );
    var form = $('<form action="tipocad.php" method="post">' +
        '</form>');
    $('body').append( form );
    form.submit();
});
