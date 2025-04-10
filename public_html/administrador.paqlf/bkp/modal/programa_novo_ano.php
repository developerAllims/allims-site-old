<?php 
	require('acessos.php'); 
	require('conex_bd.php');
	$conexao = conexao();

	$query_verificacao = "SELECT * FROM ep_program_year WHERE number_year = {$_POST['ano']}";
	$result_verificacao = pg_query( $conexao, $query_verificacao);

	if( pg_num_rows($result_verificacao) > 0 )
	{
		$json = array(
					'error' => '1',
					);
			echo json_encode($json);
			exit;
	}else
	{
		$query = "INSERT INTO ep_program_year( number_year, log_date, log_fk_user ) VALUES ( {$_POST['ano']}, 'NOW()' ,{$user->getId()})";	
		$result = pg_query( $conexao, $query);
		
		$num_rows = pg_affected_rows($result);


		$json = array(
					'error' => '0',
					'rows' => $num_rows,
					);
			echo json_encode($json);
			exit;
	}

	
?>