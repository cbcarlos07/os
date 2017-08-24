



<!DOCTYPE html>
<html lang="pt_BR">

  <?php
  echo "<title>Ordem de Servi&ccedil;o - Bem</title>";
  include "includes/head.php" ;

  include "controller/class.bens_controller.php";
  include "controller/class.setor_controller.php";
  include "beans/class.bens.php";
  include "beans/class.setor.php";
  include "services/class.bens_list_iterator.php";
  include "services/class.setor_list_iterator.php";

  $bens = new bens();
  $bensController = new bens_controller();



  $setorController = new setor_controller();

  $cdsetor = 0;

  if( isset( $_POST['setor'] ) ){
      $cdsetor = $_POST['setor'];
      $_SESSION['setor'] = $cdsetor;

  }else{
      $cdsetor = $setorController->getPrimeiroSetor();
      $_SESSION['setor'] = $cdsetor;
  }

  $listaSetor = $setorController->getListaSetor();
  $setor = new setor();

  $setorIterator = new setor_list_iterator( $listaSetor );

  $lista = $bensController->getListaBens( $cdsetor );
  $beansListIterator = new bens_list_iterator( $lista );

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

  			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">Bens Patrimoniais</div>
				</div>
  				<div class="panel-body">
                    <div class="form-group">
                        <label for="setor"></label>
                        <select id="setor" >
                            <?php
                               while ( $setorIterator->hasNextSetor() ){
                                   $setor = $setorIterator->getNextSetor();
                                   $atual = "";
                                   if( $setor->getCdSetor() == $cdsetor ){
                                       $atual = "selected";
                                   }
                               ?>
                                   <option value="<?php echo $setor->getCdSetor(); ?>" <?php echo $atual; ?> ><?php echo $setor->getNmSetor(); ?></option>
                            <?php

                               }
                            ?>
                        </select>
                    </div>

  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th>#</th>
								<th>Plaqueta</th>
								<th>S&eacute;rie</th>
								<th>Bem</th>
								<th>Marca</th>
								<th>Checado</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
                              while ( $beansListIterator->hasNextBens() ){

                                  $bens = $beansListIterator->getNextBens();
                                  $checado = $bens->getChecado() == "S" ? "<img src='images/ok.png' width='30'>" : "";


                              ?>
                            <tr>
                                <td><?php echo $bens->getCodBem(); ?></td>
                                <td><?php echo $bens->getPlaqueta(); ?></td>
                                <td><?php echo $bens->getNrSerie(); ?></td>
                                <td><?php echo $bens->getDescBem(); ?></td>
                                <td><?php echo $bens->getMarca(); ?></td>
                                <td><?php echo $checado; ?></td>
                                <td><a href="#alterar"
                                       class="btn btn-primary btn-alterar"
                                       data-url="alterarbem.php"
                                       data-id="<?php echo $bens->getSequencia(); ?>"> Alterar</a></td>
                            </tr>
                            <?php

                              }
                            ?>
						</tbody>
					</table>
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
    <script src="js/bem.js"></script>
  </body>
</html>