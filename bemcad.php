

<!DOCTYPE html>
<html>
   <?php
   echo "<title>Ordem de Servi&ccedil;o - Cadastrar Chamado</title>";
   include "includes/head.php";

   $_usuario = $_SESSION['usuario'];
   $_funcionario = $_SESSION['funcionario'];

   $cdOs = 0;
   if( isset($_POST['cdos']) ){
		$cdOs = $_POST['cdos'];
   }


   ?>

   <link href="css/font-awesome.css" rel="stylesheet">
   <link href="css/bootstrap-chosen.css" rel="stylesheet">
   <link href="css/solicitar.css" rel="stylesheet">

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
  <input type="hidden" id="usuario" value="<?= $_usuario ?>"/>
  <input type="hidden" id="funcionario" value="<?= $_funcionario ?>"/>
  <link href="css/load.css" rel="stylesheet" type="text/css" />

  <div class="linear-progress-material loading">
      <div class="bar bar1"></div>
      <div class="bar bar2"></div>
  </div>

  <div class="alerta"></div>

  <!-- modal pergunta -->

  <div class="modal fade modal-cancel" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Cancelar
              </div>
              <div class="modal-body">
                  Deseja realmenta cancelar esta opera&ccedil;&atilde;o?
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-sim">Sim</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <!-- fim modal pergunta -->



  	<?php include "includes/cabecalho.php" ?>




    <div class="page-content">
    	<div class="row">
		  <?php include "includes/barra_menu.php"?>
		  <div class="col-md-8 " style="background: #ffffff">
              
              <div class="col-md-11">
                  <form class="formulario" method="post" onsubmit="return false;">


                      <div class="col-md-12"></div>


                      <div class="form-group col-lg-3">
                          <input  type="hidden" id="acao" value="A"  />
                          <label for="codigo" >C&oacute;digo do Bem</label>
                          <input  class="form-control" id="codigo" name="codigo" placeholder="C&oacute;d" disabled />
                      </div>
                      <div class="row"></div>
                      <div class="form-group col-lg-5 item">
                          <label for="item" >Item</label>
                          <input  class="form-control" id="item" placeholder="Descri&ccedil;&atilde;o do Item" required  />
                      </div>

                      <div class="row"></div>
                      <div class="form-group col-lg-3 serie">
                          <label for="serie" >N&ordm; de S&eacute;rie</label>
                          <input  class="form-control" id="serie" placeholder="N&ordm; de S&eacute;rie" required  />
                      </div>

                      <div class="form-group col-lg-3 ">
                          <label for="tipo" >Tipo de Equipamento</label>
                          <select  class="form-control" id="tipo" data-placeholder="Tipo de Equipamentp" required>
                          </select>

                      </div>
                      <div class="col-lg-1">
                          <a href="#" class="refr-tipo"  title="Clique para atualizar"> <i class="fa fa-refresh" aria-hidden="true" style="margin-top: 30px;"></i> </a>
                      </div>

                      <div class="form-group col-lg-3 ">
                          <label for="fabricante" >Fabricante</label>
                          <select  class="form-control" id="fabricante" data-placeholder="Fabricante" required>
                              <option value=""></option>
                          </select>
                      </div>

                      <div class="col-lg-1">
                          <a href="#" class="refr-fabr"  title="Clique para atualizar"> <i class="fa fa-refresh" aria-hidden="true" style="margin-top: 30px;"></i> </a>
                      </div>



                      <div class="row"></div>
                      <!-- Painel para adicionar o historico -->
                      <div class="panel panel-default">
                          <div class="panel-body">

                              <div class="row"></div>
                              <div class="form-group col-lg-4 setor">
                                  <label for="setor" >Setor</label>
                                  <select  class="form-control" id="setor" data-placeholder="Selecione o setor" >
                                      <option value=''></option>
                                  </select>
                              </div>


                              <div class="form-group col-lg-4 localizacao">
                                  <label for="localidade" >Localiza&ccedil;&atilde;o</label>
                                  <select  class="form-control" id="localidade" data-placeholder="Selecione o local" >
                                      <option value=''></option>
                                  </select>
                              </div>
                              <div class="row"></div>
                              <div class="form-group col-lg-3 data">
                                  <label for="datain" >Data de Entrada</label>
                                  <input  class="form-control" id="datain" placeholder="Data de Entrada"   />
                              </div>
                              <div class="form-group col-lg-5 responsavel">
                                  <label for="responsavel" >Respons&aacute;vel</label>
                                  <select  class="form-control" id="responsavel" data-placeholder="Respons&aacute;vel"  >
                                      <option value=''></option>
                                  </select>
                              </div>

                              <a href="#" class="btn btn-primary btn-adicionar"  style="margin-top: 20px;">Adicionar</a>



                              <br />
                              <br />
                              <br />
                              <div class="row">
                                  <span class="table_error" style="color: red; text-align: center" ></span>
                                  <table class="table table-responsive table-stripped">
                                      <thead>
                                        <tr>
                                            <th>Nome Setor</th>
                                            <th>Nome Localidade</th>
                                            <th>Data Entrada</th>
                                            <th>Respons&aacute;vel</th>
                                        </tr>
                                      </thead>
                                      <tbody class="tbody">

                                      </tbody>
                                  </table>
                              </div>

                          </div>
                      </div>
                      <!-- Painel para adicionar o historico -->

                      <div class="row"></div>
                      <div class="form-group col-lg-5 ">
                          <label for="proprietario" >Propriet&aacute;rio</label>
                          <select  class="form-control" id="proprietario"  data-placeholder="Selecione o Propriet&aacute;rio" required>
                              <option value=''></option>
                          </select>
                      </div>
                      <div class="col-lg-1">
                          <a href="#" class="refr-fornecedor"  title="Clique para atualizar"> <i class="fa fa-refresh" aria-hidden="true" style="margin-top: 30px;"></i> </a>
                      </div>

                      <div class="row"></div>
                      <div class="form-group col-lg-5 patrimonio">
                          <label for="patrimonio" >N&uacute;mero do Patrim&ocirc;nio</label>
                          <input  class="form-control" id="patrimonio" name="patrimonio" placeholder="N&uacute;mero do Patrim&ocirc;nio" required  />
                      </div>
                      <div class="row"></div>
                      <div class="col-lg-12">
                          <button type="submit" class="btn btn-success btn-salvar">Salvar</button>
                          <a href="#" class="btn btn-warning btn-cancelar">Cancelar</a>
                      </div>


                  </form>
              </div>

           </div>
            <br>

		</div>
    </div>


    <?php include "includes/footer.php";?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->



    <?php include "includes/js_bottom.php" ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.datetimepicker.full.js"></script>
    <script src="js/chosen.jquery.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/bemcad.js"></script>
    <script>
          $('#localidade').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );
          $('#setor').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );
          $('#tipo').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );
          $('#fabricante').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );
          $('#responsavel').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );
          $('#proprietario').chosen( {
              allow_single_deselect: true,
              search_contains: true,
              no_results_text: "Nenhum resultado enontrado!"
          } );

    </script>




  </body>
</html>