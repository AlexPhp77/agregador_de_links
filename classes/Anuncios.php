<?php
//require './config.php';
class Anuncios extends Conexao{

	private $titulo;
	private $descricao;
	private $categoria;
	private $url; 


	public function usarMetodosAnuncio($titulo, $descricao, $categoria, $url){

    	$this->setTitulo($titulo);
    	$this->setDescricao($descricao); 
    	$this->setCategoria($categoria); 
    	$this->setUrl($url);
    }
    public function setUrl($url){
    	/*Necessário verificar url e filtrá-la*/
    	
		    $this->url = $url;
		
		  	
    }

	public function getTitulo(){
		return $this->titulo;
	}	
	public function setTitulo($titulo){
		if(strlen($titulo) >= 5 && is_string($titulo)){
			$this->titulo = $titulo;            
		}
		else{
            echo "<div class='aviso'><ul><li>Título precisa ter mais de 5 letras!</li></ul></div>";
		}
	}

	public function getDescricao(){
		return $this->descricao;
	}	
	public function setDescricao($descricao){
		if(strlen($descricao) > 16 && is_string($descricao)){
			$this->descricao = trim($descricao);            
		}
		else{
            echo "<div class='aviso'><ul><li>Descrição precisa ter mais de 16 letras!</li></ul></div>";
		}
	}

	public function setCategoria($categoria){
		$this->categoria = $categoria;
	}

	public function getAllAnuncios($c, $inicio, $total_reg){        
        /*Preciso arrumar query de filtragem, pois não funciona com o filtro e paginas juntos*/

        if(!empty($c)){
        	$sql = $this->pdo->prepare("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios.link, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios_imagens.id_anuncio = anuncios.id WHERE anuncios.ativado = 1 AND anuncios.id_categoria = :c GROUP BY anuncios_imagens.id_anuncio ORDER BY ID DESC LIMIT $inicio, $total_reg");
		    $sql->bindValue(':c', $c);		   
		    $sql->execute();
        } else{
        	$sql = $this->pdo->query("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios.link, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios_imagens.id_anuncio = anuncios.id WHERE anuncios.ativado = 1 GROUP BY anuncios_imagens.id_anuncio ORDER BY ID DESC LIMIT $inicio , $total_reg");        	
        } 

		$dados = array();
		if($sql->rowCount() > 0){            
			return $dados = $sql->fetchAll(); 

		} return $dados;
	}
	public function myAllAnuncios($id){	        


		$sql = $this->pdo->prepare("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios_imagens.id_anuncio = anuncios.id WHERE anuncios.id_usuario = :id GROUP BY anuncios_imagens.id_anuncio");
		$sql->bindValue(':id', $id);
		$sql->execute();      
       
        $dados = array();      
		if($sql->rowCount() > 0){
			 $dados = $sql->fetchAll();
			 return $dados;
		} return $dados; 
	}

	public function myAllAnuncios2($id){	  			

		$sql = $this->pdo->prepare("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado FROM anuncios  WHERE anuncios.id_usuario = $id ;");
		$sql->bindValue(':id', $id);
		$sql->execute();      
	   
	    $dados = array();      
		if($sql->rowCount() > 0){
			 $dados = $sql->fetchAll();
			 return $dados;
		} return $dados; 
	}
    
    public function quantidadeMeusAnuncios($id){

    	$sql = $this->pdo->prepare("SELECT COUNT(*) as c FROM anuncios WHERE id_usuario = :id");
        $sql->bindValue(':id', $id);
		$sql->execute();  	
        

        if($sql->rowCount() > 0){
        	$dado = $sql->fetch();
        	return $dado['c'];
        } else{
        	echo "Você ainda não possui anúncios.";
        }

    }
    public function quantidadeTodosAnuncios($filtro){
        
        if(empty($filtro)){
        	$sql = $this->pdo->query("SELECT COUNT(*) as c FROM anuncios WHERE ativado = 1");
        } else{
        	$sql = $this->pdo->prepare("SELECT COUNT(*) as c FROM anuncios WHERE ativado = 1 AND id_categoria = :filtro");
        	$sql->bindValue(':filtro', $filtro);
        	$sql->execute();
        }    	               

        if($sql->rowCount() > 0){
        	$dado = $sql->fetch();
        	return $dado['c'];
        } else{
        	echo "Não há anúncios.";
        }

    }
    public function myOneAnuncio($id){

		$sql = $this->pdo->prepare("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios.link, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios_imagens.id_anuncio = anuncios.id  WHERE anuncios.id = :id GROUP BY anuncios.id_usuario");
		$sql->bindValue(':id', $id);
		$sql->execute();
        
        $dado = array();
		if($sql->rowCount() > 0){
			return $dado = $sql->fetch();
		} return $dado; 
	}

	public function getAllcategorias(){

		$sql = $this->pdo->query("SELECT * FROM categorias");

		$dados = array();
		if($sql->rowCount() > 0){

			return $dados = $sql->fetchAll();     
		} return $dados;

	}
	public function getIdanuncio(){

		$sql = $this->pdo->query("SELECT id_categoria FROM anuncios");
		
		if($sql->rowCount() > 0){

			return $dados = $sql->fetch();     
		} 
	}

	public function filtroCategoria($c){

		var_dump($c);

		$sql = $this->pdo->prepare("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios_imagens.id_anuncio = anuncios.id WHERE anuncios.ativado = 1 AND anuncios.id_categoria = :$c GROUP BY anuncios_imagens.id_anuncio");
		$sql->bindValue(':$c', $c);
		$sql->execute();

		$dados = array();
		if($sql->rowCount() > 0){

			return $dados = $sql->fetchAll();     
		} return $dados;

	}public function editarAnuncio($id){

		$sql = $this->pdo->prepare("UPDATE anuncios SET titulo = :titulo, descricao = :descricao, id_categoria = :id_categoria, link = :url, ativado = 0 WHERE id = :id");        
		$sql->bindValue(':titulo', $this->titulo);
		$sql->bindValue(':descricao', $this->descricao);
		$sql->bindValue(':id_categoria', $this->categoria);
		$sql->bindValue(':id', $id);		
		$sql->bindValue(':url', $this->url);
		$sql->execute();	

		header("Location: editar.php?id=".$id);

	}	

	public function editarAnuncioImg($id, $imagem){	

		/*preciso assistir upload de arquivo e manipulaçao de imagens 
		 e sobre constantes */
 
    
		if(!empty($imagem)){
			$tipo = $imagem['type'];     
		}   

		if($tipo == 'image/png' or 'image/jpeg'){			


            $tmpname = md5(time().rand(0,9999)).'.jpg';
			move_uploaded_file($imagem['tmp_name'], 'assets/images/'.$tmpname);
            
            if(file_exists('assets/images/'.$tmpname)){

     	    list($largura, $altura) = getimagesize('assets/images/'.$tmpname);
     	    $ratio = $largura/$altura; 
     										

			$new_largura = 500;
			$new_altura = 500;

			if($new_largura/$new_altura > $ratio){
				$new_largura = $new_altura*$ratio;
			} else{
				$new_altura = $new_largura/$ratio;
			}

			$img = imagecreatetruecolor($new_largura, $new_altura);
			if($tipo == 'image/jpeg'){
				$origi = imagecreatefromjpeg('assets/images/'.$tmpname);
			} elseif($tipo == 'image/png'){
				$origi = imagecreatefrompng('assets/images/'.$tmpname);
			}

			imagecopyresampled($img, $origi, 0, 0, 0, 0, $new_largura, $new_altura, $largura, $altura);
                    
            if($origi){
			    imagejpeg($img, 'assets/images/'.$tmpname, 80);
            }

        } 

            $sql = $this->pdo->prepare("UPDATE anuncios_imagens SET url = :url WHERE id_anuncio = :id");
            $sql->bindValue(':url', $tmpname);
            $sql->bindValue(':id', $id);
            $sql->execute();  

            echo "<script>window.location.href='editar.php?id=".$id."</script>";
           
            //header("Location: editar.php?id=".$id);

		} else{
			echo "<div class='aviso'><ul><li>
				    Apenas imagens png ou jpg são aceitas!
				 </li></ul></div>";
		}       
	
	}	

	public function excluir($id){

		$sql = $this->pdo->prepare("DELETE FROM anuncios WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		$this->deletarImg($id); 

		$sql = $this->pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

				
	}

	public function deletarImg($id){

		$sql = $this->pdo->prepare("SELECT anuncios.id, anuncios_imagens.url FROM anuncios_imagens INNER JOIN anuncios ON anuncios_imagens.id_anuncio = $id INNER join usuarios ON anuncios.id_usuario = usuarios.id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount()>0){
			$img = $sql->fetch();
			if(file_exists('assets/images/'.$img['url'])){			
		       	unlink('assets/images/'.$img['url']);
			}			
	    }
	}

	public function cadastrar(){

		$sql = $this->pdo->prepare("INSERT INTO anuncios SET titulo = :titulo, descricao = :descricao, id_categoria = :id_categoria, id_usuario = :id_usuario, link = :link, ativado = 0");
		$sql->bindValue(':titulo', $this->titulo);
		$sql->bindValue(':descricao', $this->descricao);
		$sql->bindValue(':id_categoria', $this->categoria);
		$sql->bindValue(':id_usuario', $_SESSION['logado']);
		$sql->bindValue(':link', $this->url); 
		$sql->execute(); 
        
        // id do objeto inserido 
		$id_final = $this->pdo->lastInsertId();

		$sql = $this->pdo->prepare("INSERT INTO anuncios_imagens SET id_anuncio = :id_anuncio, url = :url");
		$sql->bindValue(':id_anuncio', $id_final);
		$sql->bindValue(':url', 'url_imagem');
		$sql->execute();		

		?>
			<script type="text/javascript">			   
			    window.location.href='anuncios.php';
			</script>
		<?php

		
	}

	public function anunciosBloqueados(){
        
        $array = array();
		
		$sql = $this->pdo->query("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios.link, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios.id = anuncios_imagens.id_anuncio WHERE ativado = 0");
         
		if($sql->rowCount() > 0){
			return $array = $sql->fetchAll();
		} return $array;
	}

	public function ativarAnuncio($id){

		$sql = $this->pdo->prepare("UPDATE anuncios SET ativado = 1 WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

	}
	public function bloquearAnuncio($id){

		$sql = $this->pdo->prepare("UPDATE anuncios SET ativado = 0 WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

	}
	/*Segurança não funciona*/
	public function seguranca($id){
		$sql = $this->pdo->prepare("SELECT anuncios.id FROM anuncios INNER JOIN usuarios ON usuarios.id = anuncios.id_usuario WHERE anuncios.id = :id AND anuncios.id_usuario = :iduser");
		$sql->bindValue(':iduser', $_SESSION['logado']);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		} else{
			return false; 
		}
	}
}
