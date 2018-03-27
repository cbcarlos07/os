
$( document ).ready(function () {
    if( $('#codigo').val() > 0 ){
        getTipo();
    }
});


$('.btn-salvar').on('click', function () {
     var item = $('#item');

     if( item.val() == "" ){
         $('.item').addClass( 'has-error' );
         $('span.error').text('Preencha esse campo');
     }else{
         salvar();
     }
});

$('#item').on('input', function () {
    $('.item').removeClass( 'has-error' );
    $('span.error').text('');
});


function getTipo() {
    var id = $('#codigo').val();
    console.log( 'Codigo: '+id );
    $.ajax({
        url  : 'funcao/tipo.php',
        type : 'post',
        dataType :'json',
        data :{
            acao   : 'E',
            codigo : id
        },
        success : function (data) {

            $('#item').val( data[0].ds_tipo_equipamento );
        }
    });
}


function salvar() {
    var acao = $('#acao').val();
    var desc = $('#item').val();
    var codigo = $('#codigo').val();

    $.ajax({
        url  : 'funcao/tipo.php',
        type : 'post',
        dataType: 'json',
        data : {
            acao   : acao,
            item   : desc,
            codigo : codigo
        },
        beforeSend : aguardando,
        success : function ( data ) {
            if( data.retorno == true ){
                sucessoChamado();
            }
        }

    });

}


function aguardando() {
    $('.loading').fadeIn();
}


function sucessoChamado() {
    $('.loading').fadeOut();
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-success">Opera&ccedil;&atilde;o realizada com sucesso</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
        location.href = "tipo.php";
    },2000);
}

function msgErro( msg ) {
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-danger">'+msg+'</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
    },2000);
}