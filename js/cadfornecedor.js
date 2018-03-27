
$( document ).ready( function () {

    getSetor( 0 );

    if( $( '#acao' ).val() == 'C' ){
        getDados();
    }
    loadTotal();
} );

function getDados() {
    var codigo = $('#cd_fornecedor').val();
    $.ajax({
        url   : 'funcao/fornecedor.php',
        type  : 'post',
        dataType : 'json',
        data : {
            acao       : 'E',
            fornecedor : codigo
        },
        success : function ( data ) {
          //  console.log( data );

            getSetor( codigo );

            $('#sigla').val( data[0].ds_sigla );
           // console.log( data[0].sn_ativo );
            if( data[0].sn_ativo === 'S' ){
                $('#ativo').prop( 'checked', true );
                //console.log("É pra checar");
            }


        }
    });
}

function loadTotal(  ) {
    console.log( "Usuario: "+$('#usuario').val() )
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    loadTotalMenu( usuario, funcion );

    setTimeout( function(){
        loadTotal();
    },30000 );
}

$('#fornecedor').on('change ', function () {
    //console.log( $('#fornecedor option:selected').text() );
    getSigla();
});

function getSigla() {
    $('#sigla').val( ( titleize( $('#fornecedor option:selected').text()) ) );
}

function titleize(text) {
    var words = text.split(" ");
    for (var a = 0; a < words.length; a++) {
        var w = words[a];
        //words[a] = w[0].toUpperCase() + w.slice(1);
        words[a] = w[0];
    }
    return words.join("");
}

$('.btn-salvar').on('click', function () {
    salvar();
});

function salvar() {

    var fornecedor   = $('#fornecedor').val();
    var sigla        = $('#sigla').val();
    var checkbox     = $('#ativo');
    var acao         = $('#acao').val();
    var ativo = "N";
    if( checkbox.is(':checked') ){
        ativo = "S";
    }

    $.ajax({
        url   : 'funcao/fornecedor.php',
        dataType : 'json',
        type : 'post',
        beforeSend : waiting,
        data : {
            acao       : acao,
            fornecedor : fornecedor,
            sigla      : sigla,
            ativo      : ativo
        }, 
        success : function ( data ) {
            //console.log( data );
            if( data.retorno === true ){
                sucesso();
            }else{
                error();
            }
        }
    });
}

function sucesso() {
    var alerta = $('.alerta');
    alerta.empty().html("<p class='alert alert-success'><strong>Muito bem.</strong> Operação efetuada com sucesso!</p>").fadeIn();
    setTimeout(function () {
         location.href = "fornecedor.php";
    }, 2000)
}

function waiting() {
    var alerta = $('.alerta');
    alerta.empty().html("<p class='alert alert-warning'><strong>Aguarde.</strong> Enquanto processamos a informação!</p>").fadeIn();

}


function error() {
    var alerta = $('.alerta');
    alerta.empty().html("<p class='alert alert-danger'><strong>Opa.</strong> Ocorreu um erro ao processar dados!</p>").fadeIn();

}
function getSetor( setor ) {
    console.log( "Setor" );
    $.ajax({
        url : 'funcao/fornecedor.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'D'
        },
        success : function ( data ) {
            var option = "";
              // console.log( data );
            $.each( data, function ( i, j ) {
               // console.log( j.nm_fornecedor );
                option += "<option value='"+j.cd_fornecedor+"'>"+j.nm_fornecedor+"</option>";
            } );
            var combo = $('#fornecedor');
            combo.find('option').remove();
            combo.append( option );
            combo.val( setor ).trigger( 'chosen:updated' );
            if( $('#sigla').val() == "" ){
                getSigla();
            }


        }
    });
}