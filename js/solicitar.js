/**
 * Created by carlos.bruno on 07/07/2017.
 */

$(document).ready(function () {

  var usuario = document.getElementById('usuario').value;

  $('#descricao').focus();
  carregarComboSolcitante();
  carregarComboSetor();
 // buscarLastSolicitante( $('#solicitante').chosen().val() );
  carregarTabela( usuario );
  carregarTemplates( usuario );
  startCountdown();
  buscarLastSolicitante( usuario );




});


$('.btn-salvar').on('click', function () {
    var solicitante;
    var descricao;
    var observacao;


    if(enviar){
        var codigo      = $('#cdos').val();
        var ramal       = $('#ramal').val();
        solicitante     = $('#solicitante').val();
        var setor       = $('#setor').val();
        descricao       = $('#descricao').val();
        observacao      = $('#observacao').val();
        var usuario     = $('#usuario').val();
        var acao;
        if( codigo > 0 ){
            acao = 'U';
        }else {
            acao = 'N';
        }

        $.ajax({
            type   : 'post',
            url    : 'funcao/os.php',
            dataType : 'json',
            beforeSend : aguardar,
            data : {
                acao        : acao,
                cdos        : codigo,
                solicitante : solicitante,
                setor       : setor,
                descricao   : descricao,
                observacao  : observacao,
                usuario     : usuario,
                ramal       : ramal
            },
            success: function (data) {
            //    console.log('Retorno: '+data.sucesso);
                if( data.sucesso == 1 ){

                    $('.linear-progress-material').fadeOut(3000);
                    mensagemSucesso();
               //     console.log('Salvo');
                    $('#tabela').fadeOut(3000);
                    carregarTabela( usuario );
                    limparCampos();


                }
            }
        })

        return false;
    }else{

        var mensagem = $('.alerta');
        mensagem.empty().html('<p class="alert alert-warning">Preencha corretamente os campos</p>').fadeIn("fast");
        setTimeout(function (){
            mensagem.fadeOut();
        },2000);
        solicitante     = $('#solicitante').val();
        descricao       = $('#descricao').val();
        observacao      = $('#observacao').val();
        setor           = $('#setor').val();

        if( ( solicitante.trim() == "") || (descricao.trim() == "") || ( observacao.trim() == "" ) || ( setor == 0 ) ){
            if( solicitante.trim() == ""){
                $('input[id="solicitante"]').css('border-color','red');
            }
             if( descricao.trim() == ""){
                $('input[id="descricao"]').css('border-color','red');
            }
            if( observacao.trim() == "" ){
                $('textarea[id="observacao"]').css('border-color','red');
            }

            if( setor == 0 ){
                $('select[id="setor"]').css('border-color','red');
            }

        }
    }



});



function aguardar() {
    $('.linear-progress-material').fadeIn();
}

function mensagemSucesso() {
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-success">Opera&ccedil;&atilde;o realizada com sucesso</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
        $('.btn-salvar').removeClass('btn-primary');
        $('.btn-salvar').addClass('btn-danger');

        carregarTemplates( $('#usuario').val() );
    },2000);
}

function carregarComboSolcitante(  ){
    //console.log("Usuario: "+$('#usuario').val());
    $.ajax({
        url      : 'funcao/usuario.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao   : 'U'
        },
        success : function (data) {
            var op = $("<option>").val(0).text('Selecione');
            $('#solicitante').append(op);
            // console.log(data);
            $.each( data.usuarios, function (key, value) {

                var option  = $('<option>').val( value.usuario ).text( value.nome ) ;

                $('#solicitante').append(option);

            } );
            $('#solicitante').val( $('#usuario').val() ).trigger("chosen:updated");
            //$('#solicitante').trigger("chosen:updated");
           // buscarLastSolicitante( $('#solicitante').val() );


        }

    });

}
function carregarComboSetor(  ){
    //  console.log("IdSetor: "+idSetor);
      $.ajax({
          url      : 'funcao/setor.php',
          type     : 'post',
          dataType : 'json',
          data : {
            acao : 'S'
          },
          success : function (data) {

              var op = "<option value='0'>Selecione um setor</option>";
              $('#setor').append(op);

              $.each( data.setor, function (key, value) {

                      option = "<option value='"+ value.codsetor +"'>"
                               + value.nmsetor
                               +"</option> ";

                 $('#setor').append(option);

              } );

              $('#setor').trigger("chosen:updated");

             //  console.log(" CD Setor carregar: "+idSetor);


          }

      });

}
var linhas = "";

function carregarTemplates( usuario ) {
    var tabela_templates = $('.tabela-template');
    tabela_templates.fadeOut( 'slow' );
    tabela_templates.find('tr').remove();
    $.ajax({
        url   : 'funcao/template.php',
        type  : 'post',
        dataType : 'json',
        data : {
            usuario : usuario,
            inicio  : 0,
            fim     : 15,
            acao    : 'L'
        },
        success : function (data) {

            $.each( data.templates, function (i, j) {
                  tabela_templates.append(
                      "<tr class='line-template'>" +
                          "<td><a href='#titulo' onclick='carregarTemplateNosCampos(" + j.codigo + ")'>"+ j.titulo +"</a></td>"+
                          "<td class='td-remove'> <a href='#excluir'  title='Salvar exemplo' onclick='removerExemplo( " + j.codigo + ", \""+ j.titulo +"\" ) '><i class='fa fa-times'></i></a></td>"+
                      "</tr>"
                  );
            } )

            tabela_templates.fadeIn( 'slow' );

        }

    });
}

    function removerExemplo( codigo, titulo ) {
        $('span.texto-remover').html('<b>' + titulo + '</b>');
        $('.modal-remover').modal('show');
        $('.btn-sim').on('click', function () {
            $.ajax({
                url   : 'funcao/template.php',
                type  : 'post',
                dataType : 'json',
                data :{
                    codigo : codigo,
                    acao   : 'E'
                },
                success: function (data) {
                    if( data.retorno == 1){
                        $('.modal-remover').modal('hide');
                        mensagemSucesso();

                    }else{
                        msgErro();
                    }
                }
            });
        });
    }


function msgErro() {
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-danger">Ocorreu um erro ao realizar opera&ccedil;&atilde;o</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
    },2000);
}


function carregarTemplateNosCampos( codigo ) {
        $.ajax({
            url    : 'funcao/template.php',
            dataType : 'json',
            type   : 'post',
            data   : {
                acao : 'T',
                codigo : codigo
            },
            success : function (data) {
                $('#setor').val( data.setor );
                $('#descricao').val( data.descricao );
                $('#observacao').val( data.observacao );
                $('#titulo-template').val( data.titulo );
                $('#cdtemplate').val( data.codigo );
                verificarCampo();


            }
        });
    }


$('.btn-salvar').on('click',function(){
   // alert('Salvo');
    $('#modal-texto').modal('hide');
});


$('.btn-template').on('click', function () {
    if( enviar ){

        $('.modal-template').modal('show');
        $('.btn-salvar-template').on('click', function () {
            salvarTemplate();
        })


    }else{

        var mensagem = $('.alerta');
        mensagem.empty().html('<p class="alert alert-warning">Preencha corretamente os campos</p>').fadeIn("fast");
        setTimeout(function (){
            mensagem.fadeOut();
        },2000);
        solicitante     = $('#solicitante').val();
        descricao       = $('#descricao').val();
        observacao      = $('#observacao').val();
        setor           = $('#setor').val();

        if( ( solicitante.trim() == "") || (descricao.trim() == "") || ( observacao.trim() == "" ) || ( setor == 0 ) ){
            if( solicitante.trim() == ""){
                $('input[id="solicitante"]').css('border-color','red');
            }
            if( descricao.trim() == ""){
                $('input[id="descricao"]').css('border-color','red');
            }
            if( observacao.trim() == "" ){
                $('textarea[id="observacao"]').css('border-color','red');
            }

            if( setor == 0 ){
                $('select[id="setor"]').css('border-color','red');
            }

        }
    }
});

function salvarTemplate() {
    var codigo = $('#cdtemplate').val();
    var usuario = $('#usuario').val();
    var cdTemplate = 0;
    var acao = 'I';
    if( (codigo != "") || (codigo > 0) ){
        cdTemplate = codigo;
        acao = 'U';
    }
    
    $.ajax({
        url   : 'funcao/template.php',
        dataType : 'json',
        type  : 'post',
        beforeSend : aguardandoProcessamento,
        data : {
            codigo    : cdTemplate,
            usuario   : usuario,
            setor     : $('#setor').val(),
            servico   : $('#descricao').val(),
            observacao : $('#observacao').val(),
            titulo     : $('#titulo-template').val(),
            acao      : acao
        },
        success : function (data) {
            if( data.retorno == 1 ){
                sucessoModal();
                $('.load-modal').fadeOut();
                codigo = "";
                carregarTemplates( usuario );


            }else{
                msgErroModal('Ocorreu um problema ao salvar');
            }
        }
    });
}

function aguardandoProcessamento() {
    $('.load-modal').fadeIn();
}


function carregarTabela ( usuario ) {
    $('#tabela').fadeOut('slow');
    $('.tbody').find('tr').remove();


    $.ajax({
        url  : 'funcao/os.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao    : 'L',
            usuario : usuario,
            inicio  : 0,
            fim     : 6
        },
        success : function (data) {

            //$('.tbody').find('tr').remove();
            $('#tabela').fadeIn(3000);


            $.each(data.chamados, function (key, value) {

                linhas = "<tr class='linha'>"
                            +"<td>" + value.cdos + "</td>"
                            +"<td>" + value.setor + "</td>"
                            +"<td>" + value.descricao + "</td>"
                            +"<td>" + value.pedido + "</td>"
                            +"<td>" + value.situacao + "</td>"
                           // +"<td><a href='#editar' title='Clique para editar' class='btn-lg' onclick='editar("+value.cdos+")'><i class='fa fa-pencil-square-o'></i></a></td>"
                            +"<td><a href='#servicos' title='Clique para visualizar' class='btn-lg' onclick='ver("+value.cdos+")'><i class='fa fa-eye'></i></a></td>"
                        +"</tr>";
                $('.tbody').append(linhas);
            });



            function verificarCampo() {

                var solicitante = document.getElementById('solicitante').value;
                var descricao   = document.getElementById('descricao').value;
                var observacao  = document.getElementById('observacao').value;

                if( ( solicitante.trim() != "") && (descricao.trim() != "")&& ( observacao.trim() != "" ) ){

                    $('.btn-salvar').removeClass('btn-danger');
                    $('.btn-salvar').addClass('btn-primary');
                    enviar = true;

                }

            }
/*
var codigoSetor = 0;
            $(".linha").on('click',function(e) {

                if (e.target.classList.contains('c1'))
                    console.log("Classe: ");

                var tableData = $(this).children("td").map(function()         {
                    return $(this).text();
                }).get();
                //console.log("Clique: "+$.trim(tableData[0]));
               var codigoOs =  $.trim(tableData[0]) ;

               $.ajax({
                  url   : 'funcao/os.php',
                  type  : 'post',
                  dataType : 'json',
                  data  : {
                      acao : 'O',
                      cdos : codigoOs
                  },

                   success : function (data) {
                      // console.log('Setor: '+data.nmsetor);
                       $('#cdos').val(codigoOs);
                       $('#descricao').val(data.descricao);
                       $('#observacao').val(data.observacao);


                       /!*option.find('option').remove();
                       option.append('<option  value="'+data.setor+'">' + data.nmsetor + '</option>');
                        *!/

                       $('#setor').val(data.setor);
                       verificarCampo();
                    /!*   $('#setor').removeAttr('selected');
                       $('#setor option[value='+data.setor+']').attr('selected','selected');*!/





                   }
               });

            });*/

        }

    });

}

function editar(codigoOs) {
    $.ajax({
        url   : 'funcao/os.php',
        type  : 'post',
        dataType : 'json',
        data  : {
            acao : 'O',
            cdos : codigoOs
        },

        success : function (data) {
            // console.log('Setor: '+data.nmsetor);
            $('#cdos').val(codigoOs);
            $('#descricao').val(data.descricao);
            $('#observacao').val(data.observacao);


            $('#setor').val(data.setor);
            verificarCampo();

        }
    });

}


var eachRow = "";
function ver( codos ) {
    $('#descos').val("");
    $('#obs').val("");
    $('#nmusuario').val(0);
    $('#status').val(0);

    var tbody = $('#tbody-serv');
    tbody.find('tr').remove();
    var nao = "";
    $.ajax({
        type : 'post',
        dataType: 'json',
        url  : 'funcao/os.php',
        data : {
            acao : 'O',
            cdos : codos
        },
        success : function (data) {

            $('#descos').val(data.descricao);
            $('#obs').val(data.observacao);
            $('#nmusuario').val(data.atendente);
            $('#status').val(data.status);

            $.each(data.servicos, function (key, value) {
                     nao = value.nao;
                     eachRow = "<tr>"
                                 +"<td>" + value.usuario + "</td>"
                                 +"<td>" + value.servico + "</td>"
                                 +"<td>" + value.data + "</td>"
                             +"</tr>"
                tbody.append(eachRow);


              //  console.log(nao);
            });


            $('#tela-ordem').modal('show');
        }
    });



}


function sucessoModal() {
    var mensagem = $('.alerta-modal');
    mensagem.empty().html('<p class="alert alert-success">Opera&ccedil;&atilde;o realizada com sucesso</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
        $('.modal-template').modal('hide');
    },3000);
}

function msgAvisoModal( msg ) {
    var mensagem = $('.alerta-modal');
    mensagem.empty().html('<p class="alert alert-warning">'+msg+'</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
    },2000);
}


function msgErroModal( msg ) {
    var mensagem = $('.alerta-modal');
    mensagem.empty().html('<p class="alert alert-danger">'+msg+'</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
    },2000);
}

/*$('#tela-ordem').on('hide.bs.modal', function (event) {
    location.reload();
});*/

$('.btn-limpar').on('click', function () {
   limparCampos();

});

function limparCampos() {
    $('#cdos').val("");
    $('#descricao').val("");
    $('#observacao').val("");
    var cdsetor = document.getElementById('cdsetor').value;
    carregarComboSetor( cdsetor );
    enviar = false;
    $('input[id="solicitante"]').css("border-color","");
    $('input[id="descricao"]').css("border-color","");
    $('textarea[id="observacao"]').css("border-color","");
    $('select[id="setor"]').css("border-color","");
    setTimeout(function () {
        $('.btn-salvar').removeClass('btn-primary');
        $('.btn-salvar').addClass('btn-danger');
    }, 3000);



}
function buscarLastSolicitante( usuario ) {
   // var solicitante = $('#usuario').val();
    //var solicitante = $('#solicitante').val();

    console.log("Solicitante: "+usuario);
    $('#usuario').val( usuario );
    carregarTabela( usuario );
    var cdsetor = 0;
    $.ajax({
        url   : 'funcao/os.php',
        dataType : 'json',
        type : 'post',
        data : {
            acao : 'D',
            solicitante : usuario
        },
        success : function (data) {

            cdsetor =  data.cdsetor ;
            $('#setor').val( cdsetor ).trigger("chosen:updated");


           // console.log("Buscar last setor: "+cdsetor);

           // carregarComboSetor( cdsetor );

        }
    });

    return cdsetor;

}


function startCountdown(){

    setTimeout(function () {
        var usuario = document.getElementById('usuario').value;
        carregarTabela( usuario );
        startCountdown()
    }, 30000);


}


$('#solicitante').on('change', function () {
      var value = $(this).chosen().val();
      console.log( "Mudou: "+value );
      buscarLastSolicitante( $(this).val() );
});


