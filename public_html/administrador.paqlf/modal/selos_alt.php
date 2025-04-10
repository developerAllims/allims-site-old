<?php 
	include ('functions.php');
	require ('conex_bd.php');
	require ('acessos.php');
	$conexao = conexao();

	$pk_request_seals = $_GET['selo'];
	$pk_selo = $_GET['pk_selo'];
	$fk_person = $_GET['laboratorio'];
	$observacao_interna = $_GET['observacao_interna'];
	$status = $_GET['status'];
	$initial = ($_GET['initial'] ? $_GET['initial'] : 0);
	$final = ($_GET['final'] ? $_GET['final'] : 0);


	/*$query_verif = "select * from ep_fc_can_solicitation_seal( " . $fk_person . ", " . $pk_selo . " )";
	$result_verif = pg_query($conexao, $query_verif );

	$array_verif = pg_fetch_assoc($result_verif);


	if( $array_verif['can_request'] == 't' || $array_verif['can_request'] == 'true' )
	{*/


		$query_update = "	UPDATE 
								ep_request_seals 
							SET  
								fk_request_seals_status = {$status} 
								, internal_obs = '{$observacao_interna}' 
								, number_initial = {$initial} 
								, number_final = {$final}
								, log_date = 'NOW()'
								, log_fk_user = ".$user->getId()."
							WHERE  
								pk_request_seals = {$pk_request_seals} 
								AND fk_person = {$fk_person}";


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
