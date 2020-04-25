<?php
require 'template/header.php';



if(isset($_POST['email']) && !empty($_POST['email'])){
	$email = addslashes($_POST['email']);    
    
    $u->setEmail($email);

	$u->recuperarSenha();
}

?>

<div class="caixa">
	<form method="POST" class="envio">
	  Digite seu e-mail:<br/>
	  <input type="text" name="email"><br/><br/>
	  <input class="btn btn-info" type="submit" value="Enviar">	
    </form>	
</div>

<?php require 'template/footer.php'; ?>