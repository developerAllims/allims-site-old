<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$pk_program_year_samp = $_GET['id'];

	$query = "DELETE FROM ep_program_year_samp WHERE pk_program_year_samp={$pk_program_year_samp}";
	$result = @pg_query($conexao, $query);

	$error = pg_last_error($conexao);

	if( $error != '' )
	{
		$error = 1;
		$frase = 'Amostra associado a algum processo, sendo assim o mesmo não pode ser excluido';
	}

	//$error = pg_result_error( $result );

	$json = array(
				'error' => $error,
				'frase' => $frase
				);
		echo json_encode($json);
		exit;
?>