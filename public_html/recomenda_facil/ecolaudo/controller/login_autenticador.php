<?php
 
abstract class Autenticador {
 
    private static $instancia = null;
 
    private function __construct() {}
 
    /**
     * 
     * @return Autenticador
     */
    public static function instanciar() {
 
        if (self::$instancia == NULL) {
			self::$instancia = new AutenticadorEmBanco();
		//	self::$instancia = new AutenticadorEmMemoria();
           
        }
 
        return self::$instancia;
 
    }
 
    public abstract function logar($email, $senha);
    public abstract function esta_logado();
    public abstract function pegar_usuario();
    public abstract function expulsar();
 
}
 
class AutenticadorEmMemoria extends Autenticador {
 
	public function esta_logado() {
        $sess = Sessao::instanciar();
        return $sess->existe('usuario');
    }
 
    public function logar($email, $senha) {
 
 		$sess = Sessao::instanciar();
 	
        if ($email == 'tuimbus@gmail.com' && $senha == '123') {
            $usuario = new Usuario();
            $usuario->setEmail($email);
            $usuario->setId(1);
            $usuario->setNome('Antonio Wilson');
            $usuario->setSenha($senha);
 
            $_SESSION['usuario'] = $usuario;
            return true;
        }
        else {
            return false;
        }
 
    }
 
    public function pegar_usuario() {
 
        if ($this->esta_logado()) {
            $usuario = $_SESSION['usuario'];
            return $usuario;
        }
        else {
            return false;
        }
 
    }
 
    public function expulsar() {
        header('location: controller/login_controle.php?acao=sair');
    }
 
}








// VAMOS CRIAR UMA NOVA CLASSE PARA ATENTICAR VIA BANCO DE DADOS //

class AutenticadorEmBanco extends Autenticador {
 
    public function esta_logado() {
        $sess = Sessao::instanciar();
        return $sess->existe('usuario');
    }
 
    public function expulsar() {
        header('location: /ecolaudo/controller/login_controle.php?acao=sair');
    }
 
    public function logar($email, $senha) {
 
     include('../model/conexao_bd.php');
		
		$pdo = pdo_conexao();
		
	
	
	 $sess = Sessao::instanciar();
 		
		$email = pg_escape_string( utf8_encode($email) );
		$senha = pg_escape_string( utf8_encode($senha) ) ;
 
      $sql = "
                SELECT 
                    * 
                FROM 
                    sf_web_users 
               	WHERE 
                    user_login = trim('{$email}') 
                    AND user_password = trim('{$senha}')
                    AND is_enabled = true";
 	//exit;
 	
        $stm = $pdo->query($sql);



        if ($stm->rowCount() > 0) {
 
            $dados = $stm->fetch(PDO::FETCH_ASSOC);


            $usuario = new Usuario();
            $usuario->setEmail($dados['user_login']); // Aqui posso passar qualquer dado da tabela 'usuarios' para a próxima página //
            $usuario->setId($dados['pk_web_users']);
            $usuario->setNome($dados['user_name']);
            $usuario->setSenha($dados['user_password']);
	    $usuario->setTelefone($dados['user_phone']);
            $usuario->setCidade($dados['user_city']);
            $usuario->setEstado($dados['user_state']);
            $usuario->setCan_Insert_Rec($dados['can_insert_rec']);
            $usuario->setIs_Enabled($dados['is_enabled']);
            $sess->set('usuario', $usuario);
			
			
			//Inclusao de Logs !
			//include($_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/model/logs.php');
			//logs( 0, true);
			
		    return true;
        }
        else {
            return false;
        }
 
    }
 
    public function pegar_usuario() {
        $sess = Sessao::instanciar();
 
        if ($this->esta_logado()) {
            $usuario = $sess->get('usuario');
            return $usuario;
        }
        else {
            return false;
        }
    }
 
}

// //









?>