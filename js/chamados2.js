/**
 * Created by carlos.bruno on 17/07/2017.
 */


var boolNovoServico = false;

$('.btn-salvar-servico').on('click', function () {

    if( boolServico ){

        if( $('#cdos').val() > 0 ) {
          //  console.log("Apenas salvar item");
            salvarItem( 'F' );
            $('select[id="resp"]').css("border-color", "");
            $('select[id="servico"]').css("border-color", "");
            $('input[id="datai"]').css("border-color", "");
        }else{
        //    console.log("Salvar OS");
        //    console.log("Salvar item");
            saveOs( salvarItem, 'F' ) ;





        }
    }else{
        msgAviso('Verifique os campos que faltam ser preenchidos');
        var resp    = $('#resp').val();
        var servico = $('#servico').val();
        var datai   = $('#datai').val();
        if( ( resp == 0 ) || ( servico == 0 ) || ( datai == "" ) || ( !validaIntevaloTempo() ) ){
            if( resp == 0 ){
                $('#resp_chosen').addClass('required');
            }
            if( servico == 0 ){
                $('#servico_chosen').addClass('required');
            }
            if( datai == "" ){
                $('input[id="datai"]').css("border-color","red");
            }
            if( !validaIntevaloTempo() ){
                $('input[id="datai"]').css("border-color","red").focus();
                $('#datai').attr("title","A data do servi&ccedil;o n&atilde;o pode ser menor do que a data da cria&ccedil;&atilde;o da ordem de servi&ccedil;o");
                chamarTooltip( "datai" );
            }
        }


    }

});

function carregarComboBens() {

    $.ajax({
         url   :  'funcao/bem.php',
         type  :  'post',
         dataType : 'json',
         data : {
             acao : 'F'             
         },
         success : function (data) {
             var option = "<option value=''></option>";
             $.each( data, function (i, j) {
                 option += "<option value='"+j.cd_bem+"'>"+j.nr_patrimonio+"</option>";
             } );
             var serie = $('#plaqueta');
             serie.find('option').remove();
             serie.append( option );
             serie.trigger( "chosen:updated" );
         }
    });

}

$('#plaqueta').on('change', function () {
     getItem();
});



function getItem(  ) {
    var codigo = $('#plaqueta').val();
    $.ajax({
        url : 'funcao/bem.php',
        type : 'post',
        dataType: 'json',
        data : {
            acao : 'G',
            codigo : codigo
        },
        success : function (data) {
            console.log( data[0].cd_localidade );
            $('#descbem').val( data[0].ds_item );
            $('#localidade').val( data[0].cd_localidade );
            $('#fornecedor').val( data[0].proprietario );

        }
    });
}

$('#servico').on('change', function () {
    if( $(this).val() > 0 ){
        $('#servico_chosen').removeClass( 'required' );
    }
});
$('.btn-salvar-novo').on('click', function () {

    if( boolServico ){

        if( $('#cdos').val() > 0 ) {
       //     console.log("Apenas salvar item");
            salvarItem( 'C' );
            $('select[id="resp"]').css("border-color", "");
            $('select[id="servico"]').css("border-color", "");
            $('input[id="datai"]').css("border-color", "");
        }else{
        //    console.log("Salvar OS");
         //   console.log("Salvar item");
            saveOs( salvarItem, 'C' ) ;





        }
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


function loadTotal(  ) {
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    loadTotalMenu( usuario, funcion );

    setTimeout( function(){
        loadTotal();
    },30000 );
}

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
    var usuario      =  $('#usuario').val();
    var bem          =  $('#plaqueta').val();
    var localidade   =  $('#localidade').val();
    var fornecedor   =  $('#fornecedor').val();
    var ramal        =  $('#ramal').val();
    var acao = "I";
    var codOs = 0;
    if( cdOs > 0 ){
        codOs = cdOs;
        acao = "C";
    }else{

    }
    console.log( "Localidade Salvar: "+localidade );
    console.log( "Fornecedor salvar: "+fornecedor );
    /*console.log('Tipo os: '+tipoos);
    console.log('Usuario : '+usuario);*/
    //console.log("Codigo da Os: "+cdOs);
    $.ajax({
       type      :  'post',
       dataType  :  'json',
       url       :  'funcao/os.php',
       beforeSend : aguardando,
       data      : {
           cdos         : codOs,
           pedido       : dataos,
           previsao     : previsao,
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
           usuario     : usuario,
           acao        : acao,
           bem         : bem,
           localidade  : localidade,
           proprietario  : fornecedor,
           ramal       : ramal
       },
        success : function (data) {
          // console.log("Retorno: "+data.sucesso);
            if( data.sucesso == 1 ){
                if( $('#responsavel').text() != "Selecione" ){
                    carregarTotalRecebimentos();
                }
                $('.loading').fadeOut('slow');
              //  console.log("Chamado salvo: "+ data.chamado);
                $('#cdos').val( data.chamado );
                corBordaCampo( "input","cdos","" );
                sucessoChamado();
                carregarTabela();

            }else{
                $('.loading').fadeOut('slow');
                msgErro('Ocorreu um erro ao realizar opera&ccedil;&atilde;o');
            }
        }
    });




}



function saveOs( saveItem, action ) {

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
    var usuario      =  $('#usuario').val();
    var bem          =  $('#bem').val();
    var localidade   =  $('#localidade').val();
    var acao = "I";
    var codOs = 0;
    if( cdOs > 0 ){
        codOs = cdOs;
        acao = "C";
    }else{

    }
    //console.log("Codigo da Os: "+cdOs);
    $.ajax({
        type      :  'post',
        dataType  :  'json',
        url       :  'funcao/os.php',
        beforeSend : aguardando,
        data      : {
            cdos         : codOs,
            pedido       : dataos,
            previsao     : previsao,
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
            usuario     : usuario,
            bem         : bem,
            acao        : acao,
            localidade  : localidade

        },
        success : function (data) {
            // console.log("Retorno: "+data.sucesso);
            if( data.sucesso == 1 ){
                if( $('#responsavel').text() != "Selecione" ){
                    carregarTotalRecebimentos();
                }
                $('.loading').fadeOut('slow');
              //  console.log("Chamado salvo: "+ data.chamado);
                $('#cdos').val( data.chamado );
                corBordaCampo( "input","cdos","" );
                sucessoChamado();
                carregarTabela();
                setTimeout(function() {
                  //  console.log("Final da função 1");
                    saveItem();
                    if( action == 'F' ){
                        $('#tela-servico').modal('hide');
                    }
                }, 500);

            }else{
                $('.loading').fadeOut('slow');
                msgErro('Ocorreu um erro ao realizar opera&ccedil;&atilde;o');
            }
        }
    });

}

$('.btn-limpar').on('click', function () {
  limparCampos();
});




function salvarItem( action ) {
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
    var snvisualiza      =  $('#snvisualiza');
    var feito        = "N";
    var acao         = "S";
    //var checado = "Sn Visualiza nao chegado";

  //  console.log("Codigo da OS para salvar item: "+cdOs);
    if( snvisualiza.is(':checked') ){
        descricao = "#HIDE#"+descricao;
        checado = "Sn Visualiza chegado";
    }
   // console.log( checado );
 //   console.log("Data Final: "+horaFinal);
    /*if( snfeito.checked ){
        feito = "S"
    }*/

    if( horaFinal != "" ){
        feito = 'S';
    }


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

                sucesso(  );
                preencherTabelaServicos('A');
                $('#codigoItem').val( retorno );
                //tela-servico
                if( action == 'F' ){
                    setTimeout( function () {
                        $('#tela-servico').modal('hide');
                    },1000 );
                }else{
                    $('#codigoItem').val( "" );
                    $('#resp').val( $('#funcionario').val() ).trigger( "chosen:updated" );
                    $('#servico').val( 0 ).trigger( "chosen:updated" );
                    $('#desc').val( "" );
                    $('#snvisualiza').attr("checked","chekced");
                    carregarDataHoraAtualServico();


                }
            }else{
                $('.load-modal').fadeOut('slow');
                msgErroModal('Ocorreu um erro ao realizar opera&ccedil;&atilde;o');
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

function msgErro( msg ) {
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-danger">'+msg+'</p>').fadeIn("fast");
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

    function msgAvisoChamado( msg ) {
        var mensagem = $('.alerta');
        mensagem.empty().html('<p class="alert alert-warning">'+msg+'</p>').fadeIn("fast");
        setTimeout(function (){
            mensagem.fadeOut();
        },2000);
    }


    var boolServico = false;

    $('#resp').on('change', function () {
      //  console.log("Funcionario: "+$(this).val());
        if( $(this).val() > 0 ){
            $('#resp_chosen').removeClass( 'required' );
        }
        verificarCampo();


    });


    $('#servico').on('change', function () {
        verificarCampo();
    });


    $('#datai').on('blur', function () {
        verificarCampo();
    });

    $('#dataf').on('blur', function () {
    //    console.log('data final');
        verificarCampo();
    });



    function buscarUltimoSolicitante() {

        var solicitante = $('#solicitante').val();
        $.ajax({
            url   : 'funcao/os.php',
            dataType : 'json',
            type : 'post',
            data : {
                acao : 'D',
                solicitante : solicitante
            },
            success : function (data) {

                $('#setor').val( data.cdsetor ).trigger("chosen:updated");
                verificarCampoChamado();

            }
        });

    }



function   verifyField() {


}



    function verificarCampo() {
        var responsavel = $('#resp').val();
        var servico     = $('#servico').val();
        var data        = $('#datai').val();
        var dataf       = dataFinal.val();
        var btn = $('.btn-salvar-servico');
        var btnNovo = $('.btn-salvar-novo');
        if( (responsavel != 0) && ( servico != 0 ) && ( data != "" ) && ( validaIntevaloTempo()  ) ) {
            if (dataf == "") {
                boolServico = true;


                btn.removeAttr('disabled');
                btnNovo.removeAttr('disabled');
                btn.removeClass('btn-danger');
                btnNovo.removeClass('btn-danger');
                btn.addClass('btn-success');
                btnNovo.addClass('btn-success');
                btn.attr("title", "Pronto para salvar");
                btnNovo.attr("title", "Pronto para salvar e continuar");

            } else if (verificarData()) {
                boolServico = true;


                btn.removeAttr('disabled');
                btnNovo.removeAttr('disabled');
                btn.removeClass('btn-danger');
                btnNovo.removeClass('btn-danger');
                btn.addClass('btn-success');
                btnNovo.addClass('btn-success');
                btn.attr("title", "Pronto para salvar");
                btnNovo.attr("title", "Pronto para salvar e continuar");
            } else if ( validaIntevaloTempo() ){
                boolServico = true;


                btn.removeAttr('disabled');
                btnNovo.removeAttr('disabled');
                btn.removeClass('btn-danger');
                btnNovo.removeClass('btn-danger');
                btn.addClass('btn-success');
                btnNovo.addClass('btn-success');
                btn.attr("title", "Pronto para salvar");
                btnNovo.attr("title", "Pronto para salvar e continuar");
            }else{
                msgAviso( 'Verique o campos a serem preenchidos' );
            }





        }else{



            btn.attr("title","Preencha todos campos obrigatorios");
            btnNovo.attr("title","Preencha todos campos obrigatorios");
            btn.attr('disabled');
            btnNovo.attr('disabled');
            btn.removeClass('btn-success');
            btnNovo.removeClass('btn-success');
            btn.addClass('btn-danger');
            btnNovo.addClass('btn-danger');
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

        if( validaIntevaloTempo() ){
            $('input[id="datai"]').css('border-color', '');
        }

    }


    $('#setor').on('change', function () {
        verificarCampoChamado();
    });

  /*  $('#solicitante').on('change', function () {
        //console.log("Solicitante mudou: "+$(this).val());
        if( $(this).val() != 0 ){
          //  console.log("Solicitante maior do que zero");
            $("#solicitante_chosen").removeClass("required");
            verificarCampoChamado();
            buscarUltimoSolicitante();
        }

    });*/

    $('#plaqueta').on('focusout', function () {
        var plaqueta = $(this).val();
        if( plaqueta != "" ){
             getSetor( plaqueta );
        }
    });

    function getSetor( plaqueta ) {
        
        $.ajax({
            url :     'funcao/os.php',
            type:     'post',
            dataType: 'json',
            data :{
                acao : 'X',
                plaqueta : plaqueta
            },
            success : function (data) {
                console.log('Plaqueta Setor: :'+data.setor);
                var setor = $('#setor');
                $('#bem').val( data.codigo );
                $('#descbem').val( data.descricao );
                $('#localidade').val( data.localidade );
                $('#setor').val( data.setor ).trigger("chosen:updated");

            }
            
        });
        
    }

$('#oficina').on('change', function () {
    //console.log("Solicitante mudou: "+$(this).val());
    if( $(this).val() != 0 ){
        //  console.log("Solicitante maior do que zero");
        $("#oficina_chosen").removeClass("required");
        verificarCampoChamado();
    }



});


    $('#solicitante').on('click', function () {
        $('select[id="solicitante"]').css( "display","block" );
    });

    $('#descricao').on('input', function () {
       verificarCampoChamado();
    });

    $('#tipoos').on('change', function () {
        var id = $(this).val();
        //console.log("Tipo os: "+id);
        if( id > 0 ) {
           // console.log("Carregar combo motivo "+id);
            $('#tipoos_chosen').removeClass("required");
            carregarComboMotivo($(this).val());
        }else{
           // console.log("Carregar combo motivo 1 "+id);
            $('#motivo').find('option').remove();
            $('#motivo').trigger( "chosen:updated" );
        }
    });

    $('#responsavel').on('change', function () {
       verificarCampoChamado();
    });

    $('#observacao').on('input', function () {
       verificarCampoChamado();

    });

    function verificarCampoChamado() {
        var setor       =    $('#setor').val();
        var tipoos      =    $('#tipoos').val();
        var descricao   =    $('#descricao').val();
        var responsavel =    $('#responsavel').val();
        var solicitante =    $('#solicitante').val();
        var observacao  =    $('#observacao').val();
        var oficina     =    $('#oficina').val();
        var btn = $('.btn-servico');
        var btnSalvar = $('.btn-salvar');
       /// console.log("setor: "+setor);
        if( ( setor != 0) && ( descricao != "" ) && ( observacao != "" ) && ( responsavel != 0 ) && ( solicitante != 0 )
            && ( oficina != 0 )
          ){
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

        if( solicitante != 0 ){
            corBordaCampo( "select", "solicitante", "" );
        }

        if( setor != 0 ){
            corBordaCampo( "select", "setor", "" );
        }

        if( descricao != "" ){
            corBordaCampo( "input", "descricao", "" );
        }

        if( observacao != "" ){
            corBordaCampo( "textarea", "observacao", "" );
        }

    }

    function corBordaCampo(tipo, id, cor){
        $(tipo+'[id="'+id+'"').css("border-color",cor);
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
       // console.log('Campo data: '+campoData);
       // $('#datai').val(campoData);
        $('#dataos').val(campoData);
        $('#previsao').val(campoData);
        //$('#dataf').val( campoDataF );
        $('#dataf').val( '' );
        $('#total').val( '' );
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
        // console.log('Campo data: '+campoData);
         $('#datai').val(campoData);
         //$('#dataf').val( campoDataF );
        $('#dataf').val( '' );

        //calcularHoras();
    }

    $(document).ready(function () {

      var usuario = $('#usuario').val().trim();
      $('.tabela').fadeOut();
      carregarComboSetor(   );
      carregarComboServico(  );
      carregarComboOficina( usuario );
      carregarDataHoraAtual();
      carregarComboFuncionario(31, $('#funcionario').val() );
      carregarComboSolcitante();
      carregarComboBens();
      loadTotal();



      $('.load-modal').fadeOut();
      $('.alerta-modal').fadeOut();

        verificarCampoChamado();
       $.ajax({
           url   : 'funcao/os.php',
           type  : 'post',
           dataType : 'json',
           data  : {
               acao    : 'S',
               usuario : usuario
           },
           success : function (data) {

               carregarComboMotivo( 0 );
               carregarComboTipoOs( 0 );
               carregarComboResponsavel( data.cd_oficina, usuario );


               $('#descricao').val( data.descricao );
               $('#observacao').val( data.observacao );



              // preencherTabelaServicos('A');
              // console.log("Tipo OS: "+tipoos);

           }
       });
        carregarTabela( usuario );
        setarValorComboStatus( 'A' );
        startCountdown();
		
		if( $('#cdos').val() > 0 ){
			getOs( $('#cdos').val() );
		}
        var btn_doc = $('.btn-doc');
		if( $('#cdos').val() > 0 ){

		    btn_doc.removeClass('btn-danger');
		    btn_doc.addClass( 'btn-success' );
        }else{
            btn_doc.removeClass('btn-success');
            btn_doc.addClass( 'btn-danger' );
        }

    });


function carregarComboSetor( setor ){
    var setor = $('#setor');
    $.ajax({
        url      : 'funcao/setor.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao : 'S'
        },
        success : function (data) {
           /* var op = "<option value='0'>Selecione um setor</option>";
            $('#setor').append(op);*/

            $.each( data.setor, function (key, value) {

                var option  = "<option value='"+ value.codsetor +"'>"
                        + value.nmsetor
                        +"</option> ";

                setor.append(option);

            } );
            setor.trigger("chosen:updated");

        }

    });

}


function carregarComboOficina( usuario ){
    var oficina = $('#oficina');
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
                    +"</option>";

                oficina.append(option);

            } );

            oficina.trigger("chosen:updated");


        }

    });

}

function carregarComboTipoOs( tipoOs ){
  //  console.log("Carregar Tipo Os");
    $.ajax({
        url      : 'funcao/tipoos.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao : 'T'
        },
        success : function (data) {
           // console.log( data );
            var option = "<option value='%'></option>";
            $.each( data, function (key, value) {
                option += "<option value='"+value.cd_tipo_os+"'>"+value.ds_tipo_os+"</option>";

            } );
            var combo =  $('#tipoos');
            combo.find('opiton').remove();
            combo.append( option );
           // combo.trigger( "chosen:updated" );
            combo.val( tipoOs ).trigger("chosen:updated");

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
     /*       var op = "<option value='0'>Selecione</option>";
            $('#responsavel').append(op);*/
             console.log(data);
            $.each( data, function (key, value) {

                var option  = "<option value='"+ value.cd_usuario +"'>"
                    + value.nm_usuario
                    +"</option> ";

                $('#responsavel').append(option);

            } );
            $('#responsavel').val( usuario ).trigger("chosen:updated");
        }

    });




}

function carregarComboFuncionario( especialidade, func ){
    var resp = $('#resp');
    resp.find('option').remove();
    $.ajax({
        url      : 'funcao/responsavel.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao   : 'F',
            especialidade : especialidade
        },
        success : function (data) {

            var op = "<option value='0'></option>";
            resp.append(op);
            // console.log(data);
            $.each( data.funcionarios, function (key, value) {

                var option  = $('<option>').val( value.codigo ).text( value.nome ) ;

                resp.append(option);

            } );

            resp.val( func ).trigger( "chosen:updated" );
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
                    /*var op = $("<option>").val(0).text('Selecione');
                    $('#servico').append(op);*/
                    // console.log(data);
                    $.each( data.servicos, function (key, value) {

                        var option  = $('<option>').val( value.codigo ).text( value.servico ) ;

                        $('#servico').append(option);

                    } );
                }

            });

        }

function carregarComboSolcitante(  ){

    var solicitante = $('#solicitante');
    $.ajax({
        url      : 'funcao/usuario.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao   : 'U'
        },
        success : function (data) {
            var op = $("<option>").val('0').text('Selecione');
            $('#solicitante').append(op); 
            // console.log(data);
            $.each( data.usuarios, function (key, value) {
                var option  = $('<option>').val( value.usuario ).text( value.nome ) ;

                solicitante.append(option);

            } );

            solicitante.trigger("chosen:updated");
        }

    });

}

function carregarComboSolicitante( soliciante ){
    $('#solicitante').find('option').remove();
    var solicitante = $('#solicitante');
    $.ajax({
        url      : 'funcao/usuario.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao   : 'U'
        },
        success : function (data) {
            var op = $("<option>").val('0').text('Selecione');
            $('#solicitante').append(op);
            // console.log(data);
            $.each( data.usuarios, function (key, value) {
             //   console.log( "Usuario: '"+value.usuario+"'" )
                var option  = $('<option>').val( value.usuario ).text( value.nome ) ;

                solicitante.append(option);

            } );

            solicitante.val( soliciante ).trigger("chosen:updated");
        }

    });

}

    $('.btn-salvar').on('click', function () {
        var botao = $(this);
        validarCamposChamado( botao );
    });

    $('.btn-servico').on('click', function () {


        //verifyField(  );
        validarCamposServico();

    });
/*$('#tela-servico').on('shown.bs.modal', function () {
    //
    $('#servico').trigger('chosen:activate');
});*/

     function validarCamposServico() {
         if( boolNovoServico ){
             //console.log('Abrir modal');

             $('#tela-servico').modal('show');
             /*$('#servico').trigger('chosen:activate');*/
             //$('#resp').val(0);
             carregarComboFuncionario( 31, $('#funcionario').val() );
             $('#servico').val(0);
             $('#desc').val("");
             $('#snfeito').attr('checked',false);
             $('#dios').val( $('#dataos').val() );

            /* $('#datai').val("");
             $('#dataf').val("");*/

             $('#codigoItem').val(0);
             $('select[id="setor"]').css('border-color', '');
             $('select[id="responsavel"]').css('border-color', '');
             $('input[id="descricao"]').css('border-color', '');
             $('textarea[id="observacao"]').css('border-color', '');
             carregarDataHoraAtualServico(  );
             verificarCampo(  );
             validaIntevaloTempo();
         }else {
             var setor      =    $('#setor').val();
             var solicitante      =    $('#solicitante').val();
             var cdOs       =    $('#cdos').val();
             var descricao   =    $('#descricao').val();
             var responsavel =    $('#responsavel').val();
             var observacao  =    $('#observacao').val();

             if( ( setor == 0) || ( solicitante == 0) || ( descricao == "" ) || ( observacao == "" ) || ( responsavel == 0 ) || ( !verificarData() )  || ( cdOs == "" ) ){
                 if( setor == 0 ){
                     $('select[id="setor"]').css('border-color', 'red');
                 }
                 if( responsavel == 0 ){
                     $('select[id="responsavel"]').css('border-color', 'red');
                 }
                 if( descricao == "" ){
                     $('input[id="descricao"]').css('border-color', 'red');
                 }
                 if( cdOs == "" ){
                     corBordaCampo( "input", "cdos", "red" );
                 }

                 if( solicitante == 0 ){
                     corBordaCampo( "select", "solicitante", "red" );
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
        $('select[id="solicitante"]').css('border-color', '');
        $('input[id="descricao"]').css('border-color', '');
        $('textarea[id="observacao"]').css('border-color', '');
    }else {
        msgAvisoChamado('Verifique os campos que faltam ser preenchidos');
        var setor       =    $('#setor').val();
        var descricao   =    $('#descricao').val();
        var solicitante =    $('#solicitante').val();
        var responsavel =    $('#responsavel').val();
        var observacao  =    $('#observacao').val();
        var tipoos      =    $('#tipoos').val();
        var oficina     =    $('#oficina').val();

        if( ( setor == 0) || ( descricao == "" ) || ( observacao == "" ) || ( responsavel == 0 ) || ( solicitante == 0 ) || ( oficina == 0 ) ){
            if( setor == 0 ){
                $('select[id="setor"]').css('border-color', 'red');
                $('select[id="setor"]').addClass('errorCampo');
                $('#setor').trigger('chosen:activate');
            }
            if( responsavel == 0 ){
                $('select[id="responsavel"]').css('border-color', 'red');
                $('select[id="responsavel"]').addClass('errorCampo');
                $('#responsavel').trigger('chosen:activate');
            }

            if( solicitante == 0 ){
              //  console.log("solicitante: "+solicitante);


                $("#solicitante_chosen").addClass("required");
                $('#solicitante').trigger('chosen:activate');

                chamarTooltip( "solicitante_chosen" );


              //  $('select[id="solicitante"]').css("display","none");


            }



            if( oficina == 0 ){
              //  console.log("solicitante: "+solicitante);


                $("#oficina_chosen").addClass("required");
                $('#oficina').trigger('chosen:activate').popup();

                chamarTooltip( "oficina_chosen" );


                //  $('select[id="solicitante"]').css("display","none");


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


   function validaIntevaloTempo() {
     try{
         var strDataInicial = $('#dataos').val();
         var dataInicial    = new Date(strDataInicial);
         var strDataFinal   = $('#datai').val();
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
         if(vDataFinal < vDataInicial){
             //  chamarModal('Atenção!','A data inicial não pode ser maior ou igual a data final',2 );

             // console.log("Data é menor ");

             return false;
         }
         else{
             //     console.log("Data é maior ou igual");
             return true;
         }
     }catch (err){

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
          // console.log("Erro: "+err.message);
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




        function preencherTabelaServicos( situacao ) {
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
                     //   console.log("Final:  "+j.final);
                        var string = j.descricao.split( "<br />" );
                        var descricao = "";
                        if( j.descricao != "" ){
                            descricao = j.descricao.replace("#HIDE#","");
                        }

                        var linha;
                        if( situacao != 'C'){
                            var cor = "";
                            if( j.final != "" )
                                cor = "#B2EBF2"

                            linha = "<tr bgcolor='" + cor + "'>"
                                        +"  <td>" + j.codigo + "</td>"
                                        +"  <td>" + j.servico + "</td>"
                                        +"  <td>" + j.funcionario + "</td>"
                                        +"  <td>" + descricao + "</td>"
                                        +"  <td>" + j.inicio + "</td>"
                                        +"  <td>" + j.final + "</td>"
                                        +"  <td>" + j.tempo + "</td>"
                                        +"  <td> <a href='#editar' title='Clique para alterar servico' onclick='abrirTelaAlterarServico("+ j.codigo +")'><i class='fa fa-pencil-square-o'></i></a>"
                                        +        "<a href='#excluir'  title='Clique para alterar servico' onclick='modalRemoverServico("+ j.codigo +",\""+ string[0] + "..." +"\")'><i class='fa fa-times'></i></a>"
                                        +  "</td>"
                                        +"</tr> ";
                        }else{
                            linha = "<tr>"
                                            +"  <td>" + j.codigo + "</td>"
                                            +"  <td>" + j.servico + "</td>"
                                            +"  <td>" + j.funcionario + "</td>"
                                            +"  <td>" + descricao + "</td>"
                                            +"  <td>" + j.inicio + "</td>"
                                            +"  <td>" + j.final + "</td>"
                                            +"  <td>" + j.tempo + "</td>"
                                            +"  <td></td>"
                                +"</tr> ";
                        }

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

                    if( hide != ""){
                        var enc = hide.indexOf("#HIDE#");
                       // console.log("Encontrou hide "+ enc);
                        if( enc === 0 ){
                            hide = hide.replace("#HIDE#","");
                            $('#snvisualiza').attr('checked','checked');
                        }else{
                            $('#snvisualiza').removeAttr('checked','checked');
                        }
                        $('#desc').val( hide.replace(new RegExp('<br />', 'g'), ' ') );
                    }else{
                        $('#desc').val("");
                    }



                    $('#servico').val( data.servico );
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
                    $('span.titulo-modal-remover').html('Confirme exclus&atilde;o');
                    $('p.msg-delete').html('Deseja realmente excluir o servi&ccedil;o <strong>'+ dsServico +'</strong> ?');
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
                        preencherTabelaServicos( 'A' );
                    }
                    else
                      msgErro('Ocorreu um erro ao realizar opera&ccedil;&atilde;o');

                }


            });
        }

function carregarTabela (  ) {
    $('.tabela-chamados').fadeOut();
    $('.tabela-chamados').find('tr').remove();


    $.ajax({
        url  : 'funcao/os.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao    : 'E',
            inicio  : 0,
            fim     : 13
        },
        success : function (data) {

            //$('.tbody').find('tr').remove();



            $.each(data, function (key, value) {
                var linhas;
                if( value.responsavel == $('#usuario').val() ){
                    linhas = "<tr class='linha' bgcolor='#FFCCBC'>"
                        +"<td>" + value.cdos + "</td>"
                        +"<td>" + value.pedido + "</td>"
                        +"<td>" + value.situacao + "</td>"
                        +"</tr>";
                }else{
                    linhas = "<tr class='linha'>"
                        +"<td>" + value.cdos + "</td>"
                        +"<td>" + value.pedido + "</td>"
                        +"<td>" + value.situacao + "</td>"
                        +"</tr>";
                }

                $('.tabela-chamados').append(linhas);
            });

            $('.tabela-chamados').fadeIn();


            $(".linha").on('click',function(e) {



                var tableData = $(this).children("td").map(function()         {
                    return $(this).text();
                }).get();
                //console.log("Clique: "+$.trim(tableData[0]));
                var codigoOs =  $.trim(tableData[0]) ;

                getOs( codigoOs );

            });

        }

    });

}

function getOs( codigoOs ) {

    $.ajax({
        url   : 'funcao/os.php',
        type  : 'post',
        dataType : 'json',
        data  : {
            acao : 'O',
            cdos : codigoOs
        },
        success : function (data) {
        //    console.log("Erro: "+data.erro);

            if( data.erro == 0 ){
                if( data.situacao == 'C' ){
                //    console.log('Situacao: '+data.situacao);

                    $('.btn-salvar')
                        .attr('disabled', true)
                        .attr('title', 'Chamado concluido');

                    $('.btn-servico')
                        .attr('disabled', true);

                    $('a.btn-editar').removeAttr('href');

                    $('#motivo').val( data.motivo );
                    setAtributes( "#status", "disabled", true );

                }else{
                    $('.btn-salvar').attr('disabled', false);
                    $('.btn-servico')
                        .attr('disabled', false);

                    $('a.btn-editar')
                        .attr('href','#editar')
                        .attr('title', 'Chamado concluido');

                    setAtributes( "#status", "disabled", false );



                }

                $('#cdos').val(codigoOs);
                $('#dataos').val(data.ordem.dh_pedido);
                //console.log('Previsao: '+data.previsao);
                $('#previsao').val(data.ordem.previsao);
                console.log("Cadastro Solicitante: '"+data.ordem.solicitante+"'");
                $('#solicitante').val( data.ordem.solicitante ).trigger("chosen:updated");
            //    carregarComboSolicitante( data.ordem.solicitante );
                $('#setor').val(data.ordem.codigo_setor).trigger("chosen:updated");
                //$('#tipoos').val( data.ordem.codigo_tipo_os ).trigger("chosen:updated");
                carregarComboTipoOs( data.ordem.codigo_tipo_os )
              //  console.log( 'Tipo os: '+data.ordem.codigo_tipo_os );
                carregarComboMotivo( data.ordem.codigo_tipo_os );
               // console.log("Motivo: "+data.motivo);
                $('#motivo').val( data.ordem.codigo_motivo ).trigger("chosen:updated");
                $('#oficina').val(data.ordem.codigo_oficina).trigger("chosen:updated");
                $('#descricao').val(data.ordem.servico);
                $('#observacao').val(data.ordem.observacao);
                $('#responsavel').val(data.ordem.responsavel).trigger("chosen:updated");
                $('#status').val(data.ordem.situacao).trigger("chosen:updated");
                setarValorComboStatus( data.ordem.situacao );
                $('#resolucao').val(data.ordem.resolucao);
                //console.log( "Plaqueta: "+data.ordem.cd_bem );
                $('#plaqueta').val( data.ordem.cd_bem ).trigger( "chosen:updated" )
                //console.log( 'Patrimonio: '+data.ordem.ds_item );

                $('#descbem').val( data.ordem.ds_item );
                console.log( "Ramal: "+ data.ordem.ds_ramal);
                $('#ramal').val( data.ordem.ds_ramal );
                preencherTabelaServicos( data.ordem.situacao );

                verificarCampoChamado();

                setAtributes( "#cdos", "disabled", true );
                $('.btn-pesquisar').find('i').removeClass('fa-check');
                $('.btn-pesquisar').find('i').addClass('fa-search');
                //$('#cdos').focus();
                setAtributes( "#previsao", "disabled", false );
               // setAtributes( "#solicitante", "disabled", false );
                setAtributes( "#setor", "disabled", false );
                setAtributes( "#tipoos", "disabled", false );
                setAtributes( "#motivo", "disabled", false );
                setAtributes( "#oficina", "disabled", false );
               // setAtributes( "#descricao", "disabled", false );
                setAtributes( "#observacao", "disabled", false );
                setAtributes( "#responsavel", "disabled", false );

                setAtributes( "#resolucao", "disabled", false );
                verificarCampo();

            }else{
                msgAvisoChamado( 'Ordem de servi&ccedil;o n&atilde;o encontrada' );
            }

        }
    });

}

    $('.btn-pesquisar').on('click', function (e) {

        limparCampos();
        if( $(this).find('i').hasClass('fa-check') ){

            setAtributes( "#cdos", "disabled", true );
            $('.btn-pesquisar').find('i').removeClass('fa-check');
            $('.btn-pesquisar').find('i').addClass('fa-search');
            //$('#cdos').focus();
            setAtributes( "#previsao", "disabled", false );
            setAtributes( "#solicitante", "disabled", false );
            setAtributes( "#setor", "disabled", false );
            setAtributes( "#tipoos", "disabled", false );
            setAtributes( "#motivo", "disabled", false );
            setAtributes( "#oficina", "disabled", false );
            setAtributes( "#descricao", "disabled", false );
            setAtributes( "#observacao", "disabled", false );
            setAtributes( "#responsavel", "disabled", false );
            setAtributes( "#status", "disabled", false );
            setAtributes( "#resolucao", "disabled", false );
        }else{
            $('#cdos').val("");
            setAtributes( "#cdos", "disabled", false );
            $(this).find('i').removeClass('fa-search');
            $(this).find('i').addClass('fa-check');
            $('#cdos').focus();
            setAtributes( "#previsao", "disabled", true );
            setAtributes( "#solicitante", "disabled", true );
            setAtributes( "#setor", "disabled", true );
            setAtributes( "#tipoos", "disabled", true );
            setAtributes( "#motivo", "disabled", true );
            setAtributes( "#oficina", "disabled", true );
            setAtributes( "#descricao", "disabled", true );
            setAtributes( "#observacao", "disabled", true );
            setAtributes( "#responsavel", "disabled", true );
            setAtributes( "#status", "disabled", true );
            setAtributes( "#resolucao", "disabled", true );
        }






    });

    $('#cdos').on('blur', function () {
        var codigoOs = $('#cdos').val();
        getOs( codigoOs )

    });


    function setAtributes(id, atributo, valor){
        $(id).attr( atributo, valor );
    }


    function limparCampos() {
        $('#cdos').val("0");
        $('#descricao').val("");
        $('#observacao').val("");
      //  $('#solicitante').val(0).trigger("chosen:updated");
        $('#setor').val(0);
        var cdsetor = document.getElementById('cdsetor').value;
        carregarComboSetor( cdsetor );
        $('#tipoos').val( 0 ).trigger("chosen:updated");
        $('#motivo').val( 0 ).trigger("chosen:updated");
        $('#oficina').val( 0 ).trigger("chosen:updated");
        $('#status').val( 'A' ).trigger("chosen:updated");
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


    function startCountdown(){

                setTimeout(function () {
                    var status = $('#status').val();
                    preencherTabelaServicos( status );
                    carregarTabela();
                    startCountdown()
                }, 30000);
    }

    $('#status').on('change', function () {
        var status = $(this).val();
        var codigo = $('#cdos').val();

        if( ( codigo > 0) || ( codigo != "" ) ){
            if( statusGlobal != 'C' ){
                if( status == 'C' ){



                    $('span.titulo-modal-remover').html('Fechar chamado');
                    $('p.msg-delete').html('Deseja realmente fechar o chamado <strong>' + codigo + '</strong> ?');
                    $('.modal-delete').modal('show');
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
                 //   console.log( "Chamado finalizado: "+data.retorno );
                    if( data.retorno == 1 ){
                        $('.loading').fadeOut();
                        sucessoChamado();
                        $('.modal-delete').modal('hide');
                    }else{
                        msgErro('Ocorreu um erro na opera&ccedil;&atildeo');
                    }

            }
        });

    }


    var statusGlobal;
    function setarValorComboStatus( status ) {
        statusGlobal =  status;
    }

    
    $('.btn-doc').on('click', function () {

        if( $('#cdos').val() > 0 ){
            $.FileDialog({multiple: true}).on('files.bs.filedialog', function(ev) {
                var files = ev.files;
                var text = "";
               // addAttach( files );
                files.forEach(function(f) {
                    text += f.name + "<br/>";
                 //s   console.log( "Name: "+ f.name+" File: "+f);
                });

               /* var cdOs = $('#cdos').val();
                console.log("Codigo Os; "+cdOs);
                $.ajax({
                    url      : 'funcao/os.php',
                    dataType : 'json',
                    type     : 'post',
                    data: {
                        acao  : 'V',
                        cdos  : cdOs,
                        anexo : files
                    },
                    success : function (data) {

                    }
                });*/

                $("#output").html(text);
            }).on('cancel.bs.filedialog', function(ev) {
                $("#output").html("Cancelled!");
            });
        }


    });

/*
    function addAttach( files ) {
        var text = "";
        files.forEach(function(f) {
            text += f.name + "<br/>";
            console.log( "Name: "+ f.name+" File: "+f);
        });

        $("#output").html(text);
        var cdOs = $('#cdos').val();
        console.log("Codigo Os; "+cdOs);
        $.ajax({
            url      : 'funcao/os.php',
            dataType : 'json',
            type     : 'post',

            data: {
                acao  : 'V',
                cdos  : cdOs,
                anexo : files
            },
            success : function (data) {

            }
        });


    }
*/
