
$( document ).ready( function () {
    var acao    = $('#acao').val();


     getSetor(  );
     getUsuario();

    if( acao == 'A' ){
        codigo();
    }else{
        getDados();
    }
    loadTotal();

} );

$('#proprietario').on('change', function () {
    getSigla();
});

function getSigla() {
    var fornecedor = $('#proprietario').val();
    $.ajax({
        url  : 'funcao/fornecedor.php',
        type : 'post',
        dataType: 'json',
        data : {
            acao       : 'E',
            fornecedor : fornecedor
        },
        success : function (data) {
            var patrimonio = $('#patrimonio');
            var cdPatrimonio = patrimonio.val().replace(/[^0-9]/g,'');;
            var sigla = data[0].ds_sigla;
            var codigo = sigla + cdPatrimonio;
            patrimonio.val( codigo );
        }
    });
}


function getDados() {

    var codigo  = $('#codigo').val();

        $.ajax({
            url : 'funcao/bem.php',
            type : 'post',
            dataType: 'json',
            data : {
                acao : 'E',
                codigo : codigo
            },
            success : function (data) {
                console.log(  data[0].cd_setor );
                $('#item').val( data[0].ds_item );
                $('#setor').val( data[0].cd_setor ).trigger( "chosen:updated" );
                getLocalidade( data[0].cd_localidade  );

               // console.log( "Proprietario: "+data[0].proprietario );
                $('#proprietario').val( data[0].proprietario ).trigger( "chosen:updated" );
                getUsuario( data[0].proprietario );
                $('#patrimonio').val( data[0].nr_patrimonio ).trigger( "chosen:updated" );


            }
        });

}

function getSetor() {
    $.ajax({
        url : 'funcao/setor.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'S'
        },
        success : function (data) {
            var option = "";
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

$('#setor').on('change', function () {
    getLocalidade(  );
   // console.log( 'Setor' );
});

function getLocalidade( local ) {
    var setor = $('#setor').val();
    $.ajax({
        url : 'funcao/localidade.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'A',
            setor : setor
        },
        success : function (data) {
            var option = "";
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
            combo.val( local ).trigger( 'chosen:updated' );
        }
    });
}


function sucessoChamado() {
    $('.loading').fadeOut();
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-success">Opera&ccedil;&atilde;o realizada com sucesso</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
       // codigo();
    },2000);
}

function msgErro( msg ) {
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-danger">'+msg+'</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
    },2000);
}


function getUsuario( usuario ) {

    $.ajax({
        url : 'funcao/fornecedor.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'H'
        },
        success : function (data) {
            var option = "";
            // console.log( data );
            $.each( data, function ( i, j ) {
                //console.log( j.usuario );
                option += "<option value='"+j.cd_fornecedor+"'>"+j.nm_fantasia+"</option>";
            } );
            var combo = $('#proprietario');
            combo.find('option').remove();
            combo.append( option );
            combo.val( usuario ).trigger( 'chosen:updated' );
        }
    });
}

$('.btn-salvar').on('click', function () {
    var codigo        = $('#codigo').val();
    var item          = $('#item').val();
    var setor         = $('#setor').val();
    var localidade    = $('#localidade').val();
    var proprietario  = $('#proprietario').val();
    var patrimonio    = $('#patrimonio').val();
    var acao          = $('#acao').val();
    //console.log( "Localidade: "+localidade );
    if( item == "" ){
        $('.item').addClass( 'has-error' );
    }else{
        $('.item').removeClass( 'has-error' );
        $.ajax({
            url      : 'funcao/bem.php',
            type     : 'post',
            dataType : 'json',
            beforeSend: aguardando,
            data :  {
                acao         : acao,
                codigo       : codigo,
                item         : item,
                setor        : setor,
                localidade   : localidade,
                proprietario : proprietario,
                patrimonio   : patrimonio
            },
            success : function ( data ) {
                console.log( data.retorno );
                if( data.retorno == true ){
                    sucessoChamado();
                    $('#acao').val( 'C' )
                }
            }
        });
    }



});

function aguardando() {
    $('.loading').fadeIn();
}

function codigo() {

    $.ajax({
        url : 'funcao/bem.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'B'
        },
        success : function ( data ) {
            console.log( data.CODIGO );
            $('#codigo').val( data.CODIGO );
            $('#patrimonio').val( data.PATRIMONIO );

        }

    });

}

$('.btn-cancelar').on('click', function () {
    $('.modal-cancel').modal('show');
});

$('.btn-sim').on('click', function () {
    window.location.href = "bem.php";
});


function loadTotal(  ) {
    console.log( "Usuario: "+$('#usuario').val() );
    console.log( "Funcionario: "+$('#funcionario').val() );
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    loadTotalMenu( usuario, funcion );

    setTimeout( function(){
        loadTotal();
    },30000 );
}
