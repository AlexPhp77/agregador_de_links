<?php
require './config.php';
class Usuario extends Conexao{

	private $nome;
	private $email;
	private $senha;    
	
    
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
            
		}else{
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
		if(strlen($senha) > 7){           
			$this->senha = $senha; 
            $this->cadastrar();/*tive q colocar para funcionar cadastro */  
           
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
    		echo "<div class='aviso'><ul><li>E-mail e/ou senha errados. Tente novamente!
                  <li>Esqueceu sua senha? <a href='recuperar.php' class='text-success'>Clique aqui!</a></li></ul></div>";
    	}
    }  
  
    public function getUsuario($id){    
   
    	$sql = $this->pdo->prepare('SELECT id, nome, email FROM usuarios WHERE id = :id');
    	$sql->bindValue(':id', $id);    	
    	$sql->execute();
        
        $dado = array();
    	if($sql->rowCount() > 0){

    		return $dado = $sql->fetch();    		
    	} return $dado;
    }  
    public function todosUsuarios(){ 
        $dados = array(); 
    	$sql = $this->pdo->query('SELECT nome, email FROM usuarios');

    	if($sql->rowCount() > 0){
            return $dados = $sql->fetchAll();           
        } return $dados;   
    }
    public function excluir($id){

    	$sql = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
    	$sql->bindValue(':id', $id);
    	$sql->execute();

    	header('Location: index.php');
    }
    public function editar($id, $nome, $email){   

      $sql = $this->pdo->prepare('UPDATE usuarios SET nome = :nome WHERE id = :id'); 
            $sql->bindValue(':nome', $this->nome);            
            $sql->bindValue(':id', $id);
            $sql->execute();

            echo "<div class='aviso'><ul><li>Usuário editado!</li></ul></div>";

    	if($this->verificarEmail() == false){ 

            $sql = $this->pdo->prepare('UPDATE usuarios SET email = :email WHERE id = :id');             
            $sql->bindValue(':email', $this->email);
            $sql->bindValue(':id', $id);
            $sql->execute();
           
        } else{
            echo "<div class='aviso'><ul><li>Esse e-mail já está sendo usado!</li></ul></div>";
        }

        header("Refresh: 2; url=editar_usuario.php");

    }

    public function permissoes($id){

        $sql = $this->pdo->prepare('SELECT permissoes FROM usuarios WHERE id = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $dado = $sql->fetch();            
        }
    }    

    public function myUsuario($id){

        $sql = $this->pdo->prepare('SELECT id, nome, email FROM usuarios WHERE id = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
           return $dado = $sql->fetch();
        }
    }
    public function recuperarSenha(){
        $sql = $this->pdo->prepare("SELECT id, email FROM usuarios WHERE email = :email");
        $sql->bindValue(':email', $this->email);
        $sql->execute();

        if($sql->rowCount() > 0){

            $sql = $sql->fetch();
            $id = $sql['id']; 

            $cod = md5(time().rand(0, 9999).rand(0, 9999));

            $sql = $this->pdo->prepare("INSERT INTO usuarios_token SET id_usuario = :id_usuario, cod = :cod, tempo_cod = :tempo_cod");
            $sql->bindValue(':id_usuario', $id);
            $sql->bindValue(':cod', $cod); /*hora atual mais dois meses*/
            $sql->bindValue(':tempo_cod', date('Y-m-d H:i', strtotime('+2 months')));
            $sql->execute();

            $link = "http://localhost/sistemas/agregador_links/redefinir.php?cod=".$cod;

            $mensagem = "Olá, você solicitou uma alteração de senha? Clique no link para redefiní-la: ".$link."<br/>Caso contrário, ignore essa mensagem! Obrigado";

            $assunto = "Redefinição de senha"; 

            $headers = "From: meuemail@meusite.com.br"."\r\n".
                       "X-Mailer: PHP/".phpversion();

            //mail($this->email, $assunto, $mensagem, $headers);    

            echo $mensagem;
            exit;       

        } else {
            echo "<div class='aviso'><ul><li>E-mail não foi encontrado. Por favor digite novamente!</li></ul></div>";
        }
    }

    public function redefinirSenha($cod){

        $sql = $this->pdo->prepare("SELECT * FROM usuarios_token WHERE cod = :cod AND used = 0 AND tempo_cod > NOW()");
        $sql->bindValue(':cod', $cod);              
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $sql->fetch();

            $id = $sql['id_usuario'];             

            echo "<div class='aviso bg-success'><ul><li>Link válido!</li></ul></div>";
            $sql = $this->pdo->prepare("UPDATE usuarios SET senha = md5(:senha) WHERE id = :id");
            $sql->bindValue(':senha', $this->senha);
            $sql->bindValue(':id', $id);
            $sql->execute(); 
            
            $senha = 0; 
            if(!empty($senha)){

                $sql = $this->pdo->prepare("UPDATE usuarios_token SET used = 1 WHERE cod = :cod");
                $sql->bindValue(':cod', $cod);
                $sql->execute(); 

                Echo "Senha alterada com sucesso!";
               
            }

        } else{
            echo "<div class='bg-danger' style='color:#fff;'><ul><li>Link de redefinição de senha inválido ou inspirado!</li></ul></div>";
            header("Refresh: 3; url=login.php");
            exit; 
        }
    }
}



 /*$sql = $this->pdo->prepare("UPDATE usuarios WHERE senha = :senha");
        $sql->bindValue(':senha', $this->senha);
        $sql->execute();*/