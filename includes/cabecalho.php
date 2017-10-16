<?php


    date_default_timezone_set('America/Manaus');
    $hora =  date('H');
    $saudacao = "Bom dia, ";

    if ( $hora >= 12 ){
        $saudacao = "Boa tarde, ";

    }else if( $hora > 18 ){
        $saudacao = "Boa noite, ";
    }


?>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <!-- Logo -->
                <div class="logo">
                    <h4><a href="#"  style="color: #ffffff"><span class="saudacao"><?php echo $saudacao ?></span><?php echo " ".$_SESSION['usuario']."!"; ?></a></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group form">
                            <!--<input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
	                         <button class="btn btn-primary" type="button">Search</button>
	                       </span>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="navbar navbar-inverse" role="banner">
                    <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Minha Sess&atilde;o <b class="caret"></b></a>
                                <ul class="dropdown-menu animated fadeInUp">
                                    <li><a href="sair.php" >Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

