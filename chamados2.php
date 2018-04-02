

<!DOCTYPE html>
<html>
   <?php
   echo "<title>Ordem de Servi&ccedil;o - Cadastrar Chamado</title>";
   include "includes/head.php";

   $usuario = $_SESSION['usuario'];
   $funcionario = $_SESSION['funcionario'];

   $cdOs = 0;
   if( isset($_POST['cdos']) ){
		$cdOs = $_POST['cdos'];
   }


   ?>

   <link href="css/font-awesome.css" rel="stylesheet">
   <link href="css/bootstrap-chosen.css" rel="stylesheet">
   <link href="css/solicitar.css" rel="stylesheet">
   <link href="css/chosen.css" rel="stylesheet">
   <link href="css/jquery.datetimepicker.min.css" rel="stylesheet" type="text/css">
   <script src="js/jquery.min.js"></script>


<script>
    $(document).ready(function () {
        $(window).load(function () {
            $('.loading').fadeOut();
        })
    })
</script>

  <body>
  <link href="css/load.css" rel="stylesheet" type="text/css" />
  <link href="css/bootstrap.fd.css" rel="stylesheet" type="text/css" />
  <div class="linear-progress-material loading">
      <div class="bar bar1"></div>
      <div class="bar bar2"></div>
  </div>

  <div class="alerta"></div>

  <!-- modal pergunta -->

  <div class="modal fade modal-delete" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="linear-progress-material small load-modal">
                  <div class="bar bar1"></div>
                  <div class="bar bar2"></div>
              </div>
              <p class="alerta-modal"></p>
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><span class="titulo-modal-remover"></span></h4>
              </div>
              <div class="modal-body">
                  <p class="msg-delete"></span></p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-sim">Sim</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <!-- fim modal pergunta -->



  <div class="modal fade modal-servico" id="tela-servico" role="dialog" data-backdrop="static">
      <div class="modal-dialog" role="document">

          <div class="modal-content">
              <div class="linear-progress-material small load-modal">
                  <div class="bar bar1"></div>
                  <div class="bar bar2"></div>
              </div>
              <p class="alerta-modal"></p>
              <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Adicionar Servi&ccedil;o</h4>
              </div>
              <div class="modal-body">
                  <div class="col-md-12">
                      <div class="form-group ">
                          <input type="hidden" id="tempoHora">
                          <input type="hidden" id="tempoMinuto">
                          <input type="hidden" id="codigoItem">
                          <label for="resp" class="col-md-2 control-label">Respons&aacute;vel <span style="color: red;">*</span></label>
                          <div class="col-md-4">
                              <select  class="form-control"   tabindex="14" id="resp" data-placeholder="Selecione um funcion&aacute;rio"><option value="0"></option></select>
                          </div>
                          <div class="form-group">
                              <label for="dios" class="col-md-2 control-label" style="text-align: right">In&iacute;cio da OS</label>
                              <div class="col-md-4">
                                  <input id="dios" class="form-control" disabled>
                              </div>

                          </div>
                      </div>

                      <div class="row"></div>
                      <div class="form-group ">
                          <label for="servico" class="col-md-2 control-label" title="Tipo de Servi&ccedil;o">Servi&ccedil;o <span style="color: red;">*</span></label>
                          <div class="col-md-4">
                              <select  class="form-control"  tabindex="15" id="servico" data-placeholder="Escolha um servi&ccedil;o">
                                  <option value="0"></option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group col-lg-12"></div>
                      <div class="row"></div>
                      <div class="form-group col-lg-12">
                          <label for="desc">Descri&ccedil;&atilde;o</label>
                          <textarea id="desc" class="form-control" tabindex="16"></textarea>
                      </div>
                        <div class="row"></div>
                  <!--    <div class="form-group col-md-4" >
                          <label for="snfeito" >Servi&ccedil;o Feito?</label>
                          &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="snfeito" value="S"/>

                      </div>-->

                      <div class="form-group col-md-6" >
                          <label for="snvisualiza">Cliente n&atilde;o visualiza?</label>
                          &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="snvisualiza" value="S" checked tabindex="17"/>

                      </div>

                      <div class="col-md-12"></div>

                      <div class="form-group ">
                          <label for="datai" class="col-md-2 control-label">In&iacute;cio Servi&ccedil;o <span style="color: red;">*</span></label>
                          <div class="col-md-4">
                              <input type="text" class="form-control" id="datai" data-toggle="tooltip" data-html="true" data-placement="left" tabindex="18">
                          </div>
                      </div>

                      <div class="form-group ">
                          <label for="dataf" class="col-md-2 control-label">Fim do Servi&ccedil;o</label>
                          <div class="col-md-4">
                              <input type="text" class="form-control" id="dataf" tabindex="19">
                          </div>
                      </div>
                      <div class="row"></div>
                      <div class="col-lg-12"></div>

                      <div class="form-group ">
                          <label for="total" class="col-md-2 control-label">Total</label>
                          <div class="col-md-3">
                              <input type="text" class="form-control" id="total" disabled >
                          </div>
                      </div>

                      <div class="col-md-12"></div>
                      <div class="row "></div>


                  </div>
              </div>
              <div class="row"></div>
              <div class="modal-footer">
                  <div class="btn-group">
                      <button type="button" class="btn btn-danger btn-salvar-servico" title="Preencha todos campos obrigat&oacute;rios" disabled>Salvar</button>
                      <button type="button" class="btn btn-danger btn-salvar-novo" title="Salvar e adicionar outro" disabled>+</button>
                  </div>

                  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



  	<?php include "includes/cabecalho.php" ?>




    <div class="page-content">
    	<div class="row">
		  <?php include "includes/barra_menu.php"?>
		  <div class="col-md-8 " style="background: #ffffff">
              
              <div class="col-md-11">
                  <form class="formulario">

                      <input type="hidden"  id="cdsetor" />
                      <input type="hidden" value="<?php echo $usuario ; ?>" id="usuario" />
                      <input type="hidden" value="<?php echo $funcionario ; ?>" id="funcionario" />
                      <input type="hidden" value="" id="bem" />
                      <input type="hidden" value="" id="localidade" />
                      <input type="hidden" value="" id="fornecedor" />
                      <div class="col-md-12"></div>


                      <div class="form-group ">
                          <label for="cdos" class="col-md-1 control-label">Cd OS</label>
                          <div class="col-md-2">
                              <input type="text" class="form-control" id="cdos" placeholder="C&oacute;d" disabled value="<?= $cdOs ?>">
                          </div>
                      </div>

                      <div class="form-group ">
                          <label for="dataos" class="col-md-1 control-label">Data Os</label>
                          <div class="col-md-3">
                              <input type="text" class="form-control" id="dataos" tabindex="1" disabled>
                          </div>
                      </div>

                      <div class="form-group ">
                          <label for="previsao" class="col-md-2 control-label" title="Previs&atilde;o de entrega">Prev de Entrega</label>
                          <div class="col-md-3">
                              <input type="text" class="form-control" id="previsao" tabindex="2">
                          </div>
                      </div>

                      <div class="col-md-12"></div>

                      <div class="form-group ">
                          <label for="solicitante" class="col-md-1 control-label" id="labelsolicitante" data-toggle="tooltip" data-placement="top" data-html="true">Solicitante<span style="color: red">*</span></label>
                          <div class="col-md-4">
                              <input placeholder="Selecione o solicitante" class="form-control" id="solicitante" tabindex="3" disabled />
                          </div>
                      </div>

                      <div class="form-group ">
                          <label for="setor" class="col-md-1 control-label">Setor<span style="color: red">*</span></label>
                          <div class="col-md-4">
                              <select  class="form-control"  data-placeholder="Selecione o Setor"  id="setor" tabindex="4">
                                  <option value="0"></option></select>
                          </div>
                      </div>

                      <div class="col-md-12"></div>



                      <div class="form-group ">
                          <label for="plaqueta" class="col-md-1 control-label">N&ordm; do Patrim&ocirc;nio</label>
                          <div class="col-md-2">
                              <select id="plaqueta" data-placeholder="N&ordm; do Patrim&ocirc;nio" class="form-control" tabindex="5">
                                  <option value=""></option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="descbem" class="col-md-1 control-label">Bem Patrimonial</label>
                          <div class="col-md-4">
                              <input id="descbem" placeholder="Bem Patrimonial" class="form-control" tabindex="6">
                          </div>
                      </div>

                      <div class="col-md-12"></div>
                      <div class="form-group ">
                          <label for="tipoos" class="col-md-1 control-label">Tipo OS</label>
                          <div class="col-md-3">
                              <select  class="form-control"  tabindex="7" id="tipoos" data-placeholder="Selecione o tipo de OS">
                                  <option value="0"></option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group ">
                          <label for="motivo" class="col-md-1 control-label">Motivo</label>
                          <div class="col-md-3">
                              <select  class="form-control"  data-placeholder="Selecione o Motivo" tabindex="8" id="motivo" ><option value="%"></option></select></select>
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="oficina" class="col-md-1 control-label">Oficina</label>
                          <div class="col-md-3">
                              <select  class="form-control"  id="oficina" data-placeholder="Selecione" tabindex="7">
                                  <option value="0"></option></select>
                          </div>
                      </div>

                      <div class="col-lg-12"></div>
                      <div class="form-group ">
                          <label for="descricao" class="col-md-1 control-label">Descri&ccedil;&atilde;o</label>
                          <div class="col-md-8">
                              <input type="text" class="form-control" id="descricao" tabindex="8" placeholder="Ex.: Impressora com problema" disabled />
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="ramal" class="col-md-1 control-label">Ramal</label>
                          <div class="col-md-2">
                              <input type="text" class="form-control" id="ramal" placeholder="1404"  tabindex="9"/>
                          </div>
                      </div>
                      <div class="col-md-12"></div>
                      <div class="form-group ">
                          <label for="observacao" class="col-md-1 control-label">Observa&ccedil;&atilde;o<span style="color: red">*</span></label>
                          <div class="col-md-11">
                              <textarea id="observacao" class="form-control" placeholder="Ex.: Impressora apresentando uma mensagem REPLACE TONER com uma luz vermelha intermitente (piscando)" tabindex="10"></textarea>
                          </div>
                      </div>
                      <div class="col-md-12"></div>
                      <div class="form-group ">
                          <label for="responsavel" class="col-md-1 control-label" title="Respons&aacute;vel">Respons&aacute;vel<span style="color: red">*</span></label>
                          <div class="col-md-3">
                              <select  class="form-control"  tabindex="11" id="responsavel" data-placeholder="Selecione" >
                                  <option value="%"></option></select>
                          </div>
                      </div>

                      <div class="form-group ">
                          <label for="status" class="col-md-1 control-label">Status</label>
                          <div class="col-md-3">
                              <select  class="form-control"  tabindex="12" id="status" >
                                  <option value="A">Aberto</option>
                                  <option value="C">Conclu&iacute;do</option>
                                  <option value="N">N&atilde;o Atendido</option>
                                  <option value="M">Aguardando Material</option>
                                  <option value="E">Conserto Externo</option>
                                  <option value="S">Solicita&ccedil;&atilde;o</option>
                                  <option value="L">Aguardando Libera&ccedil;&atilde;o do Setor</option>
                                  <option value="F">Agendar</option>
                                  <option value="D">Cancelada</option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group ">
                          <label for="resolucao" class="col-md-1 control-label" title="Resolu&ccedil;&atilde;o Final">Res. Final</label>
                          <div class="col-md-3">
                              <input type="text" class="form-control" id="resolucao" placeholder="Ex.: Atendimento finalizado com sucesso" tabindex="13">
                          </div>
                      </div>

                      <br>
                  </form>
              </div>
				<div class="form-group col-md-5 btn-acoes">
                  <label for="inputEmail3" class="col-md-3 control-label"></label>
                  <button class="btn btn-primary btn-salvar" ><i class="fa fa-save"></i></button>
                  <button class="btn btn-primary btn-limpar" title="Limpar campos" ><i class="fa fa-paint-brush"></i></button>
                  <button class="btn btn-primary btn-pesquisar" title="Pesquisar por c&oacute;digo"><i class="fa fa-search"></i></button>
              </div>
              <div class="col-md-10">

                  Servi&ccedil;o <button class="btn-xs btn btn-danger btn-servico" title="Adicionar servi&ccedil;o" ><i class="fa fa-plus"></i></button>
                  <hr />
              </div>

              <div class="col-md-12">
                  <div class="panel with-nav-tabs panel-default">
                      <div class="panel-heading">
                          <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab1default" data-toggle="tab">Servi&ccedil;os</a></li>
                              <li><a href="#tab2default" data-toggle="tab">Documento</a></li>


                          </ul>
                      </div>
                      <div class="panel-body">
                          <div class="tab-content">
                              <div class="tab-pane fade in active" id="tab1default">
                                  <table class="table table-hover table-responsive tabela " >
                                      <thead class="thead">
                                      <th>C&oacute;digo</th>
                                      <th>Servi&ccedil;o</th>
                                      <th>Funcion&aacute;rio</th>
                                      <th>Descri&ccedil;&atilde;o</th>
                                      <th>Data In&iacute;cio</th>
                                      <th>Data Final</th>
                                      <th>Tempo Total</th>
                                      <th class='c1'></th>
                                      </thead >
                                      <tbody class="tbody">
                                      </tbody>
                                  </table>
                              </div>
                              <div class="tab-pane fade" id="tab2default">

                                  <div style="text-align: center">
                                      <div id="output"></div>
                                      <button class="btn btn-success btn-doc">Adicionar documento <i class="fa fa-paperclip" aria-hidden="true"></i> </button>

                                  </div>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>




        </div>

           <!-- <div class="col-md-2" style="background: #ffffff">
                <table class="table table-hover table-striped tabela-chamados">

                </table>
            </div>-->

		</div>
    </div>

  <!-- Modal -->
  <div id="modalDoc" class="modal fade" role="dialog">
      <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Adicioanr Documento</h4>
              </div>
              <div class="modal-body">

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              </div>
          </div>

      </div>
  </div>
    <?php include "includes/footer.php";?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->



    <?php include "includes/js_bottom.php" ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.datetimepicker.full.js"></script>
    <script src="js/chosen.jquery.js"></script>
    <script src="js/bootstrap.fd.js"></script>
    <script src="js/chamados2.js"></script>
    <script>

         /* $('#solicitante').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );*/

          $('#plaqueta').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );

          $('#setor').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );
          $('#tipoos').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );
          $('#motivo').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );
          $('#oficina').chosen(
              {
                  allow_single_deselect: true,
                  search_contains: true,
                  no_results_text: "Nenhum resultado enontrado!"
              }
          );


          $('#responsavel').chosen( {allow_single_deselect: true} );
          $('#status').chosen( {allow_single_deselect: true} );
          $('.modal-servico').on('shown.bs.modal', function () {
              $('#resp', this).chosen('destroy').chosen( {allow_single_deselect: true} );
              $('#servico', this).chosen('destroy').chosen( {allow_single_deselect: true} );
              $('#servico').trigger('chosen:activate');
              // console.log("User: "+$('#usuario').val());
              // $('#resp').text( $('#usuario').val() ).trigger("chosen:updated");
          });

          function chamarTooltip( id ) {
              $('#'+id).tooltip('show');

              /* $('#datai').tooltip({
               'trigger': 'manual',    // chamada manual
               'title': 'A data do servi&ccedil;o n&atilde;o pode ser menor do que a data da cria&ccedil;&atilde;o da ordem de servi&ccedil;o',  // texto da tooltip
               'placement': 'left'      // localização da tooltip

               }).tooltip('show')*/;
          }


    </script>



  </body>
</html>