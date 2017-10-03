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
   
});



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
               acao  : 'M',
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
                       tbody.append(
                           "<tr>"+
                               "<td><a href='#'  onclick='obterCodigoOs("+ j.codigo +")'>"+ j.codigo + "</a></td>"+
                               "<td>"+ j.prioridade + "</td>"+
                               "<td>"+ j.setor + "</td>"+
                               "<td>"+ j.servico + "</td>"+
                               "<td>"+ j.solicitacao + "</td>"+
                               "<td>"+ j.espera + "</td>"+
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
                                       "<td><a href='#'  onclick='obterCodigoOs("+ j.codigo +")'>"+ j.codigo + "</a></td>"+
                                       "<td>"+ j.prioridade + "</td>"+
                                       "<td>"+ j.setor + "</td>"+
                                       "<td>"+ j.servico + "</td>"+
                                       "<td>"+ j.solicitacao + "</td>"+
                                       "<td>"+ j.espera + "</td>"+
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
  



function loadTotal(  ) {
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    carregarTotalRecebimentos();
    carregarTotalMeusChamados( usuario );
    carregarTotalMeusServicos( funcion );
}
