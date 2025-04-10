<?php 
	include ('functions.php');
	require ('acessos.php');
	require ('conex_bd.php');

	$conexao = conexao();

	$query_periodo = "SELECT ep_fc_solicitation_period_seal() as periodo";
	//Periodo antes. Fazer essa mesma verificação de contrato dentro da pagina de selos.
	$result_periodo = pg_query($conexao, $query_periodo );

	$array_periodo = pg_fetch_all($result_periodo);

	//print $array['periodo'];

	if( $array_periodo[0]['periodo'] == 't' || $array_periodo[0]['periodo'] == 'true' )
	{

		$query_contract = "SELECT ep_fc_contract_and_lab_is_ok({$_POST['lab']}, 'NOW()', 'NOW()') as contract";
		//Fazer essa mesma verificação de contrato dentro da pagina da amostra.
		$result_contract = pg_query($conexao, $query_contract );

		$array = pg_fetch_all($result_contract);

		if( $array[0]['contract'] == 't' || $array[0]['contract'] == 'true' )
		{

			$query_group = "SELECT ep_fc_can_solicitation_seal_group({$_POST['lab']}) as group ";
			$result_group = pg_query($conexao, $query_group );
			$array_group = pg_fetch_all($result_group);


			if( $array_group[0]['group'] == 't' || $array_group[0]['group'] == 'true' )
			{
				$json = array(
							'error' => '0'
							);
					echo json_encode($json);
					exit;	
			}else
			{
				$json = array(
						'error' => '1',
						'frase' => 'Laboratório com Desempenho Insuficiente no Exercício Anterior.'
						);
				echo json_encode($json);
				exit;
			}
			
		}else
		{
			$json = array(
						'error' => '1',
						'frase' => 'Laboratório não participante do Programa Anual PAQLF.'
						);
				echo json_encode($json);
				exit;
		}

	}else
	{
		$json = array(
					'error' => '1',
					'frase' => 'Solicitação de selos não permitida neste período do ano.'
					);
			echo json_encode($json);
			exit;
	}

?>