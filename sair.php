



<!DOCTYPE html>
<html lang="pt_BR">
  <?php include "includes/head.php" ?>

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
  <link href="css/load.css" rel="stylesheet" type="text/css" />
  <div class="linear-progress-material" style="display: block;">
      <div class="bar bar1"></div>
      <div class="bar bar2"></div>
  </div>

  	<?php include "includes/cabecalho.php" ?>

    <div class="page-content">
    	<div class="row">
            <?php include "includes/barra_menu.php" ?>
		  <div class="col-md-10">

  			<div class="content-box-large" style="height: 230px">

                <div style="text-align: center">
                    <p style="font-size: 15px; font-weight: bold">Deseja realmente sair do sistema?</p>
                    <button class="btn btn-primary btn-sim">Sim</button>&nbsp;<button class="btn btn-default btn-sim">N&atilde;o</button>
                </div>

  			</div>



		  </div>
		</div>
    </div>

    <?php include "includes/footer.php" ?>

      <link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="js/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>

    <script src="vendors/datatables/dataTables.bootstrap.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/tables.js"></script>
    <?php include "includes/js_bottom.php" ?>
    <script src="js/login.js"></script>

  </body>
</html>