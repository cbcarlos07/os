



<!DOCTYPE html>
<html lang="pt_BR">

  <?php
  echo "<title>Ordem de Servi&ccedil;o - Bem</title>";
  include "includes/head.php" ;



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
					<div class="panel-title">Bens Patrimoniais</div>
                    <a class="btn btn-primary btn-novo">Novo</a>
				</div>
  				<div class="panel-body">
                    <div class="form-group">

                        <div class="col-lg-12">
                            <div class="form-group col-lg-3">
                                 <label for="item">Item</label>
                                 <select id="item" class="form-control" data-placeholder="Selecione um item" >
                                     <option value='%'></option>
                                 </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="proprietario">Propriet&aacute;rio</label>
                                <select id="proprietario" class="form-control" data-placeholder="Selecione um Propriet&aacute;rio">
                                    <option value='%'></option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="setor">Setor</label>
                                <select id="setor" class="form-control" data-placeholder="Selecione um setor">
                                    <option value='%'></option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="localidade">Localiza&ccedil;&atilde;o</label>
                                <select id="localidade" class="form-control" data-placeholder="Selecione um local" >
                                    <option value='%'></option>
                                </select>
                            </div>
                            <div class="col-lg-3">

                            </div>
                        </div>

                    </div>


  				</div>
                <table class="table table-stripped table-responsive" id="bem_table">
                    <thead>
                       <tr>
                           <th>Cod Item</th>
                           <th>Item</th>
                           <th>Setor</th>
                           <th>Localiza&ccedil;&atilde;o</th>
                           <th>Propriet&aacute;rio</th>
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

    <script src="js/bem.js"></script>
  <script>
      $('#item').chosen( {
          allow_single_deselect: true,
          search_contains: true,
          no_results_text: "Nenhum resultado encontrado!"
      } );
      $('#proprietario').chosen( {
          allow_single_deselect: true,
          search_contains: true,
          no_results_text: "Nenhum resultado encontrado!"
      } );
      $('#setor').chosen( {
          allow_single_deselect: true,
          search_contains: true,
          no_results_text: "Nenhum resultado encontrado!"
      } );
      $('#localidade').chosen( {
          allow_single_deselect: true,
          search_contains: true,
          no_results_text: "Nenhum resultado encontrado!"
      } );


  </script>
  </body>
</html>