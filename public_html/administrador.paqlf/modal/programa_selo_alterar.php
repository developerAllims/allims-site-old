<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$descricao 		= $_POST['descricao'];
	$preco 	     	= str_replace(',', '.', $_POST['preco']);
	$ativo	 		= ($_POST['ativo'] == '' || $_POST['ativo'] == 'null' ? 'true' : 'false');
	//$samp 			= $_POST['samp'];
	
	$query = "UPDATE 
				ep_seals
			SET 
			
				description = '{$descricao}'
				, price = {$preco}
				, is_disable = {$ativo}
			WHERE
				pk_seals = " . $_POST['samp'];
	$result = pg_query( $conexao , $query );
	

	if( pg_affected_rows($result) < 1 )
	{
		$error = 1;
		$frase = 'Alteração não realizada';
	}else
	{
		$error = 0;
	}


	$json = array(
					'error' => $error,
					'frase' => $frase,
					'query' => $query
					);
			echo json_encode($json);
			exit;
?>