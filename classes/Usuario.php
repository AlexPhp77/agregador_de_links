<?php
require './config.php';
class Usuario extends Conexao{

	private $nome;
	private $email;
	private $senha;    
	private $permissoes;	
    
    public function usarMetodosUsuario($nome, $email, $senha){

    	$this->setNome($nome);
    	$this->setEmail($email);
    	$this->setSenha($senha);
    }

	public function getNome(){
		return $this->nome;
	}
	public function setNome($nome){
		if(strlen($nome) > 2 && is_string($nome)){
			$this->nome = $nome;
            return true; 
		}
		else{
            echo "<div class='aviso'><ul><li>Nome de usuário precisa ter mais de 2 caracteres e ser formado apenas por letras ou letras e números!</li></ul></div>";
		}
	}   
	public function getEmail(){
		return $this->email;
	}
	public function setEmail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			$this->email = $email;
		}
		else{
			echo "<div class='aviso'><ul><li>Digite um e-mail válido!</li></ul></div>";
			
		}
	}	
	public function setSenha($senha){
		if(isset( $senha[7]) ){
			$this->senha = $senha;
            return true;

		} else{
			echo "<div class='aviso'><ul><li>Sua senha deve possuir no mínimo 8 caracteres!</li><ul></div>";
		}			
	}
    public function setFone($fone){
        $this->fone = $fone;
    }
    public function getFone(){
        return $this->$fone;
    } 
	public function cadastrar(){

		if($this->verificarEmail() == false){ 

			$sql = $this->pdo->prepare("INSERT INTO usuarios SET nome = :nome, email = :email, senha = md5(:senha)");
			$sql->bindValue(':nome', $this->nome);
			$sql->bindValue(':email', $this->email);
			$sql->bindValue(':senha', $this->senha);           
			$sql->execute(); 

            ?>
			    <script type="text/javascript">
			        window.alert('Cadastro bem sucedido. Faça o login!')
			        window.location.href='login.php';
			    </script>
			<?php

	    } else{	    	
            echo "<div class='aviso'><ul><li>Esse e-mail já está sendo usado. Faça login!</li></ul></div>";
	    }
	}	
    private function verificarEmail(){	

    	$sql = "SELECT email FROM usuarios WHERE email = :email";
    	$sql = $this->pdo->prepare($sql);
    	$sql->bindValue(':email', $this->email);
    	$sql->execute();

    	if($sql->rowCount() > 0){
    		return true;
    	} else{
    		return false;
    	}

    }
    public function logar($email, $senha){      

    	$sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE (email = :email or nome = :nome ) AND senha = md5(:senha)');
        $sql->bindValue(':nome', $email);
    	$sql->bindValue(':email', $email);    
    	$sql->bindValue(':senha', $senha);
    	$sql->execute();

    	if($sql->rowCount() > 0){

    		$id = $sql->fetch();/*pegar ID user e criar sessão do usuário logado*/

    		$_SESSION['logado'] = $id['id'];            

    		header('Location: index.php');
    	} else{
    		echo "<div class='aviso'><ul><li>E-mail e/ou senha errados. Tente novamente!</li></ul></div>";
    	}
    }  
  
    public function getUsuario($id){    
   
    	$sql = $this->pdo->prepare('SELECT nome, email FROM usuarios WHERE id = :id ');
    	$sql->bindValue(':id', $id);    	
    	$sql->execute();

    	if($sql->rowCount() > 0){

    		return $dado = $sql->fetch();    		
    	}
    }  
    public function todosUsuarios(){           	

    	$sql = $this->pdo->query('SELECT nome, email FROM usuarios');

    	if($sql->rowCount() > 0){

            return $dado = $sql->fetchAll();           
        }        
       
    }
    public function excluir($id){

    	$sql = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
    	$sql->bindValue(':id', $id);
    	$sql->execute();

    	header('Location: index.php');
    }
    public function editar($id){   

      $sql = $this->pdo->prepare('UPDATE usuarios SET nome = :nome WHERE id = :id'); 
            $sql->bindValue(':nome', $this->nome); 
            $sql->bindValue(':id', $id);
            $sql->execute();

    	if($this->verificarEmail() == false){ 

            $sql = $this->pdo->prepare('UPDATE usuarios SET email = :email WHERE id = :id');             
            $sql->bindValue(':email', $this->email);
            $sql->bindValue(':id', $id);
            $sql->execute();

            header("Location: index.php");
        } else{
            echo "Esse e-mail já está sendo usado!<br/>";
        }

    }
}

