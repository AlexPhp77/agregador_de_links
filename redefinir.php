<?php
require 'classes/Usuario.php';
$u = new Usuario();

if(!empty($_GET['cod'])){
	$cod = $_GET['cod'];
    
	if(isset($_POST['senha']) && !empty($_POST['senha'])){
		$senha = addslashes($_POST['senha']);    
	    
	    $u->setSenha($senha);
	    $u->redefinirSenha($cod);  
	}    
		  
}

?>
<form method="POST">
	Digite sua nova senha:<br/>
	<input type="password" name="senha"><br/><br/>
	<input type="submit" value="Redefinir">	
</form>


