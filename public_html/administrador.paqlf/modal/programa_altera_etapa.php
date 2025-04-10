<?php 
	require('acessos.php'); 
	require('functions.php'); 
	require('conex_bd.php');
	$conexao = conexao();

	$pk_program_year_steps = $_POST['programa'];
	$data_inicio = inverteData($_POST['data_inicial']);
	$data_fim = inverteData($_POST['data_final']);
	$data_envio = inverteData($_POST['data_envio']);


	$data = @explode("/",$_POST['data_envio']); // fatia a string $dat em pedados, usando / como referência
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	$res = checkdate($m,$d,$y);
	if ( $res != 1 )
	{
	   $frase = 'Data de Envio Inválida';
	   $error = 1;

	   $json = array(
					'error' => $error
					,'frase' => $frase
					//'dados' => $query,
					//'acao'		=> 1
					);
			echo json_encode($json);
			exit;
	} 


	$data = @explode("/",$_POST['data_inicial']); // fatia a string $dat em pedados, usando / como referência
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	$res = checkdate($m,$d,$y);
	if ( $res != 1 )
	{
	   $frase = 'Data Inicial Inválida';
	   $error = 1;

	   $json = array(
					'error' => $error
					,'frase' => $frase
					//'dados' => $query,
					//'acao'		=> 1
					);
			echo json_encode($json);
			exit;
	} 


	$data = @explode("/",$_POST['data_final']); // fatia a string $dat em pedados, usando / como referência
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	$res = checkdate($m,$d,$y);
	if ( $res != 1 )
	{
	   $frase = 'Data Final Inválida';
	   $error = 1;
	   
	   $json = array(
					'error' => $error
					,'frase' => $frase
					//'dados' => $query,
					//'acao'		=> 1
					);
			echo json_encode($json);
			exit;
	} 



	$query = "UPDATE 
				ep_program_year_steps
			  SET 
			  	date_initial = '{$data_inicio}', 
			  	date_final = '{$data_fim}', 
			  	send_date = '{$data_envio}'
			  	,log_date = 'NOW()'
				,log_fk_user = ".$user->getId()."
			  WHERE 
			  	pk_program_year_steps = {$pk_program_year_steps}";	

	$result = pg_query( $conexao, $query);	
	$num_rows = pg_affected_rows($result);

	if( $num_rows > 0 )
	{
		$frase = 'Alteração Realizada com Sucesso';
		$error = 0;

	}else
	{
		$frase = 'Alteração não Realizada';
		$error = 1;
	}


	$json = array(
				'error' => $error
				,'frase' => $frase
				);
		echo json_encode($json);
		exit;
	

	
?>