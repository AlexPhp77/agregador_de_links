<?php
require 'template/header.php';


if(!empty($_GET['cod'])){
	$cod = $_GET['cod'];
    
	if(isset($_POST['senha']) && !empty($_POST['senha'])){
		$senha = addslashes($_POST['senha']);    
	    
	    $u->setSenha($senha);
	      
	}    
	$u->redefinirSenha($cod);
		  
}

?>

<div class="caixa">
	<form method="POST">
	  Digite sua nova senha:<br/>
	  <input type="password" name="senha"><br/><br/>
	  <input class="btn btn-info" type="submit" value="Redefinir">	
    </form>	
</div>


<?php require 'template/footer.php'; ?>