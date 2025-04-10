<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$city 				= pg_escape_string($_POST['city']);
	$state 				= pg_escape_string($_POST['state']);
	$razao 				= pg_escape_string($_POST['razao']);
	$fantasia 			= pg_escape_string($_POST['fantasia']);
	$cnpj				= pg_escape_string($_POST['cnpj']);
	$endereco 			= pg_escape_string($_POST['endereco']);
	$endereco_numero 	= pg_escape_string($_POST['endereco_numero']);
	$complemento 		= pg_escape_string($_POST['complemento']);
	$cep 				= pg_escape_string($_POST['cep']);
	$caixa_postal 		= pg_escape_string($_POST['caixa_postal']);
	$telefone 			= pg_escape_string($_POST['telefone']);
	$fax 				= pg_escape_string($_POST['fax']);
	$email 				= pg_escape_string($_POST['email']);
	$celular 			= pg_escape_string($_POST['celular']);
	$insc_estadual 		= pg_escape_string($_POST['insc_estadual']);
	$insc_municipal 	= pg_escape_string($_POST['insc_municipal']);


	if( $_POST['cidade'] != '' && $_POST['estado'] != '' )
	{
		$query_ids = "SELECT (SELECT * FROM ep_fc_get_pk_city( '".$_POST['cidade']."', '".$_POST['estado']."' )) AS city, (SELECT * FROM ep_fc_get_pk_state('".$_POST['estado']."')) as state";
		$result_ids = pg_query($conexao, $query_ids);

		$all_ids = pg_fetch_all($result_ids);

		$city  = $all_ids[0]['city'];
		$state = $all_ids[0]['state'];
	}


	$query = "UPDATE ep_people SET " . 
			( $state != '' ? "fk_state = " . $state . "," : "" ) .
			( $city != '' ? "fk_city = " . $city . "," : "") . 
			" clear_person = '" . cleanString( $razao ) ."' ,
			clear_fantasy_name = '" . cleanString( $fantasia ) . "',
			person = '" . $razao . "',
			fantasy_name = '" . $fantasia . "',
			insc_juridic = '".$cnpj. "',
			address = '" . $endereco . "',
			address_number = '" . $endereco_numero . "',
			complement = '" . $complemento . "',
			zip_code = '" . $cep . "',
			post_box = '" . $caixa_postal . "',
			phone = '" . $telefone . "',
			fax = '" . $fax . "',
			e_mail = '" . $email . "',
			cellular = '" . $celular . "',
			insc_state = '" . $insc_estadual . "',
			insc_city = '" . $insc_municipal . "',
			log_date = 'NOW()',
			log_fk_user = " . $user->getId() . "
			WHERE pk_person = " . $user->getLaboratorio();

	//print $query;
	//exit;

	$result = @pg_query( $query );
	$num_rows = @pg_affected_rows($result);

	$frase = pg_last_error($conexao);
	if( empty($frase) )
	{
		if( $num_rows )
		{
			$frase = 'Alteração Realizada com Sucesso';
		}else
		{
			$frase = 'Alteração não Realizada';
		}
	}


	$json = array(
					'frase' => $frase
					);
			echo json_encode($json);
			exit;

	//print $query;

	  //lab_number ,
	  //person_juridic ,
	  //district,
	  //home,
	  //
	  
?>