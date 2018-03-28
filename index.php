<?php
include_once __DIR__.'/../vendor/autoload.php';
$dotenv = new \Dotenv\Dotenv(__DIR__."/../");
$dotenv->load();
define("VERSAO", getenv('VERSAO') );
?>
<!DOCTYPE html>
<html>
  <head>

    <title>Ordem de Servi&ccedil;o</title>
	  <link rel="short icon" href="images/ham.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
	  <link href="css/load.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-bg">
  <div class="linear-progress-material loading">
	  <div class="bar bar1"></div>
	  <div class="bar bar2"></div>
  </div>
  <div class="alerta"
	  style="text-align: center; position: absolute; width: 100%"
  		></div>

  	<div class="header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Logo -->
					<div class="logo">
						<h1><a href="index.html">Ordem de Servi&ccedil;o <?= VERSAO ?></a></h1>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h5>Acesse com seu usu&aacute;rio e senha</h5>

			                <input class="form-control" id="u" type="text" placeholder="Usu&aacute;rio">
			                <input class="form-control" id="p" type="password" placeholder="Senha" onkeypress="return EnviaFormulario(event);">
							<input class="form-control" id="e" type="text" placeholder="Empresa">
			                <div class="action">
			                    <a class="btn btn-primary signup" >Login</a>
			                </div>                
			            </div>
			        </div>

			        <div class="already">

			        </div>
			    </div>
			</div>
		</div>
	</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://code.jquery.com/jquery.js"></script>-->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/login.js"></script>
  </body>
</html>