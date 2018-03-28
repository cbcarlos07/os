<?php
include_once __DIR__.'/../vendor/autoload.php';
$dotenv = new \Dotenv\Dotenv(__DIR__."/../");
$dotenv->load();
define("VERSAO", getenv('VERSAO') );
?>
<footer>
    <div class="container">

        <div class="copy text-center">
            Copyright 2018 <a href='#'>Departamento de Tecnologia da Informa&ccedil;&atilde;o <?php echo VERSAO; ?></a>
        </div>

    </div>
</footer>