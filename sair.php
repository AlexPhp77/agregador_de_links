<?php 
session_start();
if(isset($_SESSION['logado']) && !empty($_SESSION['logado'])){
	unset($_SESSION['logado']);
	header("Location: login.php");
} else{
	header("Location: index.php");
}