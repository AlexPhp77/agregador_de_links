<?php
//require './config.php';
class Anuncios extends Conexao{

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

	public function editarAnuncio(){

		$sql = $this->pdo->prepare("");        
   
	}
}
