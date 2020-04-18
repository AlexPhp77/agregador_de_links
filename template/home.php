<?php 
require './classes/Anuncios.php';
$a = new Anuncios();

if(isset($_SESSION['logado']) && !empty($_SESSION['logado'])){
  $permissao = $u->permissoes($_SESSION['logado']);
}


if(isset($_GET['filtro']) && !empty($_GET['filtro'])){
   
   $filtro = addslashes($_GET['filtro']);   
   
} else{
  $filtro = 0;
}



$por_pagina = 4; 

if(isset($_GET['p']) && !empty($_GET['p'])){
  $inicio = addslashes($_GET['p']);
} else{
  $inicio = 1;
}

$inicio = ($inicio - 1) * $por_pagina; 

$anuncios = $a->getAllAnuncios($filtro, $inicio, $por_pagina);

$todosAnuncios = $a->quantidadeTodosAnuncios($filtro);

if($todosAnuncios > $por_pagina){
  $por_pagina = ceil($todosAnuncios / $por_pagina);
}

echo "Quantidade de registros: ".$todosAnuncios."<br/>";
echo "Por página: ".$por_pagina;



$anunc = $a->getIdanuncio();

?>

  <!--Destaque (aviso)--> 
  <div class="jumbotron" style="background-color:#ffe484; margin-bottom: 0px;">
    <h4 class="display-4" style="color:#563d7c"><i>Olá, seja bem vindo(a)!</i></h4>
    
    <hr class="my-4">
    <p class="lead"></p>
    <p class="lead">
      <button class="botao btn btn-info">Envie seu link!</button>
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
      <select class=" form-control" id="categoria" name="filtro">
           
            <?php $categorias = $a->getAllcategorias(); ?>
            <option value="0"></option>
            <?php foreach($categorias as $categoria): ?>  

              <option  value="<?php echo $categoria['id'];?>">
              <?php echo utf8_encode($categoria['nome']); ?>  
            </option>
      <?php endforeach; ?>
      </select><br/>  <!--Necessário tornar filtro dinamico e arrumar 
       quando atualizo fica bloqueado anuncio, precia ativar como valor 1-->


        <input class="form-control btn btn-info" type="submit" value="pesquisar">
      </div>
    </div>
  </form>
   
  </aside>
  
  <!--Conteúdo-->
  <?php 
  if($todosAnuncios > 0){
    echo "<div style='padding: 0px 20px; font-size: 22px;'>".$todosAnuncios." registros encontrados</div>";
  } else{
    echo "<div style='padding: 0px 20px; font-size: 22px;'>".$todosAnuncios." registro encontrado</div>";
  }

  ?>
  <main class="conteudo">     
    <?php
     
     foreach($anuncios as $anuncio): ?>     
      
       <article class="box">
        <a href="<?php echo $anuncio['link']; ?>" target="_blank" style="text-decoration: none;" >
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
          <p style="text-align: justify; overflow:hidden;"><?php echo $anuncio['descricao'];?></p> 
          </a> 

          <?php
           if(isset($_SESSION['logado']) && !empty($_SESSION['logado'])){

           if($permissao[0] == 'ADMINISTRADOR'): ?>

            <a href="bloquear.php?anuncio_usuario=<?php echo $anuncio['id']; ?>">
              <button class="btn btn-secondary">Bloquear</button> 
            </a>
            
          <?php endif; } ?>
       </article>

    <?php endforeach; ?> 

  </main>
  

 <?php if($todosAnuncios > $por_pagina): ?><!-- paginação some se número de registros for insufiente por página-->
  <nav aria-label="Navegação de página">
   
    <ul class="pagination justify-content-center">
     
     
      
     
      <?php for($q = 1; $q <= $por_pagina; $q++): ?>

        <!--  echo ($inicio==$q)?'bg-info':''; para usar como active dentro da classe mas preciso arrumar -->

        <li class="page-item ">
          <a class="page-link" href="index.php?<?php 
          $w = $_GET;
          $w['p'] = $q; 
          echo http_build_query($w);
          ?>">
          <?php echo $q; ?>            
          </a>
        </li> 
      
      <?php endfor; ?>
       
     

    </ul>
 
  </nav>
<?php endif; ?>