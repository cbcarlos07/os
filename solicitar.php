

<!DOCTYPE html>
<html>
   <?php
   echo "<title>Ordem de Servi&ccedil;o - Solicitar Chamado</title>";
   include "includes/head.php";


   $usuario     = $_SESSION['usuario'];
   $funcionario = $_SESSION['funcionario'];




   ?>

   <link href="css/font-awesome.css" rel="stylesheet">
   <link href="css/solicitar.css" rel="stylesheet">
   <link href="css/chosen.css" rel="stylesheet">
   <script src="js/jquery.min.js"></script>

   <script>
       $(document).ready(function () {
           $(window).load(function () {
               $('.linear-progress-material').fadeOut();
           })

       })

   </script>


  <body>
  <link href="css/load.css" rel="stylesheet" type="text/css" />
  <link href="css/bootstrap-chosen.css" rel="stylesheet" type="text/css" />
  <div class="linear-progress-material" style="display: block;">
      <div class="bar bar1"></div>
      <div class="bar bar2"></div>
  </div>
  <p class="alerta"></p>

  <div class="modal fade modal-remover" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <div class="linear-progress-material small load-modal">
                  <div class="bar bar1"></div>
                  <div class="bar bar2"></div>
              </div>
              <p class="alerta-modal"></p>

              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Remover exemplo</h4>
              </div>
              <div class="modal-body">
                  <p>Deseja realmente remover o exemplo <span class="texto-remover"></span>?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-sim">Sim</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <div class="modal fade modal-template" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <div class="linear-progress-material small load-modal">
                  <div class="bar bar1"></div>
                  <div class="bar bar2"></div>
              </div>
              <p class="alerta-modal"></p>

              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Salvar novo exemplo</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" id="cdtemplate" />
                      <label for="titulo-template">Informe um t&iacute;tulo para esse exemplo</label>
                      <input id="titulo-template" class="form-control" />
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-salvar-template">Salvar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- Modal informações adicionais -->
  <div id="addInf" class="modal fade" role="dialog">
      <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
              <div class="linear-progress-material small load-modal">
                  <div class="bar bar1"></div>
                  <div class="bar bar2"></div>
              </div>
              <p class="alerta-modal"></p>
              <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Informa&ccedil;&otilde;es Adicionais</h4>
              </div>
              <div class="modal-body">
                  <div class="col-md-12">
                      <!-- 222 = No produção
                      -->
                      <div class="form-group ">
                          <input type="hidden" id="tempoHora">
                          <input type="hidden" id="tempoMinuto">
                          <input type="hidden" id="codigoItem">
                          <input type="hidden" id="resp" value="<?= $funcionario ?>">
                          <input type="hidden" id="servico" value="222">
                          <input type="hidden" id="datai">
                          <input type="hidden" id="dataf">
                          <input type="hidden" id="total">
                          <input type="hidden" id="codOs">
                      </div>

                      <div class="form-group col-lg-12">
                          <label for="desc">Descreva as informa&ccedil;&otilde;es que queira adicionar</label>
                          <textarea id="desc" class="form-control"></textarea>
                      </div>

                      <div class="row "></div>


                  </div>
              </div>
              <div class="row"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-add-inf">Salvar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              </div>
          </div>

      </div>
  </div>



  <div class="modal fade " id="tela-ordem" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Status do Chamado</h4>
              </div>
              <div class="modal-body">



                  <div class="col-md-12" style="height: 600px; overflow: auto; font-size: small;">
                      <div class="form-group">
                          <label for="descos" class="col-md-4">Descri&ccedil;&atilde;o do Chamado:</label>
                          <div class="col-md-8">
                              <input class="form-control" id="descos">
                          </div>
                      </div>
                      <div class="row"></div>
                      <div class="form-group col-lg-12">
                          <label for="obs">Oberva&ccedil;&atilde;o</label>
                          <textarea id="obs" class="form-control"></textarea>
                      </div>

                      <div class="form-group">
                          <label for="nmusuario" class="col-md-4">Atendente:</label>
                          <div class="col-md-8">
                              <input class="form-control" id="nmusuario">
                          </div>
                      </div>
                      <div class="col-md-12"></div>
                      <div class="row "></div>
                      <div class="form-group">
                          <label for="status" class="col-md-4">Status:</label>
                          <div class="col-md-8">
                              <input class="form-control" id="status">
                          </div>
                      </div>

                      <div class="col-md-12"></div>
                      <div class="row "></div>

                      <div class="form-group col-md-12">
                          <label for="servicos">Servi&ccedil;os Realizados</label>
                          <div class="table" style="height: 150px; overflow: auto; font-size: small;">
                              <table class="table table-responsive table-hover">
                                  <thead>
                                    <th>Atendente</th>
                                    <th>Descri&ccedil;&atilde;o do Servi&ccedil;o</th>
                                    <th>Data</th>
                                  </thead>
                                  <tbody id="tbody-serv"></tbody>
                              </table>
                          </div>
                      </div>
                      <div class="row "></div>

                      <div class="form-group col-md-12">
                          <label for="servicos"><a href="#inf" class="lnk-add-inf">Adicionar Informa&ccedil;&otilde;es</a></label>
                          <div class="table" style="height: 150px; overflow: auto; font-size: small;">
                              <table class="table table-responsive table-hover table-inf">
                                  <thead id="theadInf"></thead>
                                  <tbody id="tbodyInf"></tbody>
                              </table>
                          </div>
                      </div>

                  </div>
              </div>
              <div class="row"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



  	<?php include "includes/cabecalho.php" ?>

   <div class="row"></div>




    <div class="page-content">
    	<div class="row">
		  <?php include "includes/barra_menu.php"?>
		  <div class="col-md-8 " style="background: #ffffff">

              <div>
                  <form class="formulario">


                      <input type="hidden" id="cdsetor" />
                      <input type="hidden" value="<?php echo $usuario ; ?>" id="usuario" />
                      <input type="hidden" value="<?php echo $funcionario ; ?>" id="funcionario" />
                      <div class="row"></div>
                      <div class="form-group ">
                          <label for="cdos" class="col-md-1 control-label">Cd OS</label>
                          <div class="col-md-2">
                              <input type="email" class="form-control" id="cdos" placeholder="C&oacute;d" disabled >
                          </div>
                      </div>

                      <div class="col-lg-12"></div>

                      <div class="form-group ">
                          <label for="solicitante" class="col-md-1 control-label">Solicitante<span style="color: red">*</span></label>
                          <div class="col-md-4">
                              <select  class="form-control" id="solicitante" data-placeholder="Selecione o solicitante">
                                  <option value="0"></option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group ">
                          <label for="setor" class="col-md-1 control-label">Setor</label>
                          <div class="col-md-6">
                              <select  class="form-control"  data-placeholder="Selecione o Setor" tabindex="2" id="setor" >
                                  <option value="0"></option>
                              </select>
                          </div>
                      </div>
                      <div class="col-lg-12"></div>
                      <div class="form-group ">
                          <label for="descricao" class="col-md-1 control-label">Descri&ccedil;&atilde;o</label>
                          <div class="col-md-8">
                              <input type="text" class="form-control" id="descricao" placeholder="Ex.: Impressora com problema" onblur="verificarCampo()" />
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="ramal" class="col-md-1 control-label">Ramal</label>
                          <div class="col-md-2">
                              <input type="text" class="form-control" id="ramal" placeholder="1404"  />
                          </div>
                      </div>
                      <div class="col-lg-12"></div>
                      <div class="form-group ">
                          <label for="observacao" class="col-md-1 control-label">Observa&ccedil;&atilde;o</label>
                          <div class="col-md-11">
                              <textarea id="observacao" class="form-control" placeholder="Ex.: Impressora apresentando uma mensagem REPLACE TONER com uma luz vermelha intermitente (piscando)
Meu IP: 192.168.1.1" onkeydown="verificarCampo()"></textarea>
                          </div>
                      </div>
                      <br>
                  </form>
                  <div class="form-group col-md-5 btn-acoes">
                      <label for="inputEmail3" class="col-md-3 control-label"></label>
                      <button class="btn btn-danger btn-salvar" ><i class="fa fa-save"></i></button>
                      <button class="btn btn-primary btn-limpar" ><i class="fa fa-paint-brush"></i></button>
                    <!--  <button class="btn btn-primary btn-template" ><i class="fa fa-folder-open"></i></button>-->
                  </div>
              </div>

              <div class="col-md-12">

                  <h4>Minhas Solicita&ccedil;&otilde;es</h4>
                  <hr />
                  <div  style="height: 400px; overflow: auto; font-size: small;">
                      <table class="table table-hover table-responsive tabela" >
                          <thead class="thead">
                             <th>#</th>
                             <th>Setor</th>
                             <th>Descri&ccedil;&atilde;o</th>
                             <th>Data Solicita&ccedil;&atilde;o</th>
                             <th>Status</th>
                             <th class='c1'></th>
                          </thead >
                          <tbody class="tbody">
                          </tbody>
                      </table>
                  </div>

              </div>
          </div>
            <div class="col-md-2" style="background: #ffffff;">
                <table class="table table-hover table-striped tabela-template">

                </table>
            </div>
		</div>
    </div>
    <?php include "includes/footer.php";?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->



    <?php include "includes/js_bottom.php" ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chosen.jquery.js"></script>
      <script>
          $('#setor').chosen( {allow_single_deselect: true} );
          $('#solicitante').chosen( {allow_single_deselect: true} );
      </script>
    <script src="js/solicitar.js"></script>
      <script>
          var enviar = false;



          function verificarCampo() {

              var solicitante = document.getElementById('solicitante').value;
              var descricao   = document.getElementById('descricao').value;
              var observacao  = document.getElementById('observacao').value;
              var setor       = document.getElementById('setor').value;

              if( ( solicitante.trim() != "") && (descricao.trim() != "") && ( observacao.trim() != "" ) && setor != 0 ){



                  $('.btn-salvar').removeClass('btn-danger');
                  $('.btn-salvar').addClass('btn-primary');
                  enviar = true;

              }else{
                  if( solicitante.trim() == "" ){
                      //console.log("campo solicitante está vazio");
                  }

                  if( descricao.trim() == "" ){
                   //   console.log("campo descricao está vazio");
                  }

                  if( observacao.trim() == "" ){
                     // console.log("campo observacao está vazio");
                  }

                  if( observacao.trim() == 0 ){
                     // console.log("Falta escolher um setor");
                  }

              }

          }

      </script>



  </body>
</html>