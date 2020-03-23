<?php
//require './config.php';
class Anuncios extends Conexao{

	public function getAllAnuncios(){

		$sql = $this->pdo->query("SELECT anuncios.id, anuncios.id_usuario, anuncios.id_categoria, anuncios.titulo, anuncios.descricao, anuncios.ativado, anuncios_imagens.url FROM anuncios INNER JOIN anuncios_imagens ON anuncios_imagens.id_anuncio = anuncios.id GROUP BY anuncios_imagens.id_anuncio");
		if($sql->rowCount() > 0){

			return $dado = $sql->fetchAll();     
		}
	}
}
