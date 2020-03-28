<?php
//require './config.php';
class Anuncios extends Conexao{

	private $titulo;
	private $descricao;
	private $categoria;


	public function usarMetodosAnuncio($titulo, $descricao, $categoria){

    	$this->setTitulo($titulo);
    	$this->setDescricao($descricao); 
    	$this->setCategoria($categoria); 
    }

	public function getTitulo(){
		return $this->titulo;
	}	
	public function setTitulo($titulo){
		if(strlen($titulo) > 5 && is_string($titulo)){
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
			$this->descricao = $descricao;            
		}
		else{
            echo "<div class='aviso'><ul><li>Descrição precisa ter mais de 16 letras!</li></ul></div>";
		}
	}

	public function setCategoria($categoria){
		$this->categoria = $categoria;
	}

	public function getAllAnuncios(){

		$sql = $this->pdo->query("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios_imagens.id_anuncio = anuncios.id GROUP BY anuncios_imagens.id_anuncio");

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
    public function myOneAnuncio($id){

		$sql = $this->pdo->prepare("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios_imagens.id_anuncio = anuncios.id  WHERE anuncios.id = :id GROUP BY anuncios.id_usuario");
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

	public function editarAnuncio($id, $imagem){

		$sql = $this->pdo->prepare("UPDATE anuncios SET titulo = :titulo, descricao = :descricao, id_categoria = :id_categoria WHERE id = :id");        
		$sql->bindValue(':titulo', $this->titulo);
		$sql->bindValue(':descricao', $this->descricao);
		$sql->bindValue(':id_categoria', $this->categoria);
		$sql->bindValue(':id', $id);
		$sql->execute();	

		/*preciso assistir upload de arquivo e manipulaçao de imagens 
		 e sobre constantes 

		 Está´recebendo foto vazia e editando, não deveria, preciso arrumar*/

    
		$tipo = $imagem['type'];        

		if($tipo == 'image/png' or 'image/jpeg'){			


            $tmpname = md5(time().rand(0,9999)).'.jpeg';
			move_uploaded_file($imagem['tmp_name'], 'assets/images/'.$tmpname);
            
            if(is_dir('assets/images/'.$tmpname)){

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
            
            //Editado com sucesso
            header("Location: editar.php?id=".$id);              

		} else{
			echo "<div class='aviso'><ul><li>
				    Apenas imagens png ou jpg são aceitas!;
				 </li></ul></div>";
		}
        
        echo "editado com sucesso";
	
	}	

	public function excluir($id){

		$sql = $this->pdo->prepare("DELETE FROM anuncios WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		$sql = $this->pdo->prepare("DELETE FROM anuncios_imagens WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();
	}
}
