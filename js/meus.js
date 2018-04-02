/**
 * Created by carlos.bruno on 28/08/2017.
 */

$(document).ready(function () {

    var usuario = $('#usuario').val();
   carregarComboResponsavel( usuario  );
   carregarComboSolcitante();
   carregarComboOficina();
   carregarComboSetor();
   carregarTabela();
   loadTotal();
   startCountdown();
});

var tempo = new Number();
// Tempo em segundos
tempo = 30;

var tempoPause = false;
function startCountdown(){
    //alert("Pause: "+tempoPause);
    if( !tempoPause ){
        // alert("Pause: "+tempoPause);
        // Se o tempo não for zerado
        if((tempo - 1) >= 0){

            // Pega a parte inteira dos minutos
            var min = parseInt(tempo/60);
            // Calcula os segundos restantes
            var seg = tempo%60;

            var texto = " segundos para atualizar";
            if( seg < 2 ){
                texto = " segundo para atualizar";
            }

            // Formata o número menor que dez, ex: 08, 07, ...
            if(min < 10){
                min = "0"+min;
                min = min.substr(0, 2);
            }
            if(seg <=9){
                seg = "0"+seg;
            }



            // Cria a variável para formatar no estilo hora/cronômetro

            horaImprimivel =  seg + texto;
            //JQuery pra setar o valor
            $("#sessao").html(horaImprimivel);

            // Define que a função será executada novamente em 1000ms = 1 segundo
            setTimeout('startCountdown()',1000);

            // diminui o tempo
            tempo--;



            // Quando o contador chegar a zero faz esta ação
        } else {
            tempo = 30;
            //window.open('../controllers/logout.php', '_self');
            preencherTabela();

            startCountdown();
        }
    }


}

// Chama a função ao carregar a tela


function atualizarAgora() {
    tempo = 30;
    preencherTabela();
    startCountdown()


}

function pausar(valor) {
    // alert('Pausar: '+valor+" tipo: "+typeof valor);
    console.log('Pausar: '+valor+" tipo: "+typeof valor);
    tempoPause = valor;
    startCountdown();
}


$('#oficina').on('change', function(){
    $('#oficina_chosen').removeClass( 'required' );
   // console.log( "Combo oficina:"+$(this).val() );
    if( $(this).val() != '%' ){
        console.log( "É pra remover title" );
        $('#oficina_chosen').removeAttr( 'title' );
        hideToolTip( 'oficina_chosen' );
    }
	preencherTabela();
});
$('#setor').on('change', function(){
	preencherTabela();
});

$('#responsavel').on('change', function(){
	preencherTabela();
});

$('#solicitante').on('change', function(){
	preencherTabela();
});

$('#cdos').on('keypress', function (e) {
    if( e.keyCode == 13 ){
        e.preventDefault();
        preencherTabela();
    }
});

function carregarComboResponsavel( usuario ){
    $.ajax({
        url      : 'funcao/responsavel.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao   : 'U'
        },
        success : function (data) {

            // console.log(data);
//            $('#responsavel').append( $('<option />').val( '%' ).text( "SELECIONE" ) );
			
            $.each( data.usuarios, function (key, value) {

                var option  = "<option value='"+ value.cdusuario +"'>"
                    + value.nome
                    +"</option> ";

                $('#responsavel').append(option);

            } );
            $('#responsavel').val( usuario ).trigger("chosen:updated");
        }

    });

}




function carregarComboOficina(  ){
   // console.log("Combo oficina");
    var oficina = $('#oficina');
    $.ajax({
        url      : 'funcao/oficina.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao : 'L'
        },
        success : function (data) {
			//oficina.append( $('<option />').val( '%' ).text('SELECIONE') );
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
            /*var op = $("<option>").val('%').text('SELECIONE');
            $('#solicitante').append(op);*/
            // console.log(data);
            $.each( data.usuarios, function (key, value) {

                var option  = $('<option>').val( value.usuario ).text( value.nome ) ;

                $('#solicitante').append(option);

            } );
            //$('#solicitante').val( $('#usuario').val() ).trigger("chosen:updated");
            $('#solicitante').trigger("chosen:updated");
            // buscarLastSolicitante( $('#solicitante').val() );


        }

    });

}


function carregarComboSetor(  ){
    var setor = $('#setor');
    $.ajax({
        url      : 'funcao/setor.php',
        type     : 'post',
        dataType : 'json',
        data : {
            acao : 'S'
        },
        success : function (data) {
          /*  var op = $("<option>").val('%').text('SELECIONE');
            setor.append(op);*/

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


$("#datai").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    mask: true,
    locale: 'pt-br'
});

$("#dataf").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    mask: true,
    locale: 'pt-bR'
});

$('#chk_sit').on('click', function () {
    if( $(this).is(":checked") ){
         pausar( false );
         $('.datas').fadeOut();
    }else{
        pausar( true );
        $('.datas').fadeIn();
    }
});

  $('#datai').on('blur', function () {
      if( $(this).val() != "__/__/____" ){
          $('input[id="datai"]').css("border-color", '');
      }
  });

    $('#dataf').on('blur', function () {
        if( $(this).val() != "__/__/____" ){
            $('input[id="datai"]').css("border-color", '');
        }
    });

  $('.btn-consultar').on('click', function () {
        var inicio = $('#datai').val();
        var fim    = $('#dataf').val();
        var oficina = $('#oficina').val();
        console.log("data inicio: "+inicio);
        if( ( ( inicio == "__/__/____" ) || inicio == "" ) || ( ( fim == "__/__/____" ) || ( fim == "" ) ) || ( oficina == '%' )){
            if( ( inicio == "__/__/____" ) || ( inicio == "" ) ){
                $('input[id="datai"]').css("border-color", 'red');
            }



            if( ( fim == "__/__/____" ) || ( fim == "" ) ) {
                $('input[id="dataf"]').css("border-color", 'red');
            }

            if( oficina == '%' ){
                var combo = $('#oficina_chosen');
                combo.addClass( 'required' );
                combo.attr( 'title', 'Escolha uma oficina' );
                chamarTooltip( 'oficina_chosen' );
            }
        }else{
            $('input[id="datai"]').css("border-color", '');
            $('input[id="dataf"]').css("border-color", '');
            $('#oficina_chosen').removeClass( 'required' );
            preencherTable();
        }
  });

    function preencherTable(  ) {
       // console.log("Era pra preencher tabela");
        var codigo      = $('#cdos').val();
        var oficina     = $('#oficina').val();
        var solicitante = $('#solicitante').val();
        var responsavel = $('#responsavel').val();
        var setor       = $('#setor').val();
        var inicio      = $('#datai').val();
        var fim         = $('#dataf').val();

        if( codigo.trim() == "" ){
            codigo = "%";
        }
        /*
        console.log( "Oficina: "+oficina );
        console.log( "Solicitante: "+solicitante );
        console.log( "Responsavel: "+responsavel );
        console.log( "Setor: "+setor );
        */

        $.ajax({
            url   : 'funcao/os.php',
            type  : 'post',
            dataType : 'json',
            beforeSend : aguardandoPesquisar,
            data : {
                acao  : 'Q',
                cdos  : codigo,
                oficina : oficina,
                solicitante : solicitante,
                responsavel : responsavel,
                setor       : setor,
                inicio      : inicio,
                fim         : fim

            },
            success : function (data) {
                var btn = $('.btn-consultar');
                btn.empty().html('Consultar');
                var tbody = $('#t-meus');
                tbody.find('tr').remove();
                $.each( data, function (i, j) {
                    var cor = "";
                    var title = "";
                    if( j.situacao == 'C' ) {
                        cor = "#B2EBF2";
                        title = "Conclu&iacute;do";
                    }
                    tbody.append(
                        "<tr bgcolor='"+ cor +"'>"+
                            "<td><a href='#' title='"+ title +"' onclick='obterCodigoOs("+ j.codigo +")'>"+ j.codigo + "</a></td>"+
                            "<td>"+ j.prioridade + "</td>"+
                            "<td>"+ j.setor + "</td>"+
                            "<td>"+ j.responsavel + "</td>"+
                            "<td>"+ j.servico + "</td>"+
                            "<td>"+ j.solicitacao + "</td>"+
                            "<td>"+ j.espera + "</td>"+
                        "</tr>"
                    );
                });

            }
        });



    }
    
    function aguardandoPesquisar() {
         var btn = $('.btn-consultar');
         btn.empty().html('<img src="images/loading.gif" width="20">');

    }

  function preencherTabela(  ) {
    //  console.log("Era pra preencher tabela");
      var codigo      = $('#cdos').val();
      var oficina     = $('#oficina').val();
      var solicitante = $('#solicitante').val();
      var responsavel = $('#responsavel').val();
      var setor       = $('#setor').val();

      if( codigo.trim() == "" ){
          codigo = "%";
      }

   /*   console.log( "Oficina: "+oficina );
      console.log( "Solicitante: "+solicitante );
      console.log( "Responsavel: "+responsavel );
      console.log( "Setor: "+setor );
*/

      $.ajax({
           url   : 'funcao/os.php',
           type  : 'post',
           dataType : 'json',
           data : {
               acao  : 'M',
               cdos  : codigo,
               oficina : oficina,
               solicitante : solicitante,
               responsavel : responsavel,
               setor       : setor

           },
          success : function (data) {
                 //console.log( data );
                 var tbody = $('#t-meus');
                 tbody.find('tr').remove();
                 $.each( data, function (i, j) {
                       tbody.append(
                           "<tr>"+
                               "<td><a href='#'  onclick='obterCodigoOs("+ j.cd_os +")'>"+ j.cd_os + "</a></td>"+
                               "<td>"+ j.prioridade + "</td>"+
                               "<td>"+ j.nm_setor + "</td>"+
                               "<td>"+ j.cd_responsavel + "</td>"+
                               "<td>"+ j.ds_servico + "</td>"+
                               "<td>"+ j.dt_pedido + "</td>"+
                               "<td>"+ j.time_ + "</td>"+
                           "</tr>"
                       );
                 });

          }
      });



  }
  
   $('.btn-limpar').on('click', function(){
	   carregarTabela();
	   $("#setor").val( '%' ).trigger( "chosen:updated" );
   }); 
  function carregarTabela(  ){
	  
	  var usuario = $('#usuario').val();

	  $.ajax({
		  url : 'funcao/os.php',
		  type : 'post',
		  dataType : 'json',
		  data : {
			  acao : 'S',
			  usuario : usuario
		  },
		  success : function( data ){
			  //var oficina = data.oficina;
			  //$('#oficina').val( oficina ).trigger("chosen:updated");
			  
			  
			 $.ajax({
				   url   : 'funcao/os.php',
				   type  : 'post',
				   dataType : 'json',
				   data : {
					   acao  : 'M',
					   cdos  : '%',
					   oficina : '%',
					   solicitante : '%',
					   responsavel : usuario,
					   setor       : '%'

				   },
				  success : function (data) {
						 var tbody = $('#t-meus');
						 tbody.find('tr').remove();
						 $.each( data, function (i, j) {
							   tbody.append(
                                   "<tr>"+
                                       "<td><a href='#'  onclick='obterCodigoOs("+ j.cd_os +")'>"+ j.cd_os + "</a></td>"+
                                       "<td>"+ j.prioridade + "</td>"+
                                       "<td>"+ j.nm_setor + "</td>"+
                                       "<td>"+ j.cd_responsavel + "</td>"+
                                       "<td>"+ j.ds_servico + "</td>"+
                                       "<td>"+ j.dt_pedido + "</td>"+
                                       "<td>"+ j.time_ + "</td>"+
                                   "</tr>"
							   );
						 });
						 
						

				  }
			  });
			  
			  
			  
		  } 
	  });



  }

  function obterCodigoOs( id ){
	  console.log('obterCodigoOs');
	  var formulario = $('<form action="cadastro2.php" method="post">'+
													'<input type="hidden" name="cdos" value="'+ id +'">'+
												'</form>');
	$('body').append(formulario);
	formulario.submit();	
  }
  
  function valorCampo( valor ) {
      var campo = "%";
	  
      if( valor != 0 ){
         campo = valor;
      }

      return campo;
  }
  



function loadTotal(  ) {
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    loadTotalMenu( usuario, funcion );


    setTimeout( function(){
        loadTotal();
    },30000 );
}
