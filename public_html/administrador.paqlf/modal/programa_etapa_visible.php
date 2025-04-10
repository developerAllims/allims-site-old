<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$pk_steps = $_GET['samp'];
	$checked = $_GET['value'];

	$query  = "UPDATE ep_program_year_steps SET is_visible = " . $checked . " WHERE pk_program_year_steps=" . $pk_steps;

	$result = pg_query( $conexao, $query);

	$num_rows = pg_affected_rows($result);

	$json = array(
				'rows' => $num_rows,
				);
		echo json_encode($json);
		exit;

?>