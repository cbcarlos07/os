
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
        <ul class="nav permissao">

            <?php
            if( $_SESSION['sistema'] > 0 ){

                ?>
                <li>
                    <a href="solicitar.php">
                        <i class="glyphicon glyphicon-record"></i>Solicitar
                    </a>
                </li>

                <li class="rec">
                    <a href="recebimentos.php">
                        <i class="glyphicon glyphicon-pencil"></i>Recebimentos
                        <span class="num total-recebimentos" >

                                    </span>
                    </a>
                </li>

                <li>
                    <a href="cadastro.php">
                        <i class="glyphicon glyphicon-edit"></i>Cadastrar Chamado
                    </a>
                </li>

                <li class="my">
                    <a href="meus.php">
                        <i class="glyphicon glyphicon-tags" aria-hidden="true"></i>Meus Chamados
                        <span class="num total-chamados" >

                                    </span>
                    </a>
                </li>

                <li class="serv">
                    <a href="servico.php">
                        <i class="glyphicon glyphicon-paperclip"></i>Meus Servicos
                        <span class="num total-servicos" >

                    </span>
                    </a>
                </li>
             <?php
                if ( $_SESSION['sistema'] == 201 ) {


                    ?>
                    <li class="bem">
                        <a href="cadastro2.php">
                            <i class="glyphicon glyphicon-edit"></i>Cadastrar Chamado
                        </a>
                    </li>
                    <?php
                }
                    ?>


                 <li><a href="bem.php" class="bens" ><i class="glyphicon glyphicon-list"></i>Bens Patrimoniais</a></li>
                 <li><a href="fornecedor.php" class="fornecedor" ><i class="glyphicon glyphicon-list"></i>Fornecedor</a></li>
                 <li><a href="tipo.php" class="fornecedor" ><i class="glyphicon glyphicon-list"></i>Tipo de Patrim&ocirc;nio</a></li>
                 <li><a href="fabricante.php" class="fornecedor" ><i class="glyphicon glyphicon-list"></i>Fabricante</a></li>
                <?php
            }else{
                //nao fazem parte do setor de informática
                ?>

                <li><a href="solicitar.php"><i class="glyphicon glyphicon-record"></i>Solicitar</a></li>

                <?php
            }
            ?>
        </ul>
    </div>
</div>