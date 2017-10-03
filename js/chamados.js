/**
 * Created by carlos.bruno on 17/07/2017.
 */


var boolNovoServico = false;

$('.btn-salvar-servico').on('click', function () {

    if( boolServico ){
        salvarItem();
        $('select[id="resp"]').css("border-color","");
        $('select[id="servico"]').css("border-color","");
        $('input[id="datai"]').css("border-color","");

    }else{
        msgAviso('Verifique os campos que faltam ser preenchidos');
        var resp    = $('#resp').val();
        var servico = $('#servico').val();
        var datai   = $('#datai').val();
        if( ( resp == 0 ) || ( servico == 0 ) || ( datai == "" ) ){
            if( resp == 0 ){
                $('select[id="resp"]').css("border-color","red");
            }
            if( servico == 0 ){
                $('select[id="servico"]').css("border-color","red");
            }
            if( datai == "" ){
                $('input[id="datai"]').css("border-color","red");
            }
        }


    }

});


function salvarOs() {

    var cdOs         =  $('#cdos').val();
    var dataos       =  $('#dataos').val();
    var previsao     =  $('#previsao').val();
    var solicitante  =  $('#solicitante').val();
    var setor        =  $('#setor').val();
    var tipoos       =  $('#tipoos').val();
    var motivo       =  $('#motivo').val();
    var descricao    =  $('#descricao').val();
    var observacao   =  $('#observacao').val();
    var responsavel  =  $('#responsavel').val();
    var status       =  $('#status').val();
    var resolucao    =  $('#resolucao').val();
    var oficina      =  $('#oficina').val();

    console.log("Codigo da Os: "+cdOs);
    $.ajax({
       type      :  'post',
       dataType  :  'json',
       url       :  'funcao/os.php',
       beforeSend : aguardando,
       data      : {
           cdos    : cdOs,
           pedido   : dataos,
           previsao : previsao,
           solicitante : solicitante,
           setor       : setor,
           tipoos      : tipoos,
           motivo      : motivo,
           descricao   : descricao,
           observacao  : observacao,
           responsavel : responsavel,
           status      : status,
           resolucao   : resolucao,
           oficina     : oficina,
           acao        : 'C'
       },
        success : function (data) {
          // console.log("Retorno: "+data.sucesso);
            if( data.sucesso == 1 ){
                if( $('#responsavel').text() != "Selecione" ){
                    console.log("CarregarTotalRecebimentos");
                    carregarTotalRecebimentos();
                }
                $('.loading').fadeOut('slow');
                sucessoChamado();

            }else{
                $('.loading').fadeOut('slow');
                msgErro();
            }
        }
    });




}

$('#status').on('change', function () {
    var status = $(this).val();
    var codigo = $('#cdos').val();

    if( ( codigo > 0) || ( codigo != "" ) ){
        if( statusGlobal != 'C' ){
            if( status == 'C' ){



                $('span.titulo-modal-remover').html('Fechar chamado');
                $('p.msg-delete').html('Deseja realmente fechar o chamado <strong>' + codigo + '</strong> ?');
                $('.modal-fechar-chamado').modal('show');
                $('.btn-sim').on('click', function (){


                    atualizarStatus( status, codigo );
                });
            }
        }

    }else{
        msgAvisoChamado('Para alterar o status do chamado primeiro salve-o');
        $(this).val('A');

    }


});

var statusGlobal;
function setarValorComboStatus( status ) {
    statusGlobal =  status;
}
function atualizarStatus( situacao, cdos ) {
    $.ajax({
        url   : 'funcao/os.php',
        dataType: 'json',
        type: 'post',
        beforeSend : aguardando,
        data :{
            acao : 'B',
            status : situacao,
            cdos   : cdos
        },
        success: function ( data ) {
            loadTotal();
            console.log( "Chamado finalizado: "+data.retorno );
            if( data.retorno == 1 ){
                $('.loading').fadeOut();
                sucessoChamado();
                $('.modal-fechar-chamado').modal('hide');
            }else{
                msgErro('Ocorreu um erro na opera&ccedil;&atildeo');
            }

        }
    });

}

function loadTotal(  ) {
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    carregarTotalRecebimentos();
    carregarTotalMeusChamados( usuario );
    carregarTotalMeusServicos( funcion );
}

function salvarItem() {
    var codigoItem   =  $('#codigoItem').val();
    var horaFinal    =  $('#dataf').val();
    var horaInicio   =  $('#datai').val();
    var responsavel  =  $('#resp').val();
    var tempoHora    =  $('#tempoHora').val();
    var tempoMinuto  =  $('#tempoMinuto').val();
    var cdOs         =  $('#cdos').val();
    var servico      =  $('#servico').val();
    var descricao    =  $('#desc').val();
    var snfeito;//      =  document.getElementById('snfeito');
    var snvisualiza  =  $('#snvisualiza');
    var feito        = "N";
    var acao         = "S";
 //   console.log("Data Final: "+horaFinal);

    if( snvisualiza.is(':checked') ){
        descricao = "#HIDE#"+descricao;

    }

    if( horaFinal != "" ){
        feito = "S";
    }
/*

    if( snfeito.checked){
        feito = "S"
    }
*/

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
                loadTotal();
                $('.load-modal').fadeOut('slow');
                sucesso();
                preencherTabelaServicos();
                $('#codigoItem').val( retorno );
                salvarOs();

            }else{
                $('.load-modal').fadeOut('slow');
                msgErro();
            }
        }
    })



}

function aguardando() {
    $('.loading').fadeIn();
}


function aguardandoProcessamento() {
    $('.load-modal').fadeIn();
}

function sucessoChamado() {
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-success">Opera&ccedil;&atilde;o realizada com sucesso</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
    },2000);
}

function msgErro() {
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-danger">Ocorreu um erro ao realizar opera&ccedil;&atilde;o</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
    },2000);
}


    function sucesso() {
        var mensagem = $('.alerta-modal');
        mensagem.empty().html('<p class="alert alert-success">Opera&ccedil;&atilde;o realizada com sucesso</p>').fadeIn("fast");
        setTimeout(function (){
            mensagem.fadeOut();
        },2000);
    }

    function msgAviso( msg ) {
        var mensagem = $('.alerta-modal');
        mensagem.empty().html('<p class="alert alert-warning">'+msg+'</p>').fadeIn("fast");
        setTimeout(function (){
            mensagem.fadeOut();
        },2000);
    }

    function msgAvisoChamado() {
        var mensagem = $('.alerta');
        mensagem.empty().html('<p class="alert alert-warning">Verifique os campos que faltam ser preenchidos</p>').fadeIn("fast");
        setTimeout(function (){
            mensagem.fadeOut();
        },2000);
    }


    var boolServico = false;

    $('#resp').on('change', function () {
        verificarCampo();
    });


    $('#servico').on('change', function () {
        verificarCampo();
    });


    $('#datai').on('blur', function () {
        verificarCampo();
    });






    function verificarCampo() {
        var responsavel = $('#resp').val();
        var servico     = $('#servico').val();
        var data        = $('#datai').val();
        var dataf       = dataFinal.val();
        var btn = $('.btn-salvar-servico');
        if( (responsavel != 0) && ( servico != 0 ) && ( data != "" ) ){
            if( dataf == "" ) {
                boolServico = true;


                btn.removeAttr('disabled');
                btn.removeClass('btn-danger');
                btn.addClass('btn-success');
                btn.attr("title", "Pronto para salvar");
            }else if ( verificarData() ) {
                boolServico = true;


                btn.removeAttr('disabled');
                btn.removeClass('btn-danger');
                btn.addClass('btn-success');
                btn.attr("title", "Pronto para salvar");
            }else{
                msgAviso( 'Verique o campos a serem preenchidos' );
            }





        }else{



            btn.attr("title","Preencha todos campos obrigatorios");
            btn.attr('disabled');
            btn.removeClass('btn-success');
            btn.addClass('btn-danger');
            boolServico = false;
        }

        if( responsavel != 0){
         //   console.log("Responsavel: "+responsavel);
            $('select[id="resp"]').css('border-color',"");
        }
        if( servico != 0){
            $('select[id="servico"]').css('border-color',"");
        }
        if( data != 0){
            $('input[id="datai"]').css('border-color',"");
        }

        if( verificarData() ){
            $('input[id="descricao"]').css('border-color', '');
        }

    }


    $('#setor').on('change', function () {
        verificarCampoChamado();
    });

    $('#descricao').on('blur', function () {
       verificarCampoChamado();
    });

    $('#tipoos').on('change', function () {
        carregarComboMotivo( $(this).val() );
    });

    $('#responsavel').on('change', function () {
       verificarCampoChamado();
    });

    $('#observacao').on('keydown', function () {
       verificarCampoChamado();
    });

    function verificarCampoChamado() {
        var setor      =    $('#setor').val();
        var descricao   =    $('#descricao').val();
        var responsavel =    $('#responsavel').val();
        var observacao  =    $('#observacao').val();
        var btn = $('.btn-servico');
        var btnSalvar = $('.btn-salvar');
        if( ( setor != 0) && ( descricao != "" ) && ( observacao != "" ) && ( responsavel != 0 ) ){
            boolNovoServico = true;
            btnSalvar.removeClass('btn-danger');
            btnSalvar.addClass('btn-primary');
            btn.removeClass('btn-danger');
            btn.addClass('btn-primary');
            btnSalvar.attr("title","Pronto para salvar");
            btn.attr("title","Permite adicionar novo servico");
        }else{

            btn.attr("title","Preencha todos campos obrigatorios");
            btnSalvar.attr("title","Preencha todos campos obrigatorios");
            btn.removeClass('btn-primary');
            btnSalvar.removeClass('btn-primary');
            btnSalvar.addClass('btn-danger');
            btn.addClass('btn-danger');
            boolNovoServico = false;
        }

    }

$("#dataos").datetimepicker({
    //timepicker: true,
    format: 'd/m/Y H:i',
    mask: true
});
$("#previsao").datetimepicker({
    //timepicker: true,
    format: 'd/m/Y H:i',
    mask: true
});


$("#datai").datetimepicker({
    //timepicker: true,
    format: 'd/m/Y H:i',
    mask: true
});

    $("#dataf").datetimepicker({
        //timepicker: true,
        format: 'd/m/Y H:i',
        mask: true
    });

    function carregarDataHoraAtual() {
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

        $('#datai').val(campoData);
        $('#dataos').val(campoData);
        $('#previsao').val(campoData);
      //  $('#dataf').val( campoDataF );
        $('#dataf').val( '' );
        //calcularHoras();
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

        $('#datai').val(campoData);
       // $('#dataf').val( campoDataF );
        $('#dataf').val( '' );

       // calcularHoras();
    }

    $(document).ready(function () {

      var usuario = $('#usuario').val().trim();
      $('.tabela').fadeOut();

      carregarComboServico(  );
      carregarComboOficina( usuario );
      carregarDataHoraAtual();
      carregarComboFuncionario(31);
      carregarComboServico();

      $('.load-modal').fadeOut();
      $('.alerta-modal').fadeOut();

       var _cdOs = $('#cdos').val();
       console.log("Codigo: "+_cdOs);
       $.ajax({
           url   : 'funcao/os.php',
           type  : 'post',
           dataType : 'json',
           data  : {
               acao : 'O',
               cdos : _cdOs
           },
           success : function (data) {
             //  console.log("Seetor: "+data.setor);
               var tipoos = data.tipoos;
               carregarComboMotivo( tipoos );
               carregarComboTipoOs( tipoos );
               carregarComboResponsavel( data.oficina, usuario );

               $('#dataos').val(data.pedido);
               $('#previsao').val(data.previsao);
           //    $('#setor').val(  ).trigger("chosen:updated");
               carregarComboSetor( data.setor );
               $('#descricao').val( data.descricao );
               $('#ramal').val( data.ramal );
               $('#observacao').val( data.observacao );
               $('#solicitante').val( data.solicitante );


               verificarCampoChamado();
               preencherTabelaServicos();
              // console.log("Tipo OS: "+tipoos);

           }
       });

    });


function carregarComboSetor( cdsetor ){
    console.log("Combo setor: "+cdsetor);
    var setor = $('#setor');
    setor.find('option').remove();
    $.ajax({
        url      : 'funcao/setor.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao : 'S'
        },
        success : function (data) {
            /*var op = "<option value='0'>Selecione um setor</option>";
            setor.append(op); */

            $.each( data.setor, function (key, value) {

                var option  = "<option value='"+ value.codsetor +"'>"
                        + value.nmsetor
                        +"</option>";

                setor.append(option);

            } );
            if( cdsetor > 0 ) {
                setor.val( cdsetor ).trigger("chosen:updated");

            }
            else{
                setor.trigger("chosen:updated");
            }
        }

    });

}


function carregarComboOficina( usuario ){
    $.ajax({
        url      : 'funcao/oficina.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao : 'O',
            usuario : usuario
        },
        success : function (data) {

            $.each( data.oficinas, function (key, value) {

                var option  = "<option value='"+ value.codigo +"'>"
                    + value.oficina
                    +"</option> ";

                $('#oficina').append(option);

            } );

            $('#oficina').trigger("chosen:updated");
        }

    });

}


$('#oficina').on('change', function () {
    verificarCampoChamado();
});

function carregarComboTipoOs( tipoOs ){
    $.ajax({
        url      : 'funcao/tipoos.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao : 'T'
        },
        success : function (data) {

            $.each( data.tipoos, function (key, value) {

                var option  = "<option value='"+ value.codigo +"'>"
                    + value.descricao
                    +"</option> ";

                $('#tipoos').append(option);

            } );

            $('#tipoos').val( tipoOs ).trigger("chosen:updated");;
        }

    });

}


    function carregarComboMotivo( tipoOs ){
        var comboMotivo = $('#motivo');
        comboMotivo.find('option').remove();
        $.ajax({
            url      : 'funcao/tipoos.php',
            type     : 'post',
            dataType : 'json',
            data : {
                acao   : 'M',
                tipoos : tipoOs
            },
            success : function (data) {

                $.each( data.motivos, function (key, value) {

                    var option  = "<option value='"+ value.codigo +"'>"
                        + value.descricao
                        +"</option> ";

                    comboMotivo.append(option);

                } );

                comboMotivo.trigger("chosen:updated");
            }

        });

    }

function carregarComboResponsavel( oficina, usuario ){
    $.ajax({
        url      : 'funcao/responsavel.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao   : 'R',
            oficina : oficina
        },
        success : function (data) {
            /*var op = "<option value='0'>Selecione</option>";
            $('#responsavel').append(op);*/
            // console.log(data);
            $.each( data.usuarios, function (key, value) {

                var option  = "<option value='"+ value.cdusuario +"'>"
                    + value.cdusuario
                    +"</option> ";

                $('#responsavel').append(option);

            } );
            $('#responsavel').val( usuario ).trigger("chosen:updated");
        }

    });




}

function carregarComboFuncionario( especialidade ){
    var resp = $('#resp');
    $.ajax({
        url      : 'funcao/responsavel.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao   : 'F',
            especialidade : especialidade
        },
        success : function (data) {
            var op = "<option value='0'>Selecione</option>";
            resp.append(op);
            // console.log(data);
            $.each( data.funcionarios, function (key, value) {

                var option  = $('<option>').val( value.codigo ).text( value.nome ) ;

                resp.append(option);

            } );
            resp.trigger("chosen.updated")
        }

    });

}

        function carregarComboServico(  ){
            $.ajax({
                url      : 'funcao/servico.php',
                type     : 'post',
                dataType : 'json',
                data : {
                    acao   : 'M'
                },
                success : function (data) {
                    var op = $("<option>").val(0).text('Selecione');
                    $('#servico').append(op);
                    // console.log(data);
                    $.each( data.servicos, function (key, value) {

                        var option  = $('<option>').val( value.codigo ).text( value.servico ) ;

                        $('#servico').append(option);

                    } );
                }

            });

        }

    $('.btn-salvar').on('click', function () {
        var botao = $(this);
        validarCamposChamado( botao );
    });

    $('.btn-servico').on('click', function () {


        validarCamposServico(  );

    });

     function validarCamposServico() {
         if( boolNovoServico ){
             //console.log('Abrir modal');

             $('#tela-servico').modal('show');
             //$('#resp').val(0);
             //$('#resp').text( $('#usuario').val() ).trigger("chosen:updated");
             //$("#resp").find("option[text=" + $('#usuario').val().trim() + "]").attr("selected", true);
             $("#resp option:contains(" + $('#usuario').val().trim() +")").attr("selected", true);
             $('#servico').val(0);
             $('#desc').val("");
             $('#snfeito').attr('checked',false);
             /*$('#datai').val("");
             $('#dataf').val("");*/

             $('#codigoItem').val(0);
             $('select[id="setor"]').css('border-color', '');
             $('select[id="responsavel"]').css('border-color', '');
             $('input[id="descricao"]').css('border-color', '');
             $('textarea[id="observacao"]').css('border-color', '');
             verificarCampo();
             carregarDataHoraAtualServico();

         }else {
             var setor      =    $('#setor').val();
             var descricao   =    $('#descricao').val();
             var responsavel =    $('#responsavel').val();
             var observacao  =    $('#observacao').val();


             if( ( setor == 0) || ( descricao == "" ) || ( observacao == "" ) || ( responsavel == 0 ) || ( !verificarData() ) ){
                 if( setor == 0 ){
                     $('select[id="setor"]').css('border-color', 'red');
                 }
                 if( responsavel == 0 ){
                     $('select[id="responsavel"]').css('border-color', 'red');
                 }
                 if( descricao == "" ){
                     $('input[id="descricao"]').css('border-color', 'red');
                 }
                 if( observacao == "" ){
                     $('textarea[id="observacao"]').css('border-color', 'red');
                 }

                 if( !verificarData() ){
                     $('input[id="dataf"]').css('border-color', 'red');
                 }

             }


         }
     }

function validarCamposChamado() {
    if( boolNovoServico ){
        //console.log('Abrir modal');
        salvarOs();
        $('select[id="setor"]').css('border-color', '');
        $('select[id="responsavel"]').css('border-color', '');
        $('input[id="descricao"]').css('border-color', '');
        $('textarea[id="observacao"]').css('border-color', '');
    }else {
        msgAvisoChamado();
        var setor      =    $('#setor').val();
        var descricao   =    $('#descricao').val();
        var responsavel =    $('#responsavel').val();
        var observacao  =    $('#observacao').val();

        if( ( setor == 0) || ( descricao == "" ) || ( observacao == "" ) || ( responsavel == 0 ) ){
            if( setor == 0 ){
                $('select[id="setor"]').css('border-color', 'red');
            }
            if( responsavel == 0 ){
                $('select[id="responsavel"]').css('border-color', 'red');
            }
            if( descricao == "" ){
                $('input[id="descricao"]').css('border-color', 'red');
            }
            if( observacao == "" ){
                $('textarea[id="observacao"]').css('border-color', 'red');
            }

        }


    }
}


var dataInicial = $('#datai');
var dataFinal   = $('#dataf');

dataInicial.on('blur', function () {
    calcularHoras();
});

dataFinal.on('blur', function () {
    verificarCampo();
    if( verificarData() ){
        calcularHoras();
        $('input[id="dataf"]').css('border-color', '');

        return true;

    }else{
        msgAviso('A data final n&atilde;o pode ser menor que a data inicial');
        $('input[id="dataf"]').css('border-color', 'red');
        dataFinal.focus();
        return false;
    }

});

    function calcularHoras () {
       try{
           var tempo = 0;
           var data1 = $('#datai').val().trim();

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
           $('#tempoHora').val( horaStr );
           $('#tempoMinuto').val( minStr );
           $('#total').val( horas );
       }catch (err){
           console.log("Erro: "+err.message);
       }


}



        function verificarData(){
            var strDataInicial = document.getElementById('datai').value;
            var dataInicial    = new Date(strDataInicial);
            var strDataFinal   = document.getElementById('dataf').value;
            var dataFinal      =  new Date(strDataFinal);

            /*

             Obtendo dados da data inicial

             */

            var arrayDataInicio = strDataInicial.split("/"); //separando onde tiver a barrra
            var idia     = arrayDataInicio[0];  //pegando domente o dia da data inicial 16
            var imes     = arrayDataInicio[1];  //pegando domente o mes da data inicial 41
            /*
             como deois do ano tem espaço e a hora, pego todo o final
             2017 19:45
             */
            var istrAno  = arrayDataInicio[2];

            var iarrayAno = istrAno.split(" "); //separando onde tiver espaço
            var iano = iarrayAno[0]; //pegando somente o ano data inicial
            var istrHoras = iarrayAno[1]; //pegando as horas da data inicial 16:47

            /*
             aqui vou separar as horas para pegar as horas e minutos onde for localizado o :
             */
            var iarrayHoras = istrHoras.split(":")
            var ihora     = iarrayHoras[0]; //aqui eu pego somente as horas da data inicial
            var iminutos  = iarrayHoras[1]; //aqui eu pego os minutos do campo data inicial

            /*

             Obtendo dados da data final

             */
            var arrayDataFinal = strDataFinal.split("/"); //separando onde tiver a barrra
            var fdia     = arrayDataFinal[0];  //pegando domente o dia da data final 16
            var fmes     = arrayDataFinal[1];  //pegando domente o mes da data final 41
            /*
             como deois do ano tem espaço e a hora, pego todo o final
             2017 19:45
             */
            var fstrAno  = arrayDataFinal[2];

            var farrayAno = fstrAno.split(" "); //separando onde tiver espaço
            var fano = farrayAno[0]; //pegando somente o ano data final
            var fstrHoras = farrayAno[1]; //pegando as horas da data final 16:47

            /*
             aqui vou separar as horas para pegar as horas e minutos onde for localizado o :
             */
            var farrayHoras = fstrHoras.split(":")
            var fhora     = farrayHoras[0]; //aqui eu pego somente as horas da data finaç
            var fminutos  = farrayHoras[1]; //aqui eu pego os minutos do campo data final

            var vDataInicial = new Date(iano, imes - 1, idia, ihora, iminutos);
            var vDataFinal   = new Date(fano, fmes - 1, fdia, fhora, fminutos);

            var testeData = true;

            var mensagem = $('.mensagem');
            if(vDataFinal <= vDataInicial){
              //  chamarModal('Atenção!','A data inicial não pode ser maior ou igual a data final',2 );



                return false;
            }
            else{

                return true;
            }



        }




        function preencherTabelaServicos() {
            $('.tabela').fadeOut();
            var cdOs = $('#cdos').val();

            $('.tbody').find('tr').remove();
          //  console.log("Preencher tabela codigo da Os: "+cdOs);
            $.ajax({
                url   : 'funcao/servico.php',
                type  : 'post',
                dataType : 'json',
                data : {
                    cdOs : cdOs,
                    acao : 'L'
                },
                success : function (data) {
                  //  console.log(data);
                    $.each( data.itens, function (i, j) {
                        var descricao = j.descricao;
                        if( descricao != "" ){
                            descricao = descricao.replace("#HIDE#","");
                        }
                   //     console.log("Codigo do item: "+j.codigo);
                        var linha = "<tr>"
                                        +"  <td>" + j.servico + "</td>"
                                        +"  <td>" + j.funcionario + "</td>"
                                        +"  <td>" + descricao + "</td>"
                                        +"  <td>" + j.inicio + "</td>"
                                        +"  <td>" + j.final + "</td>"
                                        +"  <td>" + j.tempo + "</td>"
                                        +"  <td> <a href='#editar' class='btn btn-lg '  title='Clique para alterar servico' onclick='abrirTelaAlterarServico("+ j.codigo +")'><i class='fa fa-pencil-square-o'></i></a>"
                                        +        "<a href='#editar' class='btn btn-lg '  title='Clique para alterar servico' onclick='modalRemoverServico("+ j.codigo +",\""+ j.descricao +"\")'><i class='fa fa-times'></i></a>"
                                        +  "</td>"
                                    +"</tr> ";
                        $('.tbody').append( linha );
                    } );
                    $('.tabela').fadeIn();
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
                    var enc = hide.indexOf("#HIDE#");
                    $('#servico').val( data.servico );
                    $('#desc').val( hide.replace(new RegExp('<br />', 'g'), ' ') );
                    if( data.feito == 'S' )
                      $('#snfeito').attr('checked','checked');
                    $('#datai').val( data.inicio );
                    $('#dataf').val( data.final );
                    $('#total').val( data.tempo );

                    $('.modal-servico').modal('show');
                    verificarCampo();

                }


            });

        }

        function modalRemoverServico( cdServico, dsServico ) {

                    $('span.msg-serv').html('<strong>'+ dsServico +'</strong>');
                    $('.modal-delete').modal('show');
                    $('.btn-sim').on('click', function (){
                          removerServico( cdServico );
                    });

        }

        function removerServico( cdServico ) {
            $.ajax({
                type    : 'post',
                dataType: 'json',
                url     : 'funcao/servico.php',
                data    : {
                    acao   : 'E',
                    codigo : cdServico
                },
                success : function (data) {
                    if( data.retorno == 1 ) {
                        sucessoChamado();
                        $('.modal-delete').modal('hide');
                        preencherTabelaServicos();
                    }
                    else
                      msgErro();

                }


            });
        }




