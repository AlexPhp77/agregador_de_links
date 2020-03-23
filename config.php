<?php
class Conexao{

	public function __construct(){
		try {
    		$this->pdo = new PDO("mysql:dbname=agregador_links;host=localhost", "root", "");    			
    	} catch(PDOException $e){
    		echo "Falhou: ".$e->getMessage();    			
    	}  
	}
}