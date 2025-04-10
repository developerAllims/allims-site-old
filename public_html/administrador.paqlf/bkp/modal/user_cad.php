<?php 
	require('acessos.php'); 
	require('conex_bd.php');
	$conexao = conexao();

	$name 		 	= pg_escape_string($_POST['nome']);
	$mail 		 	= pg_escape_string($_POST['email']);
	$id_laboratorio = pg_escape_string($_POST['lab_on']);
	$pass 		 	= $pass = mt_rand(10000, 99999);;
	$amostra 		= ( ( $_POST['amostra'] == 1 ) ? 'true' : 'false');
	$laboratorio 	= ( ( $_POST['laboratorio'] == 1 ) ? 'true' : 'false');
	$cad_user 		= ( ( $_POST['usuario'] == 1 ) ? 'true' : 'false');
	$selo 		 	= ( ( $_POST['selo'] == 1 ) ? 'true' : 'false');

	//print $user->getId();
	$query_verificacao = "SELECT * FROM ep_users WHERE user_email='" . $mail . "'";
	//print $query_verificacao;
	//exit;
	$result_verificacao = pg_query( $conexao , $query_verificacao );
	if( pg_num_rows($result_verificacao) > 0 )
	{
		$error = 2;
	}else
	{
		
		$query = "INSERT INTO 
						ep_users (fk_person, user_name, user_email, user_password, can_imput_results, can_update_lab, can_adm_users, can_request_seals, log_fk_user, log_date)
						VALUES 
						(" . $id_laboratorio .",'". $name ."','". $mail ."','". $pass ."',". $amostra .",". $laboratorio .",". $cad_user .",". $selo ."," . $user->getId() . ", 'NOW()')  RETURNING pk_user";
	
						//Numero 1 acima é o id do laboratorio logado
						//Numero 0 acima é o id do usuário logado
						
		$result = pg_query( $conexao , $query );
		$pk_user = pg_fetch_assoc($result);
	
		if( ! $pk_user )
		{
			$error = 1;
		}else
		{
			$error = 0;
	
			$query_select = "SELECT * FROM ep_users WHERE pk_user=" . pg_escape_string($pk_user['pk_user']);
			$result_select = pg_query( $query_select );
	
			$select = pg_fetch_assoc($result_select);
		}
	}


	$json = array(
					'error' => $error,
					'dados' => $select,
					'acao'		=> 1
					);
			echo json_encode($json);
			exit;
?>