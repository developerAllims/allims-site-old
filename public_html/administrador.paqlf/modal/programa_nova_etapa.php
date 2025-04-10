<?php 
	require('acessos.php'); 
	require('functions.php'); 
	require('conex_bd.php');
	$conexao = conexao();

	$pk_program_year = $_POST['programa'];
	$data_inicio = inverteData($_POST['data_inicial']);
	$data_fim = inverteData($_POST['data_final']);
	$data_envio = inverteData($_POST['data_envio']);

	$query_verificacao = "
			SELECT 
			   pk_program_year_steps
			FROM
			   ep_program_year_steps
			WHERE fk_program_year = " . $pk_program_year;

	$result_verificacao = pg_query($conexao, $query_verificacao);

	if( pg_num_rows($result_verificacao) > 3 )
	{
		header('Location: /programa/etapa/' . $pk_program_year);
	}


	$data = @explode("/",$_POST['data_envio']); // fatia a string $dat em pedados, usando / como referência
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	$res = @checkdate($m,$d,$y);
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

	$res = @checkdate($m,$d,$y);
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

	$res = @checkdate($m,$d,$y);
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




	$query = "INSERT INTO ep_program_year_steps( fk_program_year, date_initial, date_final, send_date, log_date	,log_fk_user ) VALUES ( {$pk_program_year}, '{$data_inicio}', '{$data_fim}', '{$data_envio}', 'NOW()', {$user->getId()} )";	
	$result = pg_query( $conexao, $query);
	
	$num_rows = pg_affected_rows($result);


	if( $num_rows > 0 )
	{
		$frase = 'Cadastrado com Sucesso';
		$error = 0;

	}else
	{
		$frase = 'Inclusão não Realizada';
		$error = 1;
	}


	$json = array(
				'error' => $error
				,'frase' => $frase
				);
		echo json_encode($json);
		exit;
	

	
?>