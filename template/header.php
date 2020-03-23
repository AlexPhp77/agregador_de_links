<?php
session_start();
require 'classes/Usuario.php';
$u = new Usuario();
?>
<!DOCTYPE html>
<head lang="pt-br">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">  
  <title>Agregador de Links</title>
</head>
<body> 

  <!--Topo-->
  <header>
   
    <nav class="menu">  
      <ul class="logo"><li><a href="./">Agregador de Links</a></li></ul>    
      <ul>
        <?php 
          if(isset($_SESSION['logado']) && !empty($_SESSION['logado'])):
            $user = $u->getUsuario($_SESSION['logado']);          
        ?>
            <li><a class="active" href="#"><?php echo "Você está conectado, ".$user['nome']; ?></a></li>
            <li><a href="anuncios.php">Meus anúncios</a></li>
            <li><a href="sair.php">Sair</a></li>
        <?php else: ?>
            <li><a href="login.php">Acesso</a></li>
            <li><a href="cadastro.php">Cadastre-se</a></li>
        <?php endif; ?>
      </ul>        
    </nav>

  </header>