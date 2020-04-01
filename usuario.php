<?php
require 'template/header.php';
if(!isset($_SESSION['logado']) && empty($_SESSION['logado'])){
	header("Location: index.php");
} else{
	$id = addslashes($_SESSION['logado']);	
}

require 'classes/Anuncios.php';
$a = new Anuncios();
$u = new Usuario();

$quantidade = $a->quantidadeMeusAnuncios($_SESSION['logado']);

$user = $u->myUsuario($id);

?>

<div class="meus-anuncios">
    
	
	<table class="table table-dark table-striped table-borderless table-responsive">
	  <thead>
	    <tr>
	      <th scope="col">
	      <?php if(!empty($quantidade)): ?>
	      <td scope="col">
	      	<?php echo "Você tem ".$quantidade." anúncios"; else: echo "Você não tem anúncios ainda"; ?>
	      </td>
	      <?php endif; ?>	
	      </th>	     
	    </tr>
	  </thead>
	  <tbody>
	    <tr>   
	      <td>Nome</td>	     
	      <td>E-mail</td>	     
	    </tr>
	    <tr>
	      <td><?php echo $user['nome']; ?></td>
	      <td><?php echo $user['email']; ?></td>
	    </tr>
	  </tbody>
	</table>
	</div>

<?php require 'template/footer.php'; ?>