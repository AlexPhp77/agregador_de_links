<?php 
session_start();

if(!isset($_SESSION['logado']) && empty($_SESSION['logado'])){
    header("Location: login.php");
} 

require 'config.php';
require 'classes/Anuncios.php';

$a = new Anuncios();

$dados = $a->myOneAnuncio($id);

/* segurança: verifica se anúncio é do usuário logado*/
if($dados['id_usuario'] == $_SESSION['logado']){

} else{
	header('Location: anuncios.php');
}

if(isset($_GET['id']) && !empty($_GET['id'])){

	$id = addslashes($_GET['id']);
	$id_anuncio = $a->deletarImg($id);
} 

header("Location: editar.php?id=".$id);




