<?php 
	require('acessos.php'); 
	require('functions.php'); 
	require('conex_bd.php');
	$conexao = conexao();

	$pk_program_year 		= $_POST['programa'];
	$pk_program_year_steps 	= $_POST['etapa'];
	$samp_number	 		= $_POST['amostra'];
	$pk_samp_control 		= $_POST['controle'];
	

	$query_verificacao = " SELECT * FROM ep_program_year_samp WHERE fk_program_year_steps = " . $pk_program_year_steps;
	$result_verificacao = pg_query($conexao, $query_verificacao);

	if( pg_num_rows($result_verificacao) > 2 )
	{
		$json = array(
						'erro' => '1',
						);
				echo json_encode($json);
				exit;
	}else
	{

		$query_verificacao = "SELECT samp_number FROM ep_program_year_samp WHERE samp_number = " . $samp_number;
		$result_verificacao = pg_query($conexao, $query_verificacao);
		if( pg_num_rows($result_verificacao) > 0 )
		{
			$json = array(
						'erro' => '2',
						);
				echo json_encode($json);
				exit;
		}else
		{
			$query = "
					INSERT INTO 
						ep_program_year_samp
						(
							 fk_program_year_steps
							,samp_number
							,fk_samp_control
							,log_date
							,log_fk_user
						)
					VALUES
						(
							{$pk_program_year_steps},
							{$samp_number},
							{$pk_samp_control},
							'NOW()',
							{$user->getId()}
						)";

			$result = pg_query( $conexao, $query);
	
			$num_rows = pg_affected_rows($result);

			$json = array(
						'rows' => $num_rows,
						);
				echo json_encode($json);
				exit;

		}
	}
?>