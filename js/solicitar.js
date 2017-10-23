/**
 * Created by carlos.bruno on 07/07/2017.
 */
var enviar = false;
$(document).ready(function () {

  var usuario = document.getElementById('usuario').value;
    verificarInformAdd();
  $('#descricao').focus();
  carregarComboSolcitante();
  carregarComboSetor();
 // buscarLastSolicitante( $('#solicitante').chosen().val() );
 // carregarTabela( usuario );
  carregarTemplates(  );
  startCountdown();
  buscarLastSolicitante( usuario );
   loadTotal();




});



function loadTotal(  ) {
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    loadTotalMenu( usuario, funcion );

    setTimeout( function(){
        loadTotal();
    },30000 );

}


$('.btn-salvar').on('click', function () {
    var solicitante;
    var descricao;
    var observacao;


    if(enviar){
        var usuario = "";
        var codigo      = $('#cdos').val();
        var ramal       = $('#ramal').val();
        solicitante     = $('#solicitante').val();
        var setor       = $('#setor').val();
        descricao       = $('#descricao').val();
        observacao      = $('#observacao').val();
        usuario         = $('#usuario').val();
        var acao;
        if( codigo > 0 ){
            acao = 'U';
        }else {
            acao = 'N';
        }

       // console.log("Solicitante: "+solicitante);
       // console.log("usuario: "+usuario);

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
                    loadTotal();



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

function mensagemSucessoModal() {
    var mensagem = $('.alerta-modal');
    mensagem.empty().html('<p class="alert alert-success">Opera&ccedil;&atilde;o realizada com sucesso</p>').fadeIn("fast");
    setTimeout(function (){
        $('#addInf').modal('hide');
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
            /*var op = $("<option>").val(0).text('Selecione');
            $('#solicitante').append(op); */
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

              /*var op = "<option value='0'>Selecione um setor</option>";
              $('#setor').append(op);*/

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

function carregarTemplates(  ) {
    var tabela_templates = $('.tabela-template');
    tabela_templates.fadeOut( 'slow' );
    tabela_templates.find('tr').remove();
    $.ajax({
        url   : 'funcao/template.php',
        type  : 'post',
        dataType : 'json',
        data : {
            acao    : 'L'
        },
        success : function (data) {
            //console.log( data );
            $.each( data.templates, function (i, j) {
                  tabela_templates.append(
                      "<tr class='line-template'>" +
                          "<td><a href='#titulo' onclick='carregarTemplateNosCampos(" + j.codigo + ")'>"+ j.titulo +"</a></td>"+
                          //"<td class='td-remove'> <a href='#excluir'  title='Salvar exemplo' onclick='removerExemplo( " + j.codigo + ", \""+ j.titulo +"\" ) '><i class='fa fa-times'></i></a></td>"+
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


$('#descricao').on('input', function () {
    verificarCampo();
    if( $(this).val().length > 0 ){
        $(this).css( 'border-color', '' );
    }
});

$('#observacao').on('input', function () {
    verificarCampo();
    if( $(this).val().length > 0 ){
        $(this).css( 'border-color', '' );
    }
});


function carregarTemplateNosCampos( codigo ) {
     //  console.log("Codigo: "+codigo);
        $.ajax({
            url    : 'funcao/template.php',
            dataType : 'json',
            type   : 'post',
            data   : {
                acao : 'T',
                codigo : codigo
            },
            success : function (data) {
                $('#descricao').val( data.descricao );
                $('#observacao').val( data.observacao.replace(new RegExp('<br />', 'g'), ' ') );
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
    //$('#tabela').fadeOut('slow');

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
          //  $('#tabela').fadeIn(3000);


            $.each(data.chamados, function (key, value) {
                var cor = "";
                //console.log("Chamado: "+value.cdos+" - Status: "+value.status);
                if( value.status == 'C' ){
                    cor = "#E0F7FA";
                 //   console.log("Cor verde");

                }
                var lines;
                if( value.status == 'C' ){
                    lines = "<tr class='linha' bgcolor='"+ cor +"'>"
                        +"<td>" + value.cdos + "</td>"
                        +"<td>" + value.setor + "</td>"
                        +"<td>" + value.descricao + "</td>"
                        +"<td>" + value.pedido + "</td>"
                        +"<td>" + value.situacao + "</td>"
                        // +"<td><a href='#editar' title='Clique para editar' class='btn-lg' onclick='editar("+value.cdos+")'><i class='fa fa-pencil-square-o'></i></a></td>"
                        +"<td><a href='#servicos' title='Clique para visualizar' class='btn-lg' onclick='ver("+value.cdos+")'><i class='fa fa-eye'></i></a></td>"
                        +"</tr>";
                }else{
                    lines = "<tr class='linha' >"
                        +"<td>" + value.cdos + "</td>"
                        +"<td>" + value.setor + "</td>"
                        +"<td>" + value.descricao + "</td>"
                        +"<td>" + value.pedido + "</td>"
                        +"<td>" + value.situacao + "</td>"
                        // +"<td><a href='#editar' title='Clique para editar' class='btn-lg' onclick='editar("+value.cdos+")'><i class='fa fa-pencil-square-o'></i></a></td>"
                        +"<td><a href='#servicos' title='Clique para visualizar' class='btn-lg' onclick='ver("+value.cdos+")'><i class='fa fa-eye'></i></a></td>"
                        +"</tr>";
                }


                $('.tbody').append(lines);
            });




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
function verificarCampo() {

    var solicitante = $('#solicitante').val();
    var descricao   = $('#descricao').val();
    var observacao  = document.getElementById('observacao').value;
//    console.log("verificarCampo ");
 //   console.log("Solicitante: "+solicitante);
    if( ( solicitante != "") && (descricao.trim() != "")&& ( observacao.trim() != "" ) ){

        $('.btn-salvar').removeClass('btn-danger');
        $('.btn-salvar').addClass('btn-primary');
        enviar = true;

    }else{
        $('.btn-salvar').removeClass('btn-primary');
        $('.btn-salvar').addClass('btn-danger');
        enviar = false;
    }

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


$('')


var eachRow = "";
function ver( codos ) {
    $('#codOs').val( "" );
    $('#descos').val("");
    $('#obs').val("");
    $('#nmusuario').val(0);
    $('#status').val(0);

    var tbody = $('#tbody-serv');
    tbody.find('tr').remove();
    var tabelaInf = $('.table-inf');
    var theadInf = $('#theadInf');
    var tbodyInf = $('#tbodyInf');
    theadInf.find('th').remove();
    tbodyInf.find('tr').remove();
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
            $('#codOs').val( codos );
            $('#descos').val(data.descricao);
            $('#obs').val(data.observacao);
            $('#nmusuario').val(data.atendente);
            $('#status').val(data.status);

            $.each(data.servicos, function (key, value) {
                     var hide = value.descricao;
                     var enc = hide.indexOf("#HIDE#");
                    // console.log("Nao: "+nao);
                     if( enc != 0 ){
                         eachRow = "<tr>"
                             +"<td>" + value.usuario + "</td>"
                             +"<td>" + value.descricao + "</td>"
                             +"<td>" + value.data + "</td>"
                             +"</tr>";
                     }

                tbody.append(eachRow);
            });
          //  console.log(data.informacoes);
            if( data.informacoes != ""){
             //   console.log("Tipo de dado informaoces: "+ typeof data.informacoes );

                theadInf.append(

                    "<th>Usu&aacute;rio</th><th>Descri&ccedil;&atilde;o</th><th>Data</th>"
                );

                $.each( data.informacoes, function ( i, j ) {
                    tbodyInf.append(
                        "<tr>"+
                            "<td>"+ j.usuario +"</td>"+
                            "<td>"+ j.descricao +"</td>"+
                            "<td>"+ j.data +"</td>"+
                            "<td> <a href='#editar' class='btn-editar'  title='Clique para alterar informa&ccedil;&atilde;o' onclick='abrirTelaAlterarServico("+ j.codigo +")'><i class='fa fa-pencil-square-o'></i></a>"+
                        "</tr>"
                    );
                } );

            }

             tabelaInf.append( theadInf );
             tabelaInf.append( tbodyInf );

            $('#tela-ordem').modal('show');
        }
    });



}


function abrirTelaAlterarServico( cdServico ) {

    $.ajax({
        type    : 'post',
        dataType: 'json',
        url     : 'funcao/servico.php',
        data    : {
            acao   : 'I',
            codigo : cdServico
        },
        success : function (data) {

            $('#tempoHora').val( data.tempoHora );
            $('#tempoMinuto').val( data.tempoMinuto );
            $('#codigoItem').val( cdServico );
            $('#resp').val( data.funcionario );
            var hide = data.descricao;

            $('#servico').val( data.servico );

            $('#desc').val( hide.replace(new RegExp('<br />', 'g'), ' ') );

            $('#datai').val( data.inicio );
            $('#dataf').val( data.final );
            $('#total').val( data.tempo );

            $('#addInf').modal('show');
            verificarCampo();

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

  //  console.log("Solicitante: "+usuario);
  //  $('#usuario').val( usuario );
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
    //  console.log( "Mudou: "+value );
      buscarLastSolicitante( $(this).val() );
});



function salvarItem() {
    var codigoItem   =  $('#codigoItem').val();
    var horaFinal    =  $('#dataf').val();
    var horaInicio   =  $('#datai').val();
    var responsavel  =  $('#resp').val();
    var tempoHora    =  $('#tempoHora').val();
    var tempoMinuto  =  $('#tempoMinuto').val();
    var cdOs         =  $('#codOs').val();
    var servico      =  $('#servico').val();
    var descricao    =  $('#desc').val();
    var snfeito;//      =  document.getElementById('snfeito');
    //var snvisualiza      =  $('#snvisualiza');
    var feito        = "S";
    var acao         = "S";
    //var checado = "Sn Visualiza nao chegado";
    /*if( snvisualiza.is(':checked') ){
        descricao = "#HIDE#"+descricao;
        checado = "Sn Visualiza chegado";
    }*/
    // console.log( checado );
    //   console.log("Data Final: "+horaFinal);
    /*if( snfeito.checked ){
     feito = "S"
     }*/



    if( codigoItem > 0 ){
        acao = "U";
    }


    //  console.log("Feito: "+feito);
    //  console.log("Codigo do funcionario: "+responsavel);

    $.ajax({
        url  : 'funcao/servico.php',
        type : 'post',
        dataType : 'json',
        beforeSend : aguardandoProcessamento,
        data : {
            horaFinal   : horaFinal,
            horaInicio  : horaInicio,
            tempoHora   : tempoHora,
            cdOs        : cdOs,
            funcionario : responsavel,
            servico     : servico,
            descricao   : descricao,
            tempoMinuto : tempoMinuto,
            feito       : feito,
            codigo      : codigoItem,
            acao        : acao
        },
        success : function (data) {
            var retorno = data.retorno;
            if( retorno > 0 ){
                $('.load-modal').fadeOut('slow');
                mensagemSucessoModal();
                ver( cdOs );
                $('#codigoItem').val( retorno )

            }else{
                $('.load-modal').fadeOut('slow');
                msgErroModal('Ocorreu um erro ao realizar opera&ccedil;&atilde;o');
            }
        }
    })



}




$('.lnk-add-inf').on('click', function () {

    $('#addInf').modal('show');

    carregarDataHoraAtualServico();

});

$('.btn-add-inf').on('click', function () {
    salvarItem();
});

 $('#desc').on('input', function () {
     verificarInformAdd();
 });

 function verificarInformAdd() {

     var campo = $('#desc').val();
    // console.log("Campo descricao informacoes adicionais");
     var botaoAttr = $('.btn-add-inf');
     if( campo  == "" ){
     //    console.log("Campo descricao informacoes adicionais em branco");
         botaoAttr.removeClass("btn-primary");
         botaoAttr.addClass("btn-danger");
         botaoAttr.attr( "disabled",true );
     }else{
       //  console.log("Campo descricao informacoes adicionais não está em branco");
         botaoAttr.removeClass("btn-danger");
         botaoAttr.addClass("btn-primary");
         botaoAttr.attr( "disabled",false );
     }


 }

function calcularHoras () {

    try{
        var tempo = 0;
        var data1 = $('#datai').val().trim();
        //console.log("Data1; "+data1);
        var data2 = $('#dataf').val().trim();

        //console.log("Data inicio: '"+data1+"' Data fim: '"+data2+"'.");
        /** Transformando data hora inicial **/
        var dataHoraInicial = data1.split(' ');
        var dataInicioStr   =  dataHoraInicial[0].split('/');
        var diaI = dataInicioStr[0];
        //console.log("Dia inicial: "+diaI);
        var mesI = dataInicioStr[1];
        var anoI = dataInicioStr[2];
        var horaInicialStr  = dataHoraInicial[1].split(':');
        var horaI = horaInicialStr[0];
        var minI  = horaInicialStr[1];
        var dataInicial = new Date(anoI, mesI, diaI, horaI, minI);

        /** Transformando data hora final **/
        var dataHoraFinal = data2.split(' ');
        var dataFinalStr   =  dataHoraFinal[0].split('/');
        var diaf = dataFinalStr[0];
        var mesf = dataFinalStr[1];
        var anof = dataFinalStr[2];
        var horaFinalStr  = dataHoraFinal[1].split(':');
        var horaf = horaFinalStr[0];
        var minf  = horaFinalStr[1];
        var dataFinal = new Date(anof, mesf, diaf, horaf, minf);

        var diffMilissegundos  = dataFinal - dataInicial;
        tempo +=  diffMilissegundos;

        var diffSegundos = tempo / 1000;
        var diffMinutos = diffSegundos / 60;
        var diffHoras = Math.floor(diffMinutos / 60);
        var minutos = diffMinutos % 60;

        var horaStr = diffHoras;
        if( diffHoras < 10 ){
            horaStr =  "0"+diffHoras;
        }

        var minStr = minutos;
        if( minutos < 10 ){
            minStr = "0"+minutos;
        }

        var horas  = horaStr +":"+minStr;
        $( '#tempoHora ').val( horaStr );
        $( '#tempoMinuto' ).val( minStr );
        $( '#total' ).val( horas );
    }catch (err){
     //   console.log("Erro: "+err.message);
    }


}


        function carregarDataHoraAtualServico() {
            var agora = new Date();
            var options = { year: 'numeric', month: '2-digit', day: '2-digit' };
            var campoData = agora.toLocaleDateString("pt-BR", options)+' '+agora.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            var dataHoraInicial = campoData.split(' ');
            var dataInicioStr   =  dataHoraInicial[0].split('/');
            var diaI = dataInicioStr[0];
            var mesI = dataInicioStr[1];
            var anoI = dataInicioStr[2];
            var horaInicialStr  = dataHoraInicial[1].split(':');
            var horaI = horaInicialStr[0];
            var minI  = horaInicialStr[1];
            var minII = parseInt(minI)  + 1;
            // console.log("Minuto: "+minII);
            var dataFinal = new Date(anoI, mesI-1, diaI, horaI, minII);
            var campoDataF = dataFinal.toLocaleDateString("pt-BR", options)+' '+dataFinal.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            // console.log('Campo data: '+campoData);
            $('#datai').val(campoData);
            $('#dataf').val( campoDataF );
          //  $('#dataf').val( '' );

            calcularHoras();
        }


