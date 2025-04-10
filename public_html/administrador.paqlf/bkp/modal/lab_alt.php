<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$city 				= $_POST['city'];
	$state 				= $_POST['state'];
	$razao 				= $_POST['razao'];
	$fantasia 			= $_POST['fantasia'];
	$cnpj				= $_POST['cnpj'];
	$endereco 			= $_POST['endereco'];
	$endereco_numero 	= $_POST['endereco_numero'];
	$complemento 		= $_POST['complemento'];
	$cep 				= $_POST['cep'];
	$caixa_postal 		= $_POST['caixa_postal'];
	$telefone 			= $_POST['telefone'];
	$fax 				= $_POST['fax'];
	$email 				= $_POST['email'];
	$celular 			= $_POST['celular'];
	$insc_estadual 		= $_POST['insc_estadual'];
	$insc_municipal 	= $_POST['insc_municipal'];
	$participacao 		= $_POST['participacao'];
	$observacao 		= $_POST['observacao'];

	$shipping 			= $_POST['shipping'];

	$ativo			 	= ($_POST['ativo'] ? 'true' : 'false' );
	$pk_person			= $_POST['laboratorio'];


	if( $pk_person == -10 )
	{
		$participacao =  1;
		$ativo = 'true';
	}

	
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
			participation_type = " . $participacao . ",
			obs = '" . $observacao . "', 
			contact_name = '" . $shipping . "',
			log_date = 'NOW()',
			log_fk_user = " . $user->getId() . ",
			is_enabled = " . $ativo . " 
			WHERE pk_person = " . $pk_person;

	//print $query;
	//exit;

	$result = pg_query( $conexao, $query );
	$num_rows = pg_affected_rows($result);


	$json = array(
					'rows' => $num_rows,
					);
			echo json_encode($json);
			exit;
	  
?>