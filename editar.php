<?php
header('Content-Type: text/html; charset=utf-8');
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

if(!empty($_POST['titulo']) && !empty($_POST['descricao'])){

    $titulo = addslashes($_POST['titulo']);
    $descricao = addslashes($_POST['descricao']);
    $categoria = addslashes($_POST['categoria']); 
    if(!empty($_POST['link'])){
        $link = addslashes($_POST['link']);
    }
    if(isset($_FILES['imagem']) && !empty($_FILES['imagem']['tmp_name'])){
        $imagem = $_FILES['imagem']; 
        $a->editarAnuncioImg($id, $imagem);        
        
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";       
    }

	$a->usarMetodosAnuncio($titulo, $descricao, $categoria, $link);
	
	$a->editarAnuncio($id);

	echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>"; 
		
}

?>

<div class="meus-anuncios caixa">
   
	<div class="row">
	    <div class="col-sm">      
	       <form class="form-mobile" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				Título<br/>
			    <input minlength="5" maxlength="100" class="form-control"  type="text" name="titulo" placeholder="Título anúncio" value="<?php echo $dados['titulo']; ?>">
			</div>		
			<div class="form-group">
			    <label for="texto">Sobre</label>
			    <textarea minlength="16"  maxlength="220" name="descricao" class="form-control" id="texto" rows="3"><?php echo $dados['descricao']; ?></textarea>
			</div>
			<div class="form-group">
			    <label for="categoria">Categoria</label>

              

			    <select class="form-control" id="categoria" name="categoria">
			      <?php $categorias = $a->getAllcategorias(); ?>
                  <?php foreach($categorias as $categoria): ?>
                   

			      <option  value="<?php echo $categoria['id'];?>"<?php echo ($categoria['id']==$dados['id_categoria'])?'selected="selected"':''; ?>>
			      	<?php echo $categoria['nome']; ?>	
			      </option>

			      <?php endforeach; ?>
			      	

			    </select><br/>
			     <div class="form-group">
					<label for="link">Link: endereço do site (url)</label>
				    <input value="<?php echo $dados['link']; ?>" class="form-control"  type="text" name="link" placeholder="http://exemplo.com.br">
			    </div><br/>
			    <label for="imagem">Imagem do anúncio</label>
			    <div class="form-group">
			    	<input id="imagem" type="file" name="imagem">			    	
			    </div>
			</div>					
			<input class="btn btn-info form-control" type="submit" value="Editar"> 
		   </form>	
		  
	    </div>
	    <div class="col-sm">
	      <div class="card mb-3 imagem">
	      	<?php $arquivoimg = 'assets/images/'.$dados["url"]; ?>
	      	<?php if(!empty($dados['url']) && file_exists($arquivoimg)): ?>
			<img style="width: 500px;" class="img-fluid" src="assets/images/<?php echo $dados['url']; ?>">
			<a class="btn btn-danger" href="excluir.php?id=<?php echo $dados['id']; ?>">
				<button class="btn btn-light">Excluir</button>				
			</a>
	        <?php else: ?>
	        <img style="width: 500px;" class="img-fluid" height="100px" src="assets/images/padrao-img.jpg">
	        <?php endif; ?>
	      </div>
	    </div>
	</div>		
	
</div>

<?php require 'template/footer.php'; ?>