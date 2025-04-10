<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$pk_samp_control = $_GET['id'];

	$query = "DELETE FROM ep_samp_control WHERE pk_samp_control={$pk_samp_control}";
	$result = @pg_query($conexao, $query);

	$error = pg_last_error($conexao);

	if( $error != '' )
	{
		$error = 1;
		$frase = 'Controle associado a algum processo, sendo assim o mesmo não pode ser excluido';
	}

	//$error = pg_result_error( $result );

	$json = array(
				'error' => $error,
				'frase' => $frase
				);
		echo json_encode($json);
		exit;
?>