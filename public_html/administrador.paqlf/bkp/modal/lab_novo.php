<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$city 				= $_POST['city'];
	$state 				= $_POST['state'];
	$lab_number			= $_POST['cod'];
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
	$pk_person			= $_POST['laboratorio'];



	if( $_POST['cidade'] != '' && $_POST['estado'] != '' )
	{
		$query_ids = "SELECT (SELECT * FROM ep_fc_get_pk_city( '".$_POST['cidade']."', '".$_POST['estado']."' )) AS city, (SELECT * FROM ep_fc_get_pk_state('".$_POST['estado']."')) as state";
		$result_ids = pg_query($conexao, $query_ids);

		$all_ids = pg_fetch_all($result_ids);

		$city  = $all_ids[0]['city'];
		$state = $all_ids[0]['state'];
	}


	$query_verificacao = "SELECT * FROM ep_people WHERE lab_number=".$lab_number;
	$result_verificacao = pg_query($conexao, $query_verificacao);

	if( ! pg_num_rows($result_verificacao) )
	{
		print $query = "
				INSERT INTO 
					ep_people
					(
						" . ( $state != '' ? "fk_state," : "" ) . "
						" . ( $city != '' ? "fk_city," : "" ) . "
						lab_number
						,clear_person
						,clear_fantasy_name
						,person
						,fantasy_name
						,insc_juridic
						,address
						,address_number
						,complement
						,zip_code
						,post_box 
						,phone 
						,fax 
						,e_mail 
						,cellular
						,insc_state
						,insc_city
						,participation_type
						,obs
						,log_date
						,log_fk_user
					)
				VALUES 
					(
						" . ( $state != '' ? $state . "," : "" ) . "
						" . ( $city != '' ? $city . "," : "" ) . "
						" . $lab_number . ",
						'" . cleanString( $razao ) ."',
						'" . cleanString( $fantasia ) . "',
						'" . $razao . "',
						'" . $fantasia . "',
						'" . $cnpj . "',
						'" . $endereco . "',
						'" . $endereco_numero . "',
						'" . $complemento . "',
						'" . $cep . "',
						'" . $caixa_postal . "',
						'" . $telefone . "',
						'" . $fax . "',
						'" . $email . "',
						'" . $celular . "',
						'" . $insc_estadual . "',
						'" . $insc_municipal . "',
						" . $participacao . ",
						'" . $observacao . "',
						'NOW()',
						" . $user->getId() . "
					)";


		$result = pg_query( $conexao, $query );
		$num_rows = pg_affected_rows($result);


		$json = array(
					'rows' => $num_rows,
					);
			echo json_encode($json);
			exit;
	}else
	{
		$json = array(
					'rows' => '-1',
					);
			echo json_encode($json);
			exit;
	}

	

	//print $query;
	//exit;

	
	  
?>