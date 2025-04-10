<?php 
	include ('functions.php');
	require ('conex_bd.php');
	require ('acessos.php');
	$conexao = conexao();

	$nome 				= pg_escape_string($_POST['nome']);
	$amostras 			= $_POST['amostra'] == 'true' ? 'true' : 'false';
	$lab				= $_POST['laboratorio'] == 'true' ? 'true' : 'false';
	$usuario			= $_POST['check_usuario'] == 'true' ? 'true' : 'false';
	$selo				= $_POST['selo'] == 'true' ? 'true' : 'false';
	$ativo				= $_POST['ativo'] == 'true' ? 'true' : 'false';
	$id_usuario 		= pg_escape_string($_POST['usuario']);

	$query = "UPDATE ep_users SET 
					user_name='" . $nome . "',
					can_imput_results='" . $amostras . "',
					can_update_lab='" .$lab."', 
					can_adm_users='".$usuario."',
					can_request_seals='".$selo."',
					is_active='".$ativo."',
					log_date = 'NOW()',
					log_fk_user = " . $user->getId() . " 
				WHERE pk_user=" . $id_usuario;

	//print $query;
	//exit;
	$result = pg_query( $query );
	$num_rows = pg_affected_rows($result);

	$json = array(
					'rows' => $num_rows,
					);
			echo json_encode($json);
			exit;

?>