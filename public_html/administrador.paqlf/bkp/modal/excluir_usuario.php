<?php 

	include ('functions.php');

	require('acessos.php'); 

	require ('conex_bd.php');

	$conexao = conexao();



	$user_email = $_GET['data'];

	$pk_user = $_GET['id'];



	$query = "DELETE FROM ep_users WHERE user_email='{$user_email}' AND pk_user={$pk_user}";

	$result = @pg_query($conexao, $query);



	$error = pg_last_error($conexao);



	if( $error != '' )

	{

		$error = 1;

		$frase = 'Usuário associado a algum processo, sendo assim o mesmo não pode ser excluido';

	}



	//$error = pg_result_error( $result );



	$json = array(

				'error' => $error,

				'frase' => $frase

				);

		echo json_encode($json);

		exit;

?>