<?php 
	include ('functions.php');
	require('acessos.php'); 
	require('conex_bd.php');
	$conexao = conexao();

	$query_contract = "SELECT ep_fc_contract_and_lab_is_ok({$user->getLaboratorio()}, 'NOW()', 'NOW()') as contract"; 
	//Contrato sempre antes. Fazer essa mesma verificação de contrato dentro da pagina da amostra.
	$result_contract = pg_query($conexao, $query_contract );
	if( $array[0]['contract'] == 'f' || $array[0]['contract'] == 'false' )
	{
		$json = array(
					'error' => '2'
					//'query' => $query
					);
			echo json_encode($json);
			exit;
	}

	$var = $_POST;
	$samp 	= '';

	foreach ($var as $value)
	{
		if( is_array($value) )
		{
			$samp 		= '';
			$report 	= '';
			$resultado 	= '0';
			$unidade 	= '';
			$mandatory	= 'false';
			$technic	= '0';
			
			foreach ($value as $key2 => $value2)
			{
				if( $key2 == 'samp' )
				{
					$samp = pg_escape_string($value2);
				}else if( $key2 == 'report' )
				{
					$report= pg_escape_string($value2);
				}else if( $key2 == 'resultado' && $value2 != '' )
				{
					$resultado = pg_escape_string(replace(',','.',$value2));
				}else if( $key2 == 'unidade' )
				{
					$unidade = pg_escape_string($value2);
				}else if( $key2 == 'mandatory' )
				{
					$mandatory = pg_escape_string($value2);
				}else if( $key2 == 'technic' )
				{
					$technic = pg_escape_string($value2);
				}			
			}
		
		
			if( ($key != 'padrao' &&  $key != 'serial_number') && ( ! empty($samp) && !empty($report) && ! empty($unidade) ) )
			{
				$query = "SELECT ep_fc_insert_results({$samp},{$report},{$unidade},{$resultado},{$mandatory},{$user->getId()},{$technic})";
				$result = @pg_query($conexao,$query);

				if( ! @pg_affected_rows ($result) )
				{
					$json = array(
							'error' => '1'
							,'aqui' => '1'
							//'query' => $query
							);
					echo json_encode($json);
					exit;
				}
			}
		}
	}


	$serial_number = $_POST['serial_number'];


	if( $_POST['padrao']['send'] == 'true')
	{
		print $query = "UPDATE ep_people_samp SET not_send ='true', serial_number = '{$serial_number}' WHERE pk_people_samp =" . $samp;
		$result = pg_query($conexao,$query);
		if( ! @pg_affected_rows ($result) )
		{
			$json = array(
					'error' => '1'
					,'aqui' => '2'
					//'query' => $query
					);
			echo json_encode($json);
			exit;
		}
	}else
	{
		$query = "UPDATE ep_people_samp SET not_send ='false', serial_number = '{$serial_number}' WHERE pk_people_samp =" . $samp;
		$result = pg_query($conexao,$query);
		if( ! @pg_affected_rows ($result) )
		{
			$json = array(
					'error' => '1'
					,'aqui' => '3'
					,'query' => $query
					);
			echo json_encode($json);
			exit;
		}
	}

	

	$query_ep_people_samp = "UPDATE ep_people_samp SET log_date='NOW()', log_fk_user = {$user->getId()}, is_used='TRUE' WHERE pk_people_samp = $samp";
	$result_ep_people_samp = pg_query($conexao,$query_ep_people_samp);





	$json = array(
					'error' => '0'
					);
			echo json_encode($json);
			exit;
?>