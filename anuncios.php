<?php
require 'template/header.php';
require 'classes/Anuncios.php';
$a = new Anuncios();
$quantidade = $a->quantidadeMeusAnuncios($_SESSION['logado']);
?>

<div class="meus-anuncios">
    
	
	<table class="table table-dark table-striped table-borderless table-responsive">
	  <thead>
	    <tr>
	      <th scope="col"><button class="btn btn-info">Novo anúncio</button>
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
	      <td>
            <?php $arquivoimg = 'assets/images/'.$dado["url"]; ?>
	      	<?php if(!empty($dado['url']) && file_exists($arquivoimg)): ?>
			<img class="img-fluid" src="assets/images/<?php echo $dado['url']; ?>">
	        <?php else: ?>
	        <img  class="img-fluid" height="100px" src="assets/images/padrao-img.jpg">
	        <?php endif; ?>
             
	      </td>
	     
	      <td><?php echo $dado['titulo']; ?></td>
	      <td><?php echo $dado['descricao']; ?></td>
	      <td>
	      	<a href="editar.php?id=<?php echo $dado['id']; ?>">	<button class="btn btn-warning mr-3">Editar</button></a>
	        <a href="excluir.php">	<button class="btn btn-danger">Excluir</button></a>	      
	      </td>
	    </tr>
	
	<?php endforeach; ?>
	  </tbody>
	</table>
	</div>

<?php require 'template/footer.php'; ?>