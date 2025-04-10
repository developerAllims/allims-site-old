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

 





// VAMOS CRIAR UMA NOVA CLASSE PARA ATENTICAR VIA BANCO DE DADOS //



class AutenticadorEmBanco extends Autenticador {

 

    public function esta_logado() {

        $sess = Sessao::instanciar();

        return $sess->existe('usuario');

    }

 

    public function expulsar() {

        header('location: /controller/login_controle.php?acao=sair');

    }

 

    public function logar($email, $senha) {

		

		include('../modal/conex_bd.php');

		

		//$pdo = pdo_conexao();

        $conexao = conexao();

		

	

	    //$browser   = get_browser(null, true);

        $navegador = ''; //$browser['comment'];

        $so        = ''; //$browser['platform'];

	    $ip        = $_SERVER['REMOTE_ADDR'];



        

        $sess = Sessao::instanciar();

 		

		$email = pg_escape_string( utf8_encode($email) );

		$senha = pg_escape_string( utf8_encode($senha) ) ;

 

        $sql = "SELECT *

                    FROM 

                        ep_fc_validate_login_user('{$email}', '{$senha}', '{$ip}', '{$navegador}', '{$so}',true);";



        

        $result = pg_query($conexao, $sql);

        $dados = pg_fetch_all($result);

        //$stm = $pdo->query($sql);

		

        //$dados = $stm->fetch(PDO::FETCH_ASSOC);

        if ($dados[0]['r_login_ok'] == 't' || $dados[0]['r_login_ok'] == 'true') {

 			

           

 

            $usuario = new Usuario();

            $usuario->setId($dados[0]['r_pk_user']);

            $usuario->setEmail($dados[0]['r_user_email']); // Aqui posso passar qualquer dado da tabela 'usuarios'

            $usuario->setNome($dados[0]['r_user_name']);

            $usuario->setLaboratorio($dados[0]['r_pk_person']);

            //$usuario->setLaboratorioAtivo( $dados['active'] );

            $usuario->setResultado($dados[0]['r_can_imput_results']);         

            $usuario->setAlteracaoLaboratorio($dados[0]['r_can_update_lab']);

            $usuario->setUsuario($dados[0]['r_can_adm_users']);

            $usuario->setSelo($dados[0]['r_can_request_seals']);

            $usuario->setLogin($dados[0]['r_login_ok']);



            $sess->set('usuario', $usuario);



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