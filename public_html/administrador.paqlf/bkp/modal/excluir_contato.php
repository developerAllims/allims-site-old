<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$fk_person = $_GET['data'];
	$pk_person_contacts = $_GET['id'];

	$query = "DELETE FROM ep_people_contacts WHERE pk_person_contacts='{$pk_person_contacts}' AND fk_person={$fk_person}";
	$result = @pg_query($conexao, $query);

	$error = pg_last_error($conexao);

	if( $error != '' )
	{
		$error = 1;
		$frase = 'Contato não excluido.';
	}

	//$error = pg_result_error( $result );

	$json = array(
				'error' => $error,
				'frase' => $frase
				);
		echo json_encode($json);
		exit;
?>