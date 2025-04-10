<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$descricao 		= $_POST['descricao'];
	$preco 	     	= str_replace(',', '.', $_POST['preco']);
	$ativo	 		= ($_POST['ativo'] == '' || $_POST['ativo'] == 'null' ? 'true' : 'false');
	$samp 			= $_POST['samp'];
	
	$query = "INSERT INTO 
				ep_seals 
				(
					description
					, price
					, is_disable
					, fk_pa_det_res_groups
					, fk_program_year
					
				)
				VALUES 
				(
					'{$descricao}',
					{$preco},
					{$ativo},
					1,
					{$samp}
				) RETURNING pk_seals";
	$result = pg_query( $conexao , $query );
	$pk_seals = pg_fetch_assoc($result);

	if( ! $pk_seals )
	{
		$error = 1;
		$frase = 'Cadastro não realizado';
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