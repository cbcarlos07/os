



<!DOCTYPE html>
<html lang="pt_BR">

  <?php
  echo "<title>Ordem de Servi&ccedil;o - Bem</title>";
  include "includes/head.php" ;

  $_usuario = $_SESSION['usuario'];
  $_funcionario = $_SESSION['funcionario'];

  ?>

  <meta charset="UTF-8">
  <script src="js/jquery.min.js"></script>

  <script>
      $(document).ready(function () {
          $(window).load(function () {
              $('.linear-progress-material').fadeOut();
          })

      })

  </script>
  <body>
  <input type="hidden" id="usuario" value="<?= $_usuario ?>"/>
  <input type="hidden" id="funcionario" value="<?= $_funcionario ?>"/>
  <div class="modal fade" id="delete" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Remover</h4>
              </div>
              <div class="modal-body">
                  <div class="alerta"></div>
                  <p>Deseja realmente excluir o item <b><span class="dsitem"></span></b></p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
                  <a href="#" class="btn btn-primary btn-yes">Sim</a>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/load.css" rel="stylesheet" type="text/css" />
  <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
  <link href="css/bootstrap-chosen.css" rel="stylesheet" type="text/css" />

  <div class="linear-progress-material" style="display: block;">
      <div class="bar bar1"></div>
      <div class="bar bar2"></div>
  </div>

  	<?php include "includes/cabecalho.php" ?>

    <div class="page-content">
    	<div class="row">
            <?php include "includes/barra_menu.php" ?>
		  <div class="col-md-10">

  			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">Fornecedor</div>
                    <a class="btn btn-primary btn-novo">Novo</a>
				</div>
  				<div class="panel-body">
                    <div class="form-group">

                        <div class="col-lg-12">
                            <div class="form-group col-lg-3">
                                 <label for="fornecedor">Fornecedor</label>
                                 <input id="fornecedor" class="form-control" placeholder="Digite um Fornecedor" >
                            </div>

                            <div class="col-lg-3">

                            </div>
                        </div>

                    </div>


  				</div>
                <table class="table table-stripped table-responsive" id="bem_table">
                    <thead>
                       <tr>
                           <th>#</th>
                           <th>Nome</th>
                           <th>Sigla</th>
                           <th>Ativo</th>
                           <th></th>
                       </tr>
                    </thead>
                    <tbody class="tbody">

                    </tbody>

                </table>
  			</div>



		  </div>
		</div>
    </div>

    <?php include "includes/footer.php" ?>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="js/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/custom.js"></script>
    <?php include "includes/js_bottom.php" ?>
    <script src="js/login.js"></script>

    <script src="js/chosen.jquery.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script src="js/fastclick.js"></script>

    <script src="js/fornecedor.js"></script>

  </body>
</html>