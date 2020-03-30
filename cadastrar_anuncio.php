<?php
require 'template/header.php';
require 'classes/Anuncios.php';
if(!isset($_SESSION['logado']) && empty($_SESSION['logado'])){
	header("Location: login.php");
}

$a = new Anuncios();

$dados = $a->getAllcategorias();

if(!empty($_POST['titulo']) && !empty($_POST['descricao'])){

    $titulo = addslashes($_POST['titulo']);
    $descricao = addslashes($_POST['descricao']);
    $categoria = addslashes($_POST['categoria']);  

	$a->usarMetodosAnuncio($titulo, $descricao, $categoria);
	$a->cadastrar();
		
}

?>

<div class="meus-anuncios caixa">
   
	<div class="row">
	    <div class="col-sm">      
	       <form method="POST" enctype="multipart/form-data">
			<div class="form-group">
				Título<br/>
			    <input class="form-control"  type="text" name="titulo" placeholder="Título anúncio">
			</div>		
			<div class="form-group">
			    <label for="texto">Sobre</label>
			    <textarea name="descricao" class="form-control" id="texto" rows="3">		    	
			    </textarea>
			</div>
			<div class="form-group">
			    <label for="categoria">Categoria</label>

              

			    <select class="form-control" id="categoria" name="categoria">
			      <?php $categorias = $a->getAllcategorias(); ?>
                  <?php foreach($categorias as $categoria): ?>
                   
                  <option></option>
			      <option  value="<?php echo $categoria['id'];?>">

			      	<?php echo utf8_encode($categoria['nome']); ?>	

			      </option>

			      <?php endforeach; ?>
			      	

			    </select>			   
			</div>					
			<input class="btn btn-info form-control" type="submit" value="Enviar"> 
		   </form>	
		  
	    </div>	   
	</div>		
	
</div>

<?php require 'template/footer.php'; ?>