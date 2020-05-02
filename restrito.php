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

if(!$anuncios = $a->anunciosBloqueados()){
	echo "<div class='aviso'><ul><li>
		    Não há anúncios para serem analisados!
		    <a href='usuario.php' class='btn btn-primary'>Voltar</a> 
		  </li></ul></div>";
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = addslashes($_GET['id']);
    $a->deletarImg($id);    
    $a->excluir($id);  

    ?>
		<script type="text/javascript">			   
		    window.location.href='restrito.php';
		</script>
	<?php
}


/*Área restrita. Verifica se campo permissões há administrador*/
if($permissao[0] !== 'ADMINISTRADOR'){
	header('Location: anuncios.php');
}

?>


<div class="meus-anuncios" style="padding: 20px; flex-wrap: wrap;">
    
     <?php foreach($anuncios as $anuncio): ?>
       
      <div class="card" style="width: 18rem; margin-right: 20px; margin-bottom: 20px; max-height: 500px;">
          <?php $arquivoimg = 'assets/images/'.$anuncio["url"]; ?>
          <?php if(!empty($anuncio['url']) && file_exists($arquivoimg)): ?>
		    <img class="card-img-top" style="overflow: hidden;" src="assets/images/<?php echo $anuncio['url']; ?>" alt="Card image cap">
		  <?php else: ?>
		  	<img class="card-img-top" src="assets/images/padrao-img.jpg" alt="Card image cap">
          <?php endif; ?>
		  <div class="card-body" style="text-align: justify;">
		    <h5 class="card-title text-dark"><?php echo $anuncio['titulo']; ?></h5>
		    <p class="card-text text-dark"><?php echo $anuncio['descricao']; ?></p>
		    <p class="card-text text-info"><?php echo "Link: ".$anuncio['link']; ?></p>
		    <a href="ativado.php?anuncio_usuario=<?php echo $anuncio['id']; ?>" class="btn btn-primary">Ativar</a>
		    <a href="restrito.php?id=<?php echo $anuncio['id']; ?>" class="btn btn-danger">Deletar</a>
		  </div>
		</div>

     <?php endforeach; ?>	

</div>

<?php require 'template/footer.php'; ?>