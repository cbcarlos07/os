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
  <link href="css/solicitar.css" rel="stylesheet" type="text/css" />
  <link href="css/load.css" rel="stylesheet" type="text/css" />
  <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
  <link href="css/jquery.datetimepicker.min.css" rel="stylesheet" type="text/css">
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
                <div class="col-lg-12">
                    <div class="panel-heading col-lg-4">
                        <div class="panel-title">Meus chamados <button class="btn btn-default btn-limpar" title="Limpar pesquisa"><i class="fa fa-paint-brush" aria-hidden="true"></i></div>
                        <div style="margin-top: 10px;" >
                            <a href="#" id="sessao" onclick="atualizarAgora()" title="Clique para atualizar agora" ></a>
                        </div>

                    </div>
                    <div class="col-lg-2" style="margin-top: 15px; margin-left: -50px">

                        <label><input type="checkbox" id="chk_sit" checked>Somente Abertos</label>
                    </div>

                    <div class="row"></div>
                    <div class="col-lg-7 datas" style="display: none">
                        <div class="panel panel-default"  >
                            <div class="panel-heading">Pesquisa pela data do pedido</div>
                            <div class="panel-body">
                                <div style="text-align: center" >
                                    <div class="col-lg-1"></div>
                                    <div class="form-group col-lg-3">
                                        <label for="datai">Data Inicial</label>
                                        <input type="text" class="form-control" id="datai"  placeholder="Data Inicial">

                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="dataf">Data Final</label>
                                        <input type="text" class="form-control" id="dataf"  placeholder="Data Final">
                                    </div>
                                    <div class="form-group col-lg-2">

                                        <button class="btn btn-primary btn-consultar" style="margin-top: 20px;">Consultar</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
  				<div class="panel-body">

                    <div class="col-lg-12" style="text-align: center">
                        <div class="form-group col-lg-1">
                            <label for="cdos">Cd OS</label>
                            <input id="cdos" class="form-control" placeholder="Cd OS">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="oficina">Oficina</label>
                            <select id="oficina" class="form-control " data-placeholder="Selecione"  data-toggle="tooltip" data-html="true" data-placement="left" >
                                <option value="%"></option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="solicitante">Solicitante</label>
                            <select id="solicitante" class="form-control " data-placeholder="Selecione" >
                                <option value="%"></option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3" >
                            <label for="responsavel">Respons&aacute;vel </label>
                            <select id="responsavel" class="form-control" data-placeholder="Selecione" >
                                <option value="%"></option>
                            </select>
                        </div>


                        <div class="form-group col-lg-3">
                            <label for="setor">Setor</label>
                            <select id="setor" class="form-control" data-placeholder="Selecione" >
                                <option value="%"></option>
                            </select>
                        </div>

                    </div>

  					<table class="table  table-bordered table-hover">
						<thead>
							<tr>
                                <th>CD OS</th>
                                <th>PRIORIDADE</th>
                                <th>SETOR</th>
                                <th>RESPONS&Aacute;VEL</th>
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
    <script src="js/jquery.datetimepicker.full.js"></script>

    <script src="js/chosen.jquery.js"></script>
    <script>
        $('#responsavel').chosen( {allow_single_deselect: true} );
        $('#oficina').chosen( {allow_single_deselect: true} );
        $('#solicitante').chosen( {allow_single_deselect: true} );
        $('#setor').chosen( {allow_single_deselect: true} );
        function chamarTooltip( id ) {
            $('#'+id).tooltip('show');

        }

        function hideToolTip( id ) {
            $('#'+id).tooltip('hide');
        }


    </script>




    <?php include "includes/js_bottom.php" ?>
  <script src="js/meus.js"></script>



  </body>
</html>