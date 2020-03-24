<?php 
require 'template/header.php';
//require 'classes/Usuario.php';

if(isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])){

	$nome = addslashes($_POST['nome']);
	$email = addslashes($_POST['email']);
	$senha = addslashes($_POST['senha']);
  
    $u = new Usuario();
   
    // Preciso arruma o aviso da senha que só aparece quando avisa o email

    if($u->usarMetodosUsuario($nome, $email, $senha)){

    	 $u->cadastrar();
    }  
    
}

?>


<div class="formulario">
	
	<form method="POST">
		NOME<br/>
		<input type="text" name="nome" placeholder="Usuário (nome)"><br/><br/>
		E-MAIL<br/>
		<input type="text" name="email" placeholder="Seu e-mail"><br/><br/>
		SENHA<br/>
		<input type="password" name="senha" placeholder="Senha (8 ou mais caracteres)"><br/><br/>	
		<input class="btn btn-info" type="submit" value="Cadastrar"> 
	</form>			

</div>

<?php require 'template/footer.php'; ?>