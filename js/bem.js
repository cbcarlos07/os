/**
 * Created by carlos.bruno on 06/07/2017.
 */

$( document ).ready( function () {
  tabela();
  comboBoxItem();
  comboBoxUsuario();
  comboBoxSetor();
  comboBoxLocalidade( '%' );
  loadTotal();
} );
$('#setor').on('change', function () {
    comboBoxLocalidade( $( this ).val() );
    tabela();
});

$('#proprietario').on('change', function () {
    tabela();
});

$('#localidade').on('change', function () {
   tabela();
});

$('#item').on('change', function () {
    tabela();
});

$('.btn-novo').on('click',function () {
    console.log( 'Click' );
    var form = $('<form action="cadastrobem.php" method="post">' +
                '</form>');
    $('body').append( form );
    form.submit();
});



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

function comboBoxItem() {
    $.ajax({
        url : 'funcao/bem.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'F'
        },
        success : function ( data ) {
            var corpo = "<option value='%'></option>";
            $.each( data, function ( i, j ) {
                corpo += "<option value='"+j.cd_bem+"'>"+j.ds_item+"</option>";
            } );

            var combo = $('#item');
            combo.find('option').remove();
            combo.append( corpo );
            combo.trigger( "chosen:updated" );


        }
    });
}



function comboBoxUsuario(  ) {

    $.ajax({
        url : 'funcao/fornecedor.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'H'
        },
        success : function (data) {
            var option = "<option value='%'></option>";
            // console.log( data );
            $.each( data, function ( i, j ) {
                //console.log( j.usuario );
                option += "<option value='"+j.cd_fornecedor+"'>"+j.nm_fantasia+"</option>";
            } );
            var combo = $('#proprietario');
            combo.find('option').remove();
            combo.append( option );
            combo.trigger( 'chosen:updated' );
        }
    });
}


function comboBoxSetor() {
    $.ajax({
        url : 'funcao/setor.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'S'
        },
        success : function (data) {
            var option = "<option value='%'></option>";
            //   console.log( data );
            $.each( data.setor, function ( i, j ) {
                //console.log( j.nmsetor );
                option += "<option value='"+j.codsetor+"'>"+j.nmsetor+"</option>";
            } );
            var combo = $('#setor');
            combo.find('option').remove();
            combo.append( option );
            combo.trigger( 'chosen:updated' );

        }
    });
}

function comboBoxLocalidade( setor ) {

    $.ajax({
        url : 'funcao/localidade.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'A',
            setor : setor
        },
        success : function (data) {
            var option = "<option value='%'></option>";
            //  console.log( data );
            $.each( data, function ( i, j ) {
                //  console.log( j.cd_localidade );
                // console.log( j.ds_localidade );
                option += "<option value='"+j.cd_localidade+"'>"+j.ds_localidade+"</option>";
            } );
            if( $('#acao').val() == 'C' ){
                if( typeof data[0].nm_responsavel == 'undefined'){
                    location.reload();
                }
            }
            $('#responsavel').val( data[0].nm_responsavel );
            var combo = $('#localidade');
            combo.find('option').remove();
            combo.append( option );
            combo.trigger( 'chosen:updated' );
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

