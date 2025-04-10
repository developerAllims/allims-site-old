<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$fk_person 		= $_GET['lab_on'];
	$contact 		= $_GET['nome'];
	$office 		= $_GET['escritorio'];
	$departament 	= $_GET['departamento'];
	$phone 			= $_GET['telefone'];
	$cellular 		= $_GET['celular'];
	$e_mail 		= $_GET['email'];
	$inf_addic 		= $_GET['informacoes'];

	$query = "INSERT INTO 
				ep_people_contacts 
				(
					fk_person
					, contact
					, office
					, departament
					, phone
					, cellular
					, e_mail
					, inf_addic
					,log_date
					,log_fk_user
				) 
				VALUES 
				(
					{$fk_person},
					'{$contact}',
					'{$office}',
					'{$departament}',
					'{$phone}',
					'{$cellular}',
					'{$e_mail}',
					'{$inf_addic}',
					'NOW()',
					{$user->getId()}
				) RETURNING pk_person_contacts";
	$result = pg_query( $conexao , $query );
	$pk_contato = pg_fetch_assoc($result);

	if( ! $pk_contato )
	{
		$error = 1;
	}else
	{
		$error = 0;
	}


	$json = array(
					'error' => $error,
					'dados' => $query,
					'acao'		=> 1
					);
			echo json_encode($json);
			exit;
?>