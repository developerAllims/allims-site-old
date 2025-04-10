<?php 
	include ('functions.php');
	require ('conex_bd.php');
	require ('acessos.php');
	$conexao = conexao();



	$query_verif = "select * from ep_fc_can_solicitation_seal( " . $user->getLaboratorio() . ", " . $_GET['description'] . " )";
	$result_verif = pg_query($conexao, $query_verif );

	$array_verif = pg_fetch_assoc($result_verif);


	if( $array_verif['can_request'] == 't' || $array_verif['can_request'] == 'true' )
	{
		
		$quantidade = pg_escape_string($_GET['quant']);
		$pk_seals  	= pg_escape_string($_GET['description']);
		$observacao = pg_escape_string($_GET['obs']);
		$pk_payment_methods = pg_escape_string($_GET['metodo_pagamento']);

		$query = "SELECT * FROM ep_seals WHERE pk_seals = ". $pk_seals ." AND is_disable = false";

		$result = pg_query($conexao, $query );
		$array = pg_fetch_all($result);


		$query_into = "
						INSERT INTO 
							ep_request_seals
							(	fk_user_request,
								fk_person,
								fk_seals,
								fk_payment_methods, 
								fk_request_seals_status, 
								description,
								date_request,
								qtty,
								price,
								log_date,
								log_fk_user,
								obs
								)
						VALUES 
							(
								{$user->getId()},
								{$user->getLaboratorio()},
								{$array[0]['pk_seals']},
								{$pk_payment_methods},
								1,
								'{$array[0]['description']}',
								'NOW()',
								{$quantidade},
								{$array[0]['price']},
								'NOW()',
								{$user->getId()},
								'{$observacao}'
							)";
		$result_into = pg_query($conexao, $query_into );

		if( ! @pg_affected_rows ($result_into) )
		{
			$json = array(
					'error' => '1',
					'frase' => 'Cadastro não efetuado'
					//'query' => $query_into
					);
			echo json_encode($json);
			exit;
		}

		$json = array(
					'error' => '0',
					);
			echo json_encode($json);
			exit;
	}else
	{
		$json = array(
					'error' => '1',
					'frase' => $array_verif['message_error']
					);
			echo json_encode($json);
			exit;
	}
?>
