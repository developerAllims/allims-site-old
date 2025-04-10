<?php

session_start();

require_once 'login_usuario.php';

require_once 'login_autenticador.php';

require_once 'login_sessao.php';

 

 

//print_r($_POST);

//$url = $_SERVER['SERVER_NAME'];

 

switch($_REQUEST['acao']) {

 

    case 'logar': {

        # Uso do singleton para instanciar

        # apenas um objeto de autenticação

        # e esconder a classe real de autenticação

        $aut = Autenticador::instanciar();

 

        # efetua o processo de autenticação

        if ($aut->logar($_POST['email'], $_POST['senha'])) {

            # redireciona o usuário para dentro do sistema

			

			if($_POST['lembrar'])

			{

				

				$tempo = time()+3600*24*7; #tempo que ficará guardada essa informação

				//seta os valores para o COOKIE  

				//setcookie("nome", $dataNome, time() + (2 * 3600), "/");

				setcookie("email",$_POST['email'],$tempo, "/");  

				setcookie("pass",$_POST['senha'],$tempo, "/");

			}			

			

            $json = array(

                    'acao'      => 1

                    );

            echo json_encode($json);

            exit;

			//header('location: /avaliacao');

			

        }

        else {

            # envia o usuário de volta para 

            # o form de login

           $json = array(

                    'acao'      => 0

                    );

            echo json_encode($json);

            exit;

           //return  false;

            //header('location: ../?retorno_login=falha');

			

        }

 

    } break;

 

    case 'sair': {

 

        # envia o usuário para fora do sistema

        # o form de login

		// header('location: http://'. $url .'/');

        header('location: /');

 

    } break;

 

}







?>