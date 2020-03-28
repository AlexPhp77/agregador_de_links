<?php 
require './classes/Anuncios.php';
$a = new Anuncios();


?>
  <!--Destaque (aviso)--> 
  <div class="jumbotron" style="background-color:#ffe484; margin-bottom: 0px;">
    <h4 class="display-4" style="color:#17a2b8">Olá, seja bem vindo(a)!</h4>
    
    <hr class="my-4">
    <p class="lead">It uses utility classes for typography and spacing to space content out within the larger container.</p>
    <p class="lead">
      <button class="botao btn btn-info">Anuncie</button>
    </p>
  </div> 

  <!--Menu pesquisa-->
  <aside style="padding: 16px;">

  <form method="GET">
    <div class="row">
      <div class="col">
        

                <form method="GET">  
      
      <?php $categorias = $a->getAllcategorias(); ?>
      Categoria:  
      <select class=" form-control" id="categoria" name="categoria">
            <option></option>
            <?php $categorias = $a->getAllcategorias(); ?>
            <?php foreach($categorias as $categoria): ?>  
            <option  value="<?php echo $categoria['id'];?>">
              <?php echo utf8_encode($categoria['nome']); ?>  
            </option>
      <?php endforeach; ?>
      </select><br/>  
        <input class="form-control btn btn-info" type="submit" value="pesquisar">
      </div>
    </div>
  </form>
   
  </aside>
  
  <!--Conteúdo-->
  <main class="conteudo"> 
    <?php
     $anuncios = $a->getAllAnuncios();
     foreach($anuncios as $anuncio): ?>
       <article class="box img-thumbnail img-fluid ">
        <div class="titulo bg-info text-truncate">
          <h4><?php echo $anuncio['titulo'];?></h4>
        </div>
        <br/>
          <?php $arquivoimg = 'assets/images/'.$anuncio["url"]; ?>
          <?php if(!empty($anuncio['url']) && file_exists($arquivoimg)): ?>
          <img class="img-fluid" src="assets/images/<?php echo $anuncio['url']; ?>">
          <?php else: ?>
          <img  class="img-fluid" height="100px" src="assets/images/padrao-img.jpg">
          <?php endif; ?><br/><br/>
          <p><?php echo $anuncio['descricao'];?></p>         
       </article>
    <?php endforeach; ?>  
  </main>