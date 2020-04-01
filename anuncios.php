<?php
require 'template/header.php';
if(!isset($_SESSION['logado']) && empty($_SESSION['logado'])){
	header("Location: index.php");
}

require 'classes/Anuncios.php';
$a = new Anuncios();
$quantidade = $a->quantidadeMeusAnuncios($_SESSION['logado']);

if(isset($_GET['id']) && !empty($_GET['id'])){
$id = addslashes($_GET['id']);	

$a->excluir($id);


}
?>

<div class="meus-anuncios">
    
	
	<table class="table table-dark table-striped table-borderless table-responsive">
	  <thead>
	    <tr>
	      <th scope="col"><a href="cadastrar_anuncio.php"><button class="btn btn-info">Novo anúncio</button></a>
	      <?php if(!empty($quantidade)): ?>
	      <td scope="col">
	      	<?php echo "Você tem ".$quantidade." anúncios"; else: echo "Você não tem anúncios ainda"; ?>
	      </td>
	      <?php endif; ?>	
	      </th>	     
	    </tr>
	  </thead>
	  <tbody>

	<?php $dados = $a->myAllAnuncios($_SESSION['logado']); ?>	
    <?php foreach($dados as $chave => $dado): ?>    
    
	    <tr>	     
	      <th scope="row"><?php echo $chave+1; ?></th>	
	      <?php if($dado['ativado'] == 0): ?>
            <td><span class="btn btn-primary bg-primary">Em análise...</span></td>
          <?php else: ?>
            <td><span class="btn btn-success bg-success">Aprovado!</span></td>  
	      <?php endif; ?>      
	      <td>           
	      	<?php if(!empty($dado['url']) && file_exists('assets/images/'.$dado["url"])): ?>
			<img class="img-fluid" src="assets/images/<?php echo $dado['url']; ?>">
	        <?php else: ?>
	        <img  class="img-fluid" height="100px" src="assets/images/padrao-img.jpg">
	        <?php endif; ?>
             
	      </td>
	     
	      <td><?php echo $dado['titulo']; ?></td>
	      <td><?php echo $dado['descricao']; ?></td>
	      <td>

	      	<div class="btn-group" role="group">
	      		<a class="nav-item" href="editar.php?id=<?php echo $dado['id']; ?>">	      			
	      			<button type="button" class="btn btn-warning mr-3">Editar</button>
	            <a class="nav-item" href="anuncios.php?id=<?php echo $dado['id']; ?>">	
	            	<button type="button" class="btn btn-danger">Excluir</button>
	      	</div>      	 

	      </td>
	    </tr>
	
	<?php endforeach; ?>
	  </tbody>
	</table>
	</div>

<?php require 'template/footer.php'; ?>