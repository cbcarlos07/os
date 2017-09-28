
<style>
   .noti .num{
       background-color: red;
       color: white;
       font-size: 10px;
       font-weight: bold;
       width: 20px;
       position: absolute;
       text-align: center;
       border-radius:10px;
       margin-top: 5px;

   }
</style>
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
                 require_once "controller/class.os_controller.php";
                 require_once "controller/class.itemSolicitacaoServico_Controller.php";
                 $oc = new os_controller();
                 $ic = new itemSolicitacaoServico_Controller();
                 $total = $oc->get_total_chamados_aguardando();
                 $totalServicos = $ic->getTotalMeusServicos( $_SESSION['funcionario'] );
                 $totalChamados = $oc->getTotalMeusChamados( $_SESSION['usuario'] );
              ?>
                 <li><a href="solicitar.php"><i class="glyphicon glyphicon-record"></i>Solicitar</a></li>

            <?php
                if( $total > 0 ){

             ?>
                    <li class="noti"><a href="recebimentos.php"><i class="glyphicon glyphicon-pencil"></i><b>Recebimentos</b>
                            <span class="num total-recebimentos" >
                                <?= $total ?>
                            </span></a></li>
             <?php
                }else{
             ?>
                    <li><a href="recebimentos.php"><i class="glyphicon glyphicon-pencil"></i>Recebimentos</a></li>
             <?php
                }
            ?>


                 <li><a href="cadastro.php"><i class="glyphicon glyphicon-edit"></i>Cadastrar Chamado</a></li>

             <?php
               if( $totalChamados > 0 ){
                ?>
                   <li class="noti"><a href="meus.php"><i class="glyphicon glyphicon-tags" aria-hidden="true"></i></i>Meus Chamados
                           <span class="num total-chamados" >
                                <?= $totalChamados ?>
                            </span>
                       </a>
                   </li>
                <?php
               }else{
               ?>
                   <li><a href="meus.php"><i class="glyphicon glyphicon-edit"></i>Meus Chamados</a></li>
               <?php
               }
             ?>


             <?php
              if( $totalServicos > 0 ){
                ?>
                  <li class="noti"><a href="servico.php"><i class="glyphicon glyphicon-paperclip"></i>Meus Servicos
                          <span class="num total-servicos" >
                                <?= $totalServicos ?>
                            </span></a>
                  </li>
              <?php
              }
              else{
              ?>
                  <li ><a href="servico.php"><i class="glyphicon glyphicon-paperclip"></i>Meus Servicos</a></li>
              <?php
              }
             ?>

                <!-- <li><a href="bem.php" class="bens" ><i class="glyphicon glyphicon-list"></i>Bens Patrimoniais</a></li>-->
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