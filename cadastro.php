<?php require 'template/header.php'; ?>

<div class="formulario">
	
	<form method="POST">
		NOME<br/>
		<input type="text" name="nome" placeholder="Usuário (nome)"><br/><br/>
		E-MAIL<br/>
		<input type="email" name="email" placeholder="Seu e-mail"><br/><br/>
		SENHA<br/>
		<input type="password" name="senha" placeholder="Senha (8 ou mais caracteres)"><br/><br/>	
		<input class="btn btn-info" type="submit" value="Cadastrar"> 
	</form>			

</div>

<?php require 'template/footer.php'; ?>