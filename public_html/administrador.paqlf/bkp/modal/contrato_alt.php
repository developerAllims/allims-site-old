<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();
	
	$pk_contrato = $_GET['contrato'];
	$fk_person = $_GET['lab_on'];
	$fk_foundation = $_GET['fundacao'];
	$contract_number = $_GET['n_contrato'];
	$date_initial = inverteData($_GET['data_inicial']);
	$date_final = inverteData($_GET['data_final']);
	$inf_add = $_GET['observacao'];
	$value_year = ($_GET['valor_anual'] != '' ? replace(',','.',replace('.','',$_GET['valor_anual'])) : 0);
	$cancelado = ($_GET['cancelado'] == 'true' ? $_GET['cancelado'] : 'false') ;





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





	$query = "UPDATE  
				ep_contracts 
			SET
				  fk_foundation = {$fk_foundation}
				, contract_number = '{$contract_number}'
				, date_initial = '{$date_initial}'
				, date_final = '{$date_final}'
				, inf_add = '{$inf_add}'
				, value_year = {$value_year}
				, log_date = 'NOW()'
				, log_fk_user = {$user->getId()}
				, is_canceled = '{$cancelado}'
			WHERE
				pk_contracts = {$pk_contrato}
				AND fk_person = {$fk_person} ";

	$result = pg_query( $conexao , $query );
	$num_rows = pg_affected_rows($result);


	if( $num_rows > 0  )
	{
		$frase = 'Alteração Realizada com Sucesso';
		$error = 0;
	}else
	{
		$frase = 'Alteração não Realizada';
		$error = 1;
	}

	$json = array(
					'error' => $error,
					'frase' => $frase,
					'acao'		=> 1
					);
			echo json_encode($json);
			exit;
?>