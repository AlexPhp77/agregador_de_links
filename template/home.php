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
  <aside>
    <form method="GET">  
      Categoria:  
      <input type="text" name="">      
      Sub categoria:   
      <input type="text" name="">
      <img src="assets/images/lupa.png" type="submit">
    </form>
  </aside>
  
  <!--Conteúdo-->
  <main class="conteudo"> 
    <?php
     $anuncios = $a->getAllAnuncios();
     foreach($anuncios as $anuncio): ?>
       <article class="box img-thumbnail img-fluid">
        <div class="titulo bg-info"><?php echo $anuncio['titulo'];?></div>
        <br/>
        <img src="assets/images/<?php echo $anuncio['url']; ?>"><br/><br/>
        <?php echo $anuncio['descricao'];?>         
       </article>
    <?php endforeach; ?>  
  </main>