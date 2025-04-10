<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$pk_person_contacts		= $_POST['contato'];
	$fk_person 				= $_POST['lab_on'];
	$contact 				= $_POST['nome'];
	$office 				= $_POST['escritorio'];
	$departament 			= $_POST['departamento'];
	$phone 					= $_POST['telefone'];
	$cellular 				= $_POST['celular'];
	$e_mail 				= $_POST['email'];
	$inf_addic 				= $_POST['informacoes'];

	$query = "UPDATE  
				ep_people_contacts 
					SET 
						  contact = '{$contact}'
						, office = '{$office}'
						, departament = '{$departament}'
						, phone = '{$phone}'
						, cellular = '{$cellular}'
						, e_mail = '{$e_mail}'
						, inf_addic ='{$inf_addic}'
						, log_date = 'NOW()'
						, log_fk_user = {$user->getId()}
					WHERE 
						fk_person = {$fk_person}
						AND pk_person_contacts = {$pk_person_contacts} ";

	$result = pg_query( $conexao , $query );
	$num_rows = pg_affected_rows($result);

	$json = array(
					'rows' => $num_rows
					);
			echo json_encode($json);
			exit;
?>