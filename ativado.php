<?php
require 'template/header.php';
require 'classes/Anuncios.php';

$a = new Anuncios();
$u = new Usuario();

if(!isset($_SESSION['logado']) && empty($_SESSION['logado'])){
	header("Location: index.php");
} else{
	$id = addslashes($_SESSION['logado']);	
}

$permissao = $u->permissoes($id);

/*Área restrita. Verifica se campo permissões há administrador*/
if($permissao[0] !== 'ADMINISTRADOR'){
	header('Location: anuncios.php');
}

if(isset($_GET['anuncio_usuario']) && !empty($_GET['anuncio_usuario'])){
    $anuncio_usuario = addslashes($_GET['anuncio_usuario']);

} 

$a->ativarAnuncio($anuncio_usuario);

?>
	<script type="text/javascript">			   
	    window.location.href='restrito.php';
	</script>

<?php

exit();




