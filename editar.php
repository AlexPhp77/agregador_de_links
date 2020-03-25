<?php
require 'template/header.php';
require 'classes/Anuncios.php';
$a = new Anuncios();

if(empty($_GET['id'])){

   header('Location: anuncios.php');
}

$id = addslashes($_GET['id']);



$dados = $a->myOneAnuncio($id);

/* segurança: verifica se anúncio é do usuário logado*/
if($dados['id_usuario'] == $_SESSION['logado']){

} else{
	header('Location: anuncios.php');
}

?>

<div class="meus-anuncios caixa">
   
	<div class="row">
	    <div class="col-sm">      
	       <form method="POST">
			<div class="form-group">
				Título<br/>
			    <input class="form-control"  type="text" name="titulo" placeholder="Título anúncio" value="<?php echo $dados['titulo']; ?>">
			</div>		
			<div class="form-group">
			    <label for="texto">Sobre</label>
			    <textarea class="form-control" id="texto" rows="3">
			    	<?php echo $dados['descricao']; ?>
			    </textarea>
			</div>
			<div class="form-group">
			    <label for="categoria">Categoria</label>

              

			    <select class="form-control" id="categoria" name="categoria">
			      <?php $categorias = $a->getAllcategorias(); ?>
                  <?php foreach($categorias as $categoria): ?>
                   

			      <option  value="<?php echo $categoria['id'];?>"<?php echo ($categoria['id']==$dados['id_categoria'])?'selected="selected"':''; ?>>

			      	<?php echo utf8_encode($categoria['nome']); ?>	

			      </option>

			      <?php endforeach; ?>
			      	

			    </select><br/>
			    <label for="imagem">Imagem do anúncio</label>
			    <div class="form-group">
			    	<input id="imagem" type="file" name="imagem">			    	
			    </div>
			</div>					
			<input class="btn btn-info form-control" type="submit" value="Editar"> 
		   </form>	
	    </div>
	    <div class="col-sm">
	      <div class="card mb-3">
	      	<?php $arquivoimg = 'assets/images/'.$dados["url"]; ?>
	      	<?php if(!empty($dados['url']) && file_exists($arquivoimg)): ?>
			<img style="width: 500px;" class="img-fluid" src="assets/images/<?php echo $dados['url']; ?>">
			<button class="btn btn-danger">Excluir</button>
	        <?php else: ?>
	        <img style="width: 500px;" class="img-fluid" height="100px" src="assets/images/padrao-img.jpg">
	        <?php endif; ?>
	      </div>
	    </div>
	</div>		
	
</div>

<?php require 'template/footer.php'; ?>