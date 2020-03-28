<?php
require 'template/header.php';
//require 'classes/Usuario.php';

if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])){

	$email = addslashes($_POST['email']);	
	$senha = addslashes($_POST['senha']);
  
    $u = new Usuario();

    $u->logar($email, $senha);
    
}
?>
<div class="caixa">
	
	<form method="POST">		
		USUÁRIO ou E-MAIL<br/>
		<input type="text" name="email" placeholder="Nome de usuário ou e-mail"><br/><br/>
		SENHA<br/>
		<input type="password" name="senha" placeholder="Digite sua senha"><br/><br/>	
		<input class="btn btn-info" type="submit" value="Entrar">
	</form>			

</div>

<?php require 'template/footer.php'; ?>