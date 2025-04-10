<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/controller/login_usuario.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/controller/login_autenticador.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/controller/login_sessao.php';
 
 
//$url = $_SERVER['SERVER_NAME'];
 
switch($_REQUEST['acao']) {
 
    case 'logar': {
        # Uso do singleton para instanciar
        # apenas um objeto de autenticação
        # e esconder a classe real de autenticação
        $aut = Autenticador::instanciar();
 		//print 'aki1';
        # efetua o processo de autenticação
        if ($aut->logar($_REQUEST['email'], $_REQUEST['senha'])) {
            # redireciona o usuário para dentro do sistema
			//print 'akir';
			if($_REQUEST['lembrar'])
			{
				
				$tempo = time()+3600*24*7; #tempo que ficará guardada essa informação
				//seta os valores para o COOKIE  
				//setcookie("nome", $dataNome, time() + (2 * 3600), "/");
				setcookie("email_eco",$_REQUEST['email'],$tempo, "/");  
				setcookie("pass_eco",$_REQUEST['senha'],$tempo, "/");
			}			
			
			header('location: /amostras');
			
        }
        else {
			//print 'aki2';
            # envia o usuário de volta para 
            # o form de login
            header('location: /?retorno_login=falha');
			
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