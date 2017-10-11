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


$('#oficina').on('change', function(){
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
            acao   : 'G'
        },
        success : function (data) {
            var codigo = 0;
            // console.log(data);
          //  $('#responsavel').append( $('<option />').val( '' ) );
			
            $.each( data.funcionarios, function (key, value) {
                if( usuario == value.nome )
                    codigo = value.codigo;
                var option  = "<option value='"+ value.codigo +"'>"
                    + value.nome
                    +"</option> ";

                $('#responsavel').append(option);

            } );
            $('#responsavel').val( codigo ).trigger("chosen:updated");
        }

    });

}




function carregarComboOficina(  ){
    console.log("Combo oficina");
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
          //  var op = $("<option>").val('%').text('SELECIONE');
        //    $('#solicitante').append(op);
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
          //  var op = $("<option>").val('%').text('SELECIONE');
         //   setor.append(op);

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


  function preencherTabela(  ) {
      console.log("Era pra preencher tabela");
      var codigo      = $('#cdos').val();
      var oficina     = $('#oficina').val();
      var solicitante = $('#solicitante').val();
      var responsavel = $('#responsavel').val();
      var setor       = $('#setor').val();

      if( codigo.trim() == "" ){
          codigo = "%";
      }

      console.log( "Oficina: "+oficina );
      console.log( "Solicitante: "+solicitante );
      console.log( "Responsavel: "+responsavel );
      console.log( "Setor: "+setor );


      $.ajax({
           url   : 'funcao/os.php',
           type  : 'post',
           dataType : 'json',
           data : {
               acao  : 'F',
               cdos  : codigo,
               oficina : oficina,
               solicitante : solicitante,
               responsavel : responsavel,
               setor       : setor

           },
          success : function (data) {
                 var tbody = $('#t-meus');
                 tbody.find('tr').remove();
                 $.each( data, function (i, j) {
                      var status = "";
                      if( j.status == "VERDE" ){
                          status = "<img src='images/green.png' width='25'>"
                      }else if( j.status == "AMARELO" ){
                          status = "<img src='images/yellow.png' width='25'>"
                      }else if( j.status == "VERMELHO" ){
                          status = "<img src='images/red.png' width='25'>"
                      }


                       tbody.append(
                           "<tr>"+
                               "<td><a href='#'  onclick='obterCodigoOs("+ j.codigo +")'>"+ j.codigo + "</a></td>"+
                               "<td>"+ j.chamado + "</td>"+
                               "<td>"+ j.responsavel + "</td>"+
                               "<td>"+ j.servico + "</td>"+
                               "<td>"+ j.descricao.replace("#HIDE#","") + "</td>"+
                               "<td>"+ j.inicio + "</td>"+
                               "<td align='center'>"+ status + "</td>"+
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
	  
	  var usuario = $('#funcionario').val();
	  console.log("Funcionario: "+usuario);

			  
			 $.ajax({
				   url   : 'funcao/os.php',
				   type  : 'post',
				   dataType : 'json',
				   data : {
					   acao  : 'F',
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
                             var status = "";
                             if( j.status == "VERDE" ){
                                 status = "<img src='images/green.png' width='25'>"
                             }else if( j.status == "AMARELO" ){
                                 status = "<img src='images/yellow.png' width='25'>"
                             }else if( j.status == "VERMELHO" ){
                                 status = "<img src='images/red.png' width='25'>"
                             }

                             tbody.append(
								   "<tr>"+
                                       "<td><a href='#'  onclick='obterCodigoOs("+ j.codigo +")'>"+ j.codigo + "</a></td>"+
                                       "<td>"+ j.chamado + "</td>"+
                                       "<td>"+ j.responsavel + "</td>"+
                                       "<td>"+ j.servico + "</td>"+
                                       "<td>"+ j.descricao.replace("#HIDE#","") + "</td>"+
                                       "<td>"+ j.inicio + "</td>"+
                                       "<td>"+ status + "</td>"+
								   "</tr>"
							   );
						 });
						 
						

				  }
			  });
			  

  }


function loadTotal(  ) {
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    carregarTotalRecebimentos();
    carregarTotalMeusChamados( usuario );
    carregarTotalMeusServicos( funcion );

    setTimeout(function () {
        loadTotal();
    } , 30000);
}


function obterCodigoOs( id ){
	  console.log('obterCodigoOs');
	  var formulario = $('<form action="cadastro.php" method="post">'+
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
  

