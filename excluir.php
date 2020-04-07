<?php 
session_start();

if(!isset($_SESSION['logado']) && empty($_SESSION['logado'])){
    header("Location: login.php");
} 

require 'config.php';
require 'classes/Anuncios.php';
$a = new Anuncios();

if(isset($_GET['id']) && !empty($_GET['id'])){

	$id = addslashes($_GET['id']);
	$id_anuncio = $a->deletarImg($id);
} 

header("Location: editar.php?id=".$id_anuncio);




