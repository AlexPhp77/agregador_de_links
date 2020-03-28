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
   
    



<nav class=" menu navbar navbar-expand-lg navbar-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">     

    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li><a class="logo" href="./">Agregador de Links</a></li>        
        <?php 
          if(isset($_SESSION['logado']) && !empty($_SESSION['logado'])):
            $user = $u->getUsuario($_SESSION['logado']);          
        ?>
             <li class="nav-item active">
              <a class="text-dark bg-info" href="#"><?php echo "Você está conectado, ".$user['nome']; ?></a>
             </li>
            <li class="nav-item"><a href="anuncios.php">Meus anúncios</a></li>
            <li style="float: right;"><a href="sair.php">Sair</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Acesso</a></li>
            <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastre-se</a></li>
        <?php endif; ?>
      </ul> 
   
  </div>
</nav>








  </header>