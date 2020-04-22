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

$permissao = $u->permissoes($id);

$usuarios = $u->todosUsuarios();

/*Área restrita. Verifica se campo permissões há administrador*/
?>
<?php if($permissao[0] === 'ADMINISTRADOR'): ?>
<div class="navbar navbar-dark bg-dark">
	<a class="nav-link bg-light" href="restrito.php">Painel de controle (área restrita)</a>	
</div>
<?php endif; ?>

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
	      <td><a href="editar_usuario.php" class="btn btn-secondary">Editar</a></button></td>	     
	    </tr>
	    <tr>
	      <td><?php echo $user['nome']; ?></td>
	      <td><?php echo $user['email']; ?></td>
	    </tr>
	  </tbody>
	</table>		
	</div>

	<?php if($permissao[0] === 'ADMINISTRADOR'): ?>			
		<div class="lista-usuarios bg-dark">	
		<div class=" sticky-top">
			<h4 class="bg-dark text-light" style="padding: 20px">Todos os usuários cadastrados</h4>
			<br/>
		</div>	   		
	    	<?php foreach($usuarios as $usuario): ?>
	    		<?php echo "<span style='padding: 20px;' class='text-warning'>Nome:</span> ".$usuario['nome']." || <span class='text-warning'>E-mail:</span> ".$usuario['email']."</br><hr>"; ?>
	    	<?php endforeach; ?>	
	    </div>
    <?php endif; ?>   
    

<?php require 'template/footer.php'; ?>


