<?php 
require 'template/header.php';

if(!isset($_SESSION['logado']) && empty($_SESSION['logado'])){
	header("Location: index.php");
} else{
	$id = addslashes($_SESSION['logado']);
}

$u = new Usuario();
$dado = $u->getUsuario($id);

if(!empty($_POST['nome']) && !empty($_POST['email'])){
	$nome = addslashes($_POST['nome']);
	$email = addslashes($_POST['email']);

	$u->setNome($nome);
    $u->setEmail($email);

	$u->editar($id, $nome, $email);
	
	echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=editar_usuario.php'>";
}

?>

<div class="caixa">
	<form method="POST">
		NOME:<br/>
		<input type="text" name="nome" id="nomeEditar" value="<?php echo $dado['nome']; ?>"><br/><br/>
		E-MAIL:<br/>
		<input type="text" name="email" id="emailEditar" value="<?php echo $dado['email']; ?>"><br/><br/>
		<input class="btn btn-info" type="submit" value="Editar">	
	</form>	
</div>

<?php require 'template/footer.php'; ?>