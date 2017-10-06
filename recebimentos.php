

<!DOCTYPE html>
<html>
   <?php
   echo "<title>Ordem de Servi&ccedil;o - Recebimento de Chamado</title>";
   include "includes/head.php";




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
  <div class="linear-progress-material" style="display: block;">
      <div class="bar bar1"></div>
      <div class="bar bar2"></div>
  </div>
  <p class="alerta"></p>




  	<?php include "includes/cabecalho.php" ?>




    <div class="page-content">
    	<div class="row">
		  <?php include "includes/barra_menu.php"?>
		  <div class="col-md-8 " style="background: #ffffff">

              <h4>Recebimento de Chamados</h4>
              <hr />

              <table class="table table-hover table-responsive tabela" >
                  <thead class="thead">
                  <th>#</th>
                  <th>Data</th>
                  <th>Descri&ccedil;&atilde;o</th>
                  <th>Setor</th>
                  <th>Solicitante</th>
                  <th>Criado por</th>
                  <th></th>
                  </thead >
                  <tbody class="tbody">
                  </tbody>
              </table>

          </div>

		</div>
    </div>
    <?php include "includes/footer.php";?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->



    <?php include "includes/js_bottom.php" ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/recebimentos.js"></script>



  </body>
</html>