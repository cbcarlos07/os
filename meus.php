<?php require_once "includes/error.php" ?>



<!DOCTYPE html>
<html lang="pt_BR">

  <?php
  echo "<title>Ordem de Servi&ccedil;o - Meus Chamados</title>";
  include "includes/head.php" ;

  $_usuario = $_SESSION['usuario'];
  $_funcionario= $_SESSION['funcionario'];


  ?>

  <meta charset="UTF-8">
  <style>
      select, option{
          text-align: left;
      }
  </style>
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
            <input type="hidden" id="usuario" value="<?= $_usuario ?>"/>
            <input type="hidden" id="funcionario" value="<?= $_funcionario ?>"/>
  			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">Meus chamados <button class="btn btn-default btn-limpar" title="Limpar pesquisa"><i class="fa fa-paint-brush" aria-hidden="true"></i></div>
				</div>
  				<div class="panel-body">

                    <div class="col-lg-12" style="text-align: center">
                        <div class="form-group col-lg-1">
                            <label for="cdos">Cd OS</label>
                            <input id="cdos" class="form-control" placeholder="Cd OS">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="oficina">Oficina</label>
                            <select id="oficina" class="form-control " >
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="solicitante">Solicitante</label>
                            <select id="solicitante" class="form-control " >
                            </select>
                        </div>
                        <div class="form-group col-lg-3" >
                            <label for="responsavel">Respons&aacute;vel </label>
                            <select id="responsavel" class="form-control " >
                            </select>
                        </div>


                        <div class="form-group col-lg-3">
                            <label for="setor">Setor</label>
                            <select id="setor" class="form-control " >
                            </select>
                        </div>

                    </div>

  					<table class="table table-striped table-bordered">
						<thead>
							<tr>
                                <th>CD OS</th>
                                <th>PRIORIDADE</th>
                                <th>SETOR</th>
                                <th>SERVI&Ccedil;O</th>
                                <th>DATA DA SOLIC.</th>
                                <th>AGUARDANDO</th>
							</tr>
						</thead>
                        <tbody id="t-meus"></tbody>
						<tbody>

						</tbody>
					</table>
  				</div>
  			</div>



		  </div>
		</div>
    </div>

    <?php include "includes/footer.php" ?>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/chosen.jquery.js"></script>
    <script>
        $('#responsavel').chosen();
        $('#oficina').chosen();
        $('#solicitante').chosen();
        $('#setor').chosen();
    </script>




    <?php include "includes/js_bottom.php" ?>
  <script src="js/meus.js"></script>



  </body>
</html>