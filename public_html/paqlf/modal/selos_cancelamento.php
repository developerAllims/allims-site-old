<?php 
	include ('functions.php');
	require ('conex_bd.php');
	require ('acessos.php');
	$conexao = conexao();

	$pk_request_seals = pg_escape_string($_GET['data']);


	$query = "	SELECT 
				  * 
				FROM 
				  ep_request_seals 
				WHERE 
				  pk_request_seals = {$pk_request_seals}
				  AND fk_request_seals_status = 1
				  AND canceled = false";
	$result = pg_query($conexao, $query );
	if( @pg_num_rows($result) > 0 )
	{
		$query_update = "	UPDATE 
								ep_request_seals
							SET 
								canceled = true,
								log_date = 'NOW()',
								log_fk_user = {$user->getId()}
							WHERE 
								pk_request_seals = {$pk_request_seals}
								AND fk_person = {$user->getLaboratorio()}";

		$result_update = pg_query($conexao, $query_update );

		if( ! @pg_affected_rows ($result_update) )
		{
			$json = array(
					'error' => '1',
					'frase' => 'Alteração não efetuada',
					'query' => $query
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
				'frase' => 'Este Selo não pode ser Cancelado',
				'query' => $query
				);
		echo json_encode($json);
		exit;
	}
?>
