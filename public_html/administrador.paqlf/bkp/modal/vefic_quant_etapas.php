<?php 
	include ('functions.php');
	require_once ('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$query = "
			SELECT 
			   pk_program_year_steps
			FROM
			   ep_program_year_steps
			WHERE fk_program_year = " . pg_escape_string($_GET['samp']);

	$result = pg_query($conexao, $query);

	if( pg_num_rows($result) > 3 )
	{
		header('Location: /programa/etapa/' . $_GET['samp']);
	}
?>