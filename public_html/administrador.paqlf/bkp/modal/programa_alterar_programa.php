<?php 
	require('acessos.php'); 
	require('functions.php'); 
	require('conex_bd.php');
	$conexao = conexao();

	$pk_program_year_samp	= $_POST['programa'];
	$pk_program_year_steps 	= $_POST['etapa'];
	$samp_number	 		= $_POST['amostra'];
	$pk_samp_control 		= $_POST['controle'];
	

	$query = "
			UPDATE ep_program_year_samp 
					SET
					    fk_program_year_steps = {$pk_program_year_steps},
						samp_number = {$samp_number},
						fk_samp_control = {$pk_samp_control}
						,log_date = 'NOW()'
						,log_fk_user = ".$user->getId()."
					WHERE 
						pk_program_year_samp = {$pk_program_year_samp}";

	$result = pg_query( $conexao, $query);

	$num_rows = pg_affected_rows($result);

	$json = array(
				'rows' => $num_rows,
				);
		echo json_encode($json);
		exit;
	
?>