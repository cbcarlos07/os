<div class="col-md-2">
    <div class="sidebar content-box" style="display: block;">
        <ul class="nav">
            <!-- Main menu -->
     <!--       <li><a href="principal.php"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
            <li><a href="calendar.html"><i class="glyphicon glyphicon-calendar"></i> Calendar</a></li>
            <li><a href="stats.html"><i class="glyphicon glyphicon-stats"></i> Statistics (Charts)</a></li>-->
            <?php
             if( $_SESSION['sistema'] == 1 ){
                 //fazem parte do setor de informática
              ?>
                 <li><a href="bem.php" class="bens" ><i class="glyphicon glyphicon-list"></i>Bens Patrimoniais</a></li>
                 <li><a href="solicitar.php"><i class="glyphicon glyphicon-record"></i>Solicitar</a></li>
                 <li><a href="recebimentos.php"><i class="glyphicon glyphicon-pencil"></i>Recebimentos</a></li>
                 <li><a href="cadastro.php"><i class="glyphicon glyphicon-edit"></i>Cadastrar Chamado</a></li>
            <?php
             }else{
                 //nao fazem parte do setor de informática
              ?>

                 <li><a href="solicitar.php"><i class="glyphicon glyphicon-record"></i>Solicitar</a></li>

            <?php
             }
            ?>


            <!--    <li><a href="editors.html"><i class="glyphicon glyphicon-pencil"></i> Editors</a></li>
                <li><a href="forms.html"><i class="glyphicon glyphicon-tasks"></i> Forms</a></li>-->
         <!--   <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-list"></i> Pages
                    <span class="caret pull-right"></span>
                </a>-->
                <!-- Sub menu -->
              <!--  <ul>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="signup.html">Signup</a></li>
                </ul>
            </li>-->
        </ul>
    </div>
</div>