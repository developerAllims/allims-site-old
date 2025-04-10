<?php 
	include ('functions.php');
	require ('acessos.php');
	require ('conex_bd.php');

	$conexao = conexao();

	$inicial 					= pg_escape_string($_GET['inicial']);
	$final 						= pg_escape_string($_GET['final']);
	$pk_program_year_samp		= pg_escape_string($_GET['ano']);


	$query_contract = "SELECT ep_fc_contract_and_lab_is_ok({$user->getLaboratorio()}, 'NOW()', 'NOW()') as contract"; 
	//Contrato sempre antes. Fazer essa mesma verificação de contrato dentro da pagina da amostra.
	$result_contract = pg_query($conexao, $query_contract );

	$array = pg_fetch_all($result_contract);

	if( $array[0]['contract'] == 't' || $array[0]['contract'] == 'true' )
	{
		$query = "SELECT ep_fc_get_pk_people_samp({$user->getLaboratorio()}, {$pk_program_year_samp}, {$user->getId()})";
		$result = pg_query($conexao, $query );
		$resposta = pg_fetch_all($result);

		//print_r($resposta);
		$json = array(
						'error' => '0',
						'number' => $resposta[0]['ep_fc_get_pk_people_samp']
						);
				echo json_encode($json);
				exit;
		
	}else
	{
		$json = array(
					'error' => '1',
					'query' => $query,
					'frase' => 'O Laboratório não esta participando do controle de qualidade.'
					);
			echo json_encode($json);
			exit;
	}

?>