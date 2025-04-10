<?php 
	include ('functions.php');
	require ('conex_bd.php');
	require ('acessos.php');
	$conexao = conexao();

	$pk_request_seals 	= pg_escape_string($_GET['selo']);
	$quantidade 		= pg_escape_string($_GET['quant']);
	$pk_seals  			= pg_escape_string($_GET['description']);
	$observacao 		= pg_escape_string($_GET['obs']);
	$pk_payment_methods = pg_escape_string($_GET['metodo_pagamento']);


	/*$query_verif = "select * from ep_fc_can_solicitation_seal( " . $user->getLaboratorio() . ", " . $_GET['description'] . " )";
	$result_verif = pg_query($conexao, $query_verif );

	$array_verif = pg_fetch_assoc($result_verif);


	if( $array_verif['can_request'] == 't' || $array_verif['can_request'] == 'true' )
	{*/

		$query = "SELECT * FROM ep_seals WHERE pk_seals = ". $pk_seals ." AND is_disable = false";

		$result = pg_query($conexao, $query );
		$array = pg_fetch_all($result);


		$query_update = "	UPDATE 
								ep_request_seals
							SET 
								fk_payment_methods = {$pk_payment_methods},
								description = '{$array[0]['description']}',
								qtty = {$quantidade},
								price = {$array[0]['price']},
								log_date = 'NOW()',
								log_fk_user = {$user->getId()},
								obs = '{$observacao}'
							WHERE 
								pk_request_seals = {$pk_request_seals}
								AND fk_person = {$user->getLaboratorio()}";


		$result_update = pg_query($conexao, $query_update );

		if( ! @pg_affected_rows ($result_update) )
		{
			$json = array(
					'error' => '1',
					'frase' => 'Cadastro não efetuado',
					'query' => $query_update
					);
			echo json_encode($json);
			exit;
		}

		$json = array(
					'error' => '0',
					);
			echo json_encode($json);
			exit;
	/*}else
	{
		$json = array(
					'error' => '1',
					'frase' => $array_verif['message_error']
					);
			echo json_encode($json);
			exit;
	}*/
?>
