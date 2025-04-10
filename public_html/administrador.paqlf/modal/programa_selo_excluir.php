<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$pk_seals = $_POST['id'];

	$query = "DELETE FROM ep_seals WHERE pk_seals={$pk_seals}";
	$result = @pg_query($conexao, $query);

	$error = pg_last_error($conexao);

	if( $error != '' )
	{
		$error = 1;
		//$frase = 'Etapa associado a algum processo, sendo assim o mesmo não pode ser excluido';
		$frase = 'Selo associado a alguma transação, sendo assim o mesmo não pode ser excluido';
	}

	//$error = pg_result_error( $result );

	$json = array(
				'error' => $error,
				'frase' => $frase
				);
		echo json_encode($json);
		exit;
?>