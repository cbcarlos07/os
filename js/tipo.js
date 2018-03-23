



function tabela() {
    var localidade   = $('#localidade').val();
    var setor        = $('#setor').val();
    var proprietario = $('#proprietario').val();
    var item         = $('#item').val();
    $.ajax({
        url : 'funcao/bem.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'D',
            localidade   : localidade,
            setor        : setor,
            proprietario : proprietario,
            item         : item
        },
        success : function ( data ) {
            var tbody = $('.tbody');
            var corpo = "";
            $.each( data, function ( i, j ) {
                corpo += "<tr>" +
                    "<td>"+j.cd_bem+"</td>"+
                    "<td>"+j.ds_item+"</td>"+
                    "<td>"+j.nm_setor+"</td>"+
                    "<td>"+j.ds_localiade+"</td>"+
                    "<td>"+j.proprietario+"</td>"+
                    "<td> <a href='#' class='btn btn-success btn-alterar' data-id='"+ j.cd_bem +"'>Alterar</a> "+
                    " <a href='#' class='btn btn-danger btn-excluir' data-nome='"+j.ds_item+"' data-id='"+ j.cd_bem +"'>Excluir</a> </td>"+
                    "</tr>";
            } );



            tbody.find('tr').remove();
            tbody.append( corpo );

            pagingTable();

            $('.btn-alterar').on('click', function () {
                var id = $( this ).data('id');
                var form = $('<form action="alterarbem.php" method="post">' +
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
                        url : 'funcao/bem.php',
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
