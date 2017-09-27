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
    var usuario      =  $('#usuario').val();
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
           acao        : acao
       },
        success : function (data) {
          // console.log("Retorno: "+data.sucesso);
            if( data.sucesso == 1 ){
                $('.loading').fadeOut('slow');
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
    var snfeito      =  document.getElementById('snfeito');
    var snvisualiza      =  $('#snvisualiza');
    var feito        = "N";
    var acao         = "S";
    var checado = "Sn Visualiza nao chegado";
    if( snvisualiza.is(':checked') ){
        descricao = "#HIDE#"+descricao;
        checado = "Sn Visualiza chegado";
    }
    console.log( checado );
 //   console.log("Data Final: "+horaFinal);
    if( snfeito.checked ){
        feito = "S"
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
            if( data.retorno == 1 ){
                $('.load-modal').fadeOut('slow');
                sucesso();
                preencherTabelaServicos('A');

            }else{
                $('.load-modal').fadeOut('slow');
                msgErro('Ocorreu um erro ao realizar opera&ccedil;&atilde;o');
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
        verificarCampo();
    });


    $('#servico').on('change', function () {
        verificarCampo();
    });


    $('#datai').on('blur', function () {
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

    $('#solicitante').on('change', function () {
        verificarCampoChamado();
        buscarUltimoSolicitante();


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
        var setor       =    $('#setor').val();
        var tipoos      =    $('#tipoos').val();
        var descricao   =    $('#descricao').val();
        var responsavel =    $('#responsavel').val();
        var solicitante =    $('#solicitante').val();
        var observacao  =    $('#observacao').val();
        var btn = $('.btn-servico');
        var btnSalvar = $('.btn-salvar');
        console.log("setor: "+setor);
        if( ( setor != 0) && ( descricao != "" ) && ( observacao != "" ) && ( responsavel != 0 ) && ( solicitante != 0 )
            && ( tipoos != 0 )
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
        $('#datai').val(campoData);
        $('#dataos').val(campoData);
        $('#previsao').val(campoData);
        $('#dataf').val( campoDataF );

        calcularHoras();
    }

    $(document).ready(function () {

      var usuario = $('#usuario').val().trim();
      $('.tabela').fadeOut();
      carregarComboSetor(   );
      carregarComboServico(  );
      carregarComboOficina( usuario );
      carregarDataHoraAtual();
      carregarComboFuncionario(31);
      carregarComboSolcitante();



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
               var tipoos = data.tipoos;
               carregarComboMotivo( tipoos );
               carregarComboTipoOs( tipoos );
               carregarComboResponsavel( data.oficina, usuario );


               $('#descricao').val( data.descricao );
               $('#observacao').val( data.observacao );



               preencherTabelaServicos('A');
              // console.log("Tipo OS: "+tipoos);

           }
       });
        carregarTabela( usuario );
        setarValorComboStatus( 'A' );
        startCountdown();
		
		if( $('#cdos').val() > 0 ){
			getOs( $('#cdos').val() );
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
            var op = "<option value='0'>Selecione um setor</option>";
            $('#setor').append(op);

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
                    +"</option> ";

                oficina.append(option);

            } );

            oficina.trigger("chosen:updated");


        }

    });

}

function carregarComboTipoOs( tipoOs ){
    console.log("Carregar Tipo Os");
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

            $('#tipoos').val( tipoOs ).trigger("chosen:updated");
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
            var op = "<option value='0'>Selecione</option>";
            $('#responsavel').append(op);
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
            $('#resp').append(op);
            // console.log(data);
            $.each( data.funcionarios, function (key, value) {

                var option  = $('<option>').val( value.codigo ).text( value.nome ) ;

                $('#resp').append(option);

            } );
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
             //  console.log( "Usuario: '"+value.usuario+"'" )
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


        validarCamposServico(  );

    });

     function validarCamposServico() {
         if( boolNovoServico ){
             //console.log('Abrir modal');
             $('#tela-servico').modal('show');
             //$('#resp').val(0);
             $("#resp option:contains(" + $('#usuario').val().trim() +")").attr("selected", true);
             $('#servico').val(0);
             $('#desc').val("");
             $('#snfeito').attr('checked',false);
            /* $('#datai').val("");
             $('#dataf').val("");*/

             $('#codigoItem').val(0);
             $('select[id="setor"]').css('border-color', '');
             $('select[id="responsavel"]').css('border-color', '');
             $('input[id="descricao"]').css('border-color', '');
             $('textarea[id="observacao"]').css('border-color', '');
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

        if( ( setor == 0) || ( descricao == "" ) || ( observacao == "" ) || ( responsavel == 0 ) || ( solicitante != 0 ) ){
            if( setor == 0 ){
                $('select[id="setor"]').css('border-color', 'red');
            }
            if( responsavel == 0 ){
                $('select[id="responsavel"]').css('border-color', 'red');
            }

            if( solicitante == 0 ){
                $('select[id="solicitante"]').css('border-color', 'red');
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
                   //     console.log("Codigo do item: "+j.codigo);
                        var linha;
                        if( situacao != 'C'){
                            linha = "<tr>"
                                +"  <td>" + j.servico + "</td>"
                                +"  <td>" + j.funcionario + "</td>"
                                +"  <td>" + j.descricao + "</td>"
                                +"  <td>" + j.inicio + "</td>"
                                +"  <td>" + j.final + "</td>"
                                +"  <td>" + j.tempo + "</td>"
                                +"  <td> <a href='#editar' class='btn btn-lg btn-editar'  title='Clique para alterar servico' onclick='abrirTelaAlterarServico("+ j.codigo +")'><i class='fa fa-pencil-square-o'></i></a>"
                                +        "<a href='#excluir' class='btn btn-lg btn-excluir'  title='Clique para alterar servico' onclick='modalRemoverServico("+ j.codigo +",\""+ j.descricao +"\")'><i class='fa fa-times'></i></a>"
                                +  "</td>"
                                +"</tr> ";
                        }else{
                            linha = "<tr>"
                                +"  <td>" + j.servico + "</td>"
                                +"  <td>" + j.funcionario + "</td>"
                                +"  <td>" + j.descricao + "</td>"
                                +"  <td>" + j.inicio + "</td>"
                                +"  <td>" + j.final + "</td>"
                                +"  <td>" + j.tempo + "</td>"
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
                    var enc = hide.indexOf("#HIDE#");
                    console.log("Encontrou hide "+ enc);
                    if( enc === 0 ){
                        hide = hide.replace("#HIDE#","");
                        $('#snvisualiza').attr('checked','checked');
                    }else{
                        $('#snvisualiza').removeAttr('checked','checked');
                    }
                    $('#servico').val( data.servico );
                    $('#desc').val( hide );
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
            console.log("Erro: "+data.erro);

            if( data.erro == 0 ){
                if( data.situacao == 'C' ){
                    console.log('Situacao: '+data.situacao);

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
                $('#dataos').val(data.pedido);
                //console.log('Previsao: '+data.previsao);
                $('#previsao').val(data.previsao);
                console.log("Cadastro Solicitante: '"+data.solicitante+"'");
                $('#solicitante').val( data.solicitante ).trigger("chosen:updated");
                carregarComboSolicitante( data.solicitante );
                $('#setor').val(data.setor).trigger("chosen:updated");
                $('#tipoos').val(data.tipoos).trigger("chosen:updated");

                carregarComboMotivo( data.tipoos );
               // console.log("Motivo: "+data.motivo);
                $('#motivo').val( data.motivo ).trigger("chosen:updated");
                $('#oficina').val(data.oficina).trigger("chosen:updated");
                $('#descricao').val(data.descricao);
                $('#observacao').val(data.observacao);
                $('#responsavel').val(data.atendente).trigger("chosen:updated");
                $('#status').val(data.situacao).trigger("chosen:updated");
                setarValorComboStatus( data.situacao );
                $('#resolucao').val(data.resolucao);

                preencherTabelaServicos( data.situacao );

                verificarCampoChamado();

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
        $('#cdos').val("");
        $('#descricao').val("");
        $('#observacao').val("");
        $('#solicitante').val(0);
        $('#setor').val(0);
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


    function startCountdown(){

                setTimeout(function () {
                    preencherTabelaServicos('A');
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

                    if( data.retorno == 1 ){
                        sucesso();
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

