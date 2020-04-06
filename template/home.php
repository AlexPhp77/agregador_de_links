<?php 
require './classes/Anuncios.php';
$a = new Anuncios();





if(isset($_GET['filtro']) && !empty($_GET['filtro'])){
   
   $filtro = addslashes($_GET['filtro']);   
   
} else{
  $filtro = 0;
}

$todosAnuncios = $a->quantidadeTodosAnuncios();

$total_reg = 10;

if(isset($_GET['p']) && !empty($_GET['p'])){

  $inicio = addslashes($_GET['p']);
} else {
  $inicio = 1; 
}

/* Se numero de registros for menor do que as paginas
basta sumir usar um if para desaparecer com paginação*/
$inicio = ($inicio - 1) * $total_reg;  

echo "registros ".$total_reg."</br>";
echo "começa ".$inicio;

$anuncios = $a->getAllAnuncios($filtro, $inicio, $total_reg);

$i = ceil($todosAnuncios / $total_reg);


$anunc = $a->getIdanuncio();

echo "Tem ".$todosAnuncios." anúncios";



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
  <main class="conteudo"> 
    <?php
    
     foreach($anuncios as $anuncio): ?>
      <!-- Preciso arrumar o campo url para o artigo funcionar o link etc.-->
      <a href="<?php echo $anuncio['link']; ?>" target="_blank" style="text-decoration: none;" >
       <article class="box">
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
          <button class="btn btn-secondary">Bloquear</button>        
       </article>
     </a>
    <?php endforeach; ?> 

  </main>
  

 <?php if($todosAnuncios > 10): ?><!-- paginação some se número de registros for insufiente por página-->
  <nav aria-label="Navegação de página">
   
    <ul class="pagination justify-content-center">
     
      <li class="page-item">
        <a class="page-link" href="#" tabindex="-1">Anterior</a>
      </li>
      
     
      <?php for($q = 1; $q <= $i; $q++): ?>

        <!--  echo ($inicio==$q)?'bg-info':''; para usar como active dentro da classe mas preciso arrumar -->

        <li class="page-item ">
          <a class="page-link" href="index.php?p=<?php echo $q; ?>">
          <?php echo $q; ?>            
          </a>
        </li> 
      
      <?php endfor; ?>
       
      <li class="page-item">

        
          <a class="page-link" href="index.php?p=">Próximo</a>
       
      </li>      
    </ul>

  </nav>
<?php endif; ?>