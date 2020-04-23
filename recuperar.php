<?php
require 'classes/Usuario.php';
$u = new Usuario();


if(isset($_POST['email']) && !empty($_POST['email'])){
	$email = addslashes($_POST['email']);    
    
    $u->setEmail($email);

	$u->recuperarSenha();
}

?>
<form method="POST">
	Digite seu e-mail:<br/>
	<input type="text" name="email"><br/><br/>
	<input type="submit" value="Enviar">	
</form>