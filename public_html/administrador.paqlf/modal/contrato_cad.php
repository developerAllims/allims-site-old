<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$fk_person = $_GET['lab_on'];
	$fk_foundation = $_GET['fundacao'];
	$contract_number = $_GET['n_contrato'];
	$date_initial = inverteData($_GET['data_inicial']);
	$date_final = inverteData($_GET['data_final']);
	$inf_add = $_GET['observacao'];
	$value_year = replace(',','.',replace('.','',($_GET['valor_anual'] ? $_GET['valor_anual']  : 0 )));




	$data = @explode("/",$_GET['data_inicial']); // fatia a string $dat em pedados, usando / como referência
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	$res = checkdate($m,$d,$y);
	if ( $res != 1 )
	{
	   $frase = 'Data Inicial inválida';
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


	$data = @explode("/",$_GET['data_final']); // fatia a string $dat em pedados, usando / como referência
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	$res = checkdate($m,$d,$y);
	if ( $res != 1 )
	{
	   $frase = 'Data Final inválida';
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


	if(strtotime($date_initial) > strtotime($date_final))
	{
		$frase = 'Data Final Menor que a Data Inicial';
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

	$query = "INSERT INTO 
				ep_contracts 
				(
					fk_person
					, fk_foundation
					, contract_number
					, date_initial
					, date_final
					, inf_add
					, value_year
					, log_date
					, log_fk_user
				) 
				VALUES 
				(
					{$fk_person},
					{$fk_foundation},
					'{$contract_number}',
					'{$date_initial}',
					'{$date_final}',
					'{$inf_add}',
					{$value_year},
					'NOW()',
					{$user->getId()}
				) RETURNING pk_contracts";
	$result = pg_query( $conexao , $query );
	$pk_contrato = pg_fetch_assoc($result);

	if( ! $pk_contrato )
	{
		$error = 1;
		$frase = 'Cadastro não Realizado';
	}else
	{
		$error = 0;
		$frase = 'Cadastro Realizado com Sucesso';
	}


	$json = array(
					'error' => $error
					,'frase' => $frase
					//'dados' => $query,
					//'acao'		=> 1
					);
			echo json_encode($json);
			exit;
?>