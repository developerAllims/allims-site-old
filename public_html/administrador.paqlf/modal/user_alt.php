<?php 
	include ('functions.php');
	require ('conex_bd.php');
	require ('acessos.php');
	$conexao = conexao();

	$nome 				= pg_escape_string($_POST['nome']);
	$trocar_senha 		= pg_escape_string($_POST['trocar_senha']);
	$senha 				= pg_escape_string($_POST['senha']);
	$re_senha 			= pg_escape_string($_POST['re-senha']);

	$query = "UPDATE ep_users SET 
					log_date = 'NOW()',
					log_fk_user = ".$user->getId().", 
					user_name='".$nome."' ";
	if( ($trocar_senha == 1) && ($senha == $re_senha) )
	{
		$query .= ",user_password='".$senha."' ";
					
	}
		$query .= " WHERE pk_user=" . $user->getId();

	$result = pg_query( $query );
	$num_rows = pg_affected_rows($result);

	if( $num_rows )
	{
		$sess = Sessao::instanciar();
		$user->setNome($nome);
		$sess->set('usuario', $user);
	}

	$json = array(
					'rows' => $num_rows,
					);
			echo json_encode($json);
			exit;

?>