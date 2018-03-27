

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
  <input type="hidden" id="usuario" value="<?= $_usuario ?>"/>
  <input type="hidden" id="funcionario" value="<?= $_funcionario ?>"/>
  <link href="css/load.css" rel="stylesheet" type="text/css" />
  <link href="css/bootstrap.fd.css" rel="stylesheet" type="text/css" />
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



                          <input  type="hidden" id="acao" value="A"  />



                      <div class="row"></div>
                      <div class="form-group col-lg-5 item">
                          <label for="item" >Cadastrar Tipo</label>
                          <input type="hidden" value="0" id="codigo" >
                          <input  class="form-control" id="item" placeholder="Descri&ccedil;&atilde;o do Tipo de Patrim&ocirc;nio" required  />
                          <span class="error" style="color: red"></span>
                      </div>

                      <div class="row"></div>

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
    <script src="js/chosen.jquery.js"></script>
    <script src="js/cadtipo.js"></script>





  </body>
</html>