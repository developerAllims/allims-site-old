<?php 
	//VERIFICA USUARIO LOGADO
	session_start();
	require_once '../controller/login_usuario.php';
	require_once '../controller/login_sessao.php';
	require_once '../controller/login_autenticador.php';
	 
	$aut = Autenticador::instanciar();
	 
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}
	else {
		$aut->expulsar();
	}



	$field = $_REQUEST['field'];

	//print_r($field);
	//print_r($_FILES);

	//exit;
	include_once('conexao_bd.php'); 
	$conexao = conexao();
	if( $field == 'password' )
	{
		$query = "SELECT * FROM sf_web_users WHERE user_login='" . $usuario->getEmail() . "' AND  user_password ='" . pg_escape_string( utf8_encode($_REQUEST['atual']) ) . "'";
		$result=pg_query($conexao, $query);
		$num_rows = pg_num_rows($result); 
		if( $num_rows ) 
		{
			
			$query_update = "UPDATE sf_web_users SET user_" . $field . " = '" . pg_escape_string( utf8_encode($_REQUEST['nova']) ) . "' WHERE user_login='" . $usuario->getEmail() . "'";
			$result_update=pg_query($conexao, $query_update);
			$rows = pg_affected_rows($result_update); 
			if( $rows )
			{
				$query = "SELECT * FROM sf_web_users WHERE user_login='" . $usuario->getEmail() . "'";
				$result=pg_query($conexao, $query);
				while ($dados = pg_fetch_assoc($result)) 
				{
					$usuario->setNome($dados['user_name']);
					$usuario->setSenha($dados['user_password']);
					$usuario->setTelefone($dados['user_phone']);
					$usuario->setCidade($dados['user_city']);
					$usuario->setEstado($dados['user_state']);
					
					$dados['erro'] = 0;
					
					echo json_encode($dados);
					exit;
				}
			}
						
			$dados['erro'] = 2;
			echo json_encode($dados);
			exit;
			
		}else
		{
			$dados['erro'] = 3;
			echo json_encode($dados);
			exit;
		}
	}else
	{
		$query_update = "UPDATE sf_web_users SET user_" . $field . " = '" . pg_escape_string( utf8_encode($_REQUEST['campo']) ) . "' WHERE user_login='" . $usuario->getEmail() . "'";
		$result_update=pg_query($conexao, $query_update);
		$rows = pg_affected_rows($result_update); 
		//Alteração realizada com sucesso
		if( $rows )
		{
				$query = "SELECT * FROM sf_web_users WHERE user_login='" . $usuario->getEmail() . "'";
				$result=pg_query($conexao, $query);
				while ($dados = pg_fetch_assoc($result)) 
				{
					$sess = Sessao::instanciar();
					$usuario->setNome($dados['user_name']);
					$usuario->setSenha($dados['user_password']);
					$usuario->setTelefone($dados['user_phone']);
					$usuario->setCidade($dados['user_city']);
					$usuario->setEstado($dados['user_state']);
					$sess->set('usuario', $usuario);
					
					$dados['erro'] = 0;
					
					echo json_encode($dados);
					exit;
				}
				
			//echo 'alterado com sucesso !';
			//exit;
		}
					
		$dados['erro'] = 2;
		echo json_encode($dados);
		exit;
		
	}
	
	
	//print_r($_GET); 








?>