/**
 * Created by carlos.bruno on 29/06/2017.
 */

$(document).ready(function () {

    var selector = '.nav li';
    var url = window.location.href;
    var target = url.split('/');

    $(selector).each(function(){
        var urlAtual = target[target.length-1].split('#');
       // console.log(  $(this).find('a').attr('href')+" - "+ urlAtual[0]);
        if($(this).find('a').attr('href')===urlAtual[0]){
       // if($(this).find('a').attr('href')===($(this).find('a').attr('href'))){

            $(selector).removeClass('current');
            $(this).addClass('current');
        }
    });
});


function loadTotalMenu( usuario, funcion ) {
    verificaPermissao( usuario );
    setTimeout(function () {
        carregarTotalRecebimentos();
        carregarTotalMeusChamados( usuario );
        carregarTotalMeusServicos( funcion );
        atualizarSaudacao();

    }, 100);





}

function atualizarSaudacao() {
    var data = new Date();
    var hora = data.getHours();

    var msg = "";
    if( hora > 0 && hora < 12 ){
        msg = "Bom dia, ";
    }else
    if( hora >= 12 ){
        msg = "Boa tarde, ";
    }else if( hora > 18 ){
        msg = "Boa noite, ";
    }

    $('span.saudacao').text( msg );
    
}

function verificaPermissao( usuario ) {

    $.ajax({
        url : 'funcao/usuario.php',
        type: 'post',
        dataType: 'json',
        data : {
            usuario : usuario,
            acao    : 'P'
        },
        success : function (data) {

            
            $('ul.permissao').find('li').remove();
            $('ul.permissao').append( usuarioSistema( data.permissao ) );


            var selector = '.nav li';
            var url = window.location.href;
            var target = url.split('/');

            $(selector).each(function(){
                var urlAtual = target[target.length-1].split('#');
                // console.log(  $(this).find('a').attr('href')+" - "+ urlAtual[0]);
                if($(this).find('a').attr('href')===urlAtual[0]){
                    // if($(this).find('a').attr('href')===($(this).find('a').attr('href'))){

                    $(selector).removeClass('current');
                    $(this).addClass('current');
                }
            });
            
        }
    });
}


function usuarioSistema( sistema ) {
    var menu;
    if( sistema > 0 ){
        menu = "<li>" +
            "          <a href='solicitar.php'>" +
            "              <i class='glyphicon glyphicon-record'></i>Solicitar" +
            "          </a>" +
            "       </li>" +
            "       <li class='rec'>" +
            "           <a href='recebimentos.php'>" +
            "               <i class='glyphicon glyphicon-pencil'></i>Recebimentos" +
            "               <span class='num total-recebimentos' ></span>" +
            "           </a>" +
            "       </li>" +
            "       <li>" +
            "           <a href='cadastro.php'>" +
            "              <i class='glyphicon glyphicon-edit'></i>Cadastrar Chamado" +
            "           </a>" +
            "       </li>" +
            "       <li class='my'>" +
            "          <a href='meus.php'>" +
            "             <i class='glyphicon glyphicon-tags' aria-hidden='true'></i>Meus Chamados" +
            "                  <span class='num total-chamados' ></span>" +
            "          </a>" +
            "       </li>" +
            "       <li class='serv'>" +
            "          <a href='servico.php'>" +
            "              <i class='glyphicon glyphicon-paperclip'></i>Meus Servicos" +
            "              <span class='num total-servicos' ></span>" +
            "           </a>" +
            "       </li>";
    }else{
        menu = '<li><a href="solicitar.php"><i class="glyphicon glyphicon-record"></i>Solicitar</a></li>';
    }



    return menu;

}




function carregarTotalRecebimentos() {

    var total = $('span.total-recebimentos');

    total.text('');

    $.ajax({
        url  : 'funcao/os.php',
        type : 'post',
        dataType: 'json',
        data : {
            acao : 'P'
        },
        success : function (data) {
            var qtde = data.aguardando ;
            if( qtde > 0 ){
                $('.rec').addClass( 'noti' );
                total.text( qtde );
            }else{
                $('.rec').removeClass( 'noti' );

            }

        }
    });

}



function carregarTotalMeusChamados( usuario ) {

    var total = $('span.total-chamados');

    //console.log("Usuario Menus: "+usuario);

    total.text('');

    $.ajax({
        url  : 'funcao/os.php',
        type : 'post',
        dataType: 'json',
        data : {
            acao : 'H',
            responsavel : usuario
        },
        success : function (data) {

            var qtde = data.meuschamados ;
            if( qtde > 0 ){
                $('.my').addClass( 'noti' );
                total.text( qtde );
            }else{
                $('.my').removeClass( 'noti' );

            }
        }
    });

}


function carregarTotalMeusServicos( usuario ) {

    var total = $('span.total-servicos');

    total.text('');

    $.ajax({
        url: 'funcao/os.php',
        type: 'post',
        dataType: 'json',
        data: {
            acao: 'G',
            responsavel: usuario
        },
        success: function (data) {
           // total.text(data);
            var qtde = data.meuservicos ;
            if( qtde > 0 ){
                $('.serv').addClass( 'noti' );
                total.text( qtde );
            }else{
                $('.serv').removeClass( 'noti' );

            }

        }
    });
}