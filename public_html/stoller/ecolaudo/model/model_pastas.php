<?php
session_start();
require_once '../controller/login_usuario.php';
require_once '../controller/login_sessao.php';
require_once '../controller/login_autenticador.php';
 
$aut = Autenticador::instanciar();
 
$usuario = null;
if ($aut->esta_logado()) {
	$usuario = $aut->pegar_usuario();
}
else {
	$aut->expulsar();
}

include_once("conexao_bd.php");
$conexao = conexao();

$acao 	= $_POST['acao'];
$param 	= $_POST['parametro'];



if( $acao == 'inc' )
{
	$array_replace = array(
							'\''
							,'\\'
							,'/'
							,':'
							,'*'
							,'?'
							,'"'
							,'&'
							,'<'
							,'>'
							,'|'
							,'-'
							,'.'
							,','
							,'@'
							,'$'
							,'¨'
							,'!'
							,'#'
							,'%'
							,'*'
							,'^'
							,'~'
							,'`'
							,'´'
							,'('
							,')'
							,'+'
							,'_'
							,'{'
							,'}'
							,'['
							,']'
							,'ª'
							,'º'
							,'§'
						);

	$var = str_replace($array_replace, '', $param);

	if( empty(trim($var)) )
	{
		$json = array(
					'rows' => 1,
					'error' => 2,
					'message' => 'Nome de pasta apenas com caracteres inválidos',
					'acao'		=> 1
					);
			echo json_encode($json);
			exit;
	}

	$query_select = "SELECT * FROM sf_web_users_folders WHERE fk_web_users = ".$usuario->getId()." AND sf_fc_remove_signals(trim(replace( sf_fc_remove_acentuation(LOWER(folder_name)), ' ' , ''))) = sf_fc_remove_signals(trim(replace( sf_fc_remove_acentuation(LOWER('" . pg_escape_string($param). "')), ' ' , '')))";
	$result_select = pg_query( $conexao, $query_select);

	if( pg_num_rows($result_select) > 0 )
	{
		$json = array(
					'rows' => 1,
					'error' => 4,
					'message' => 'Já exista uma pasta com o mesmo nome',
					'acao'	=> 1
					);
			echo json_encode($json);
			exit;
	}


	$query = "INSERT INTO sf_web_users_folders (fk_web_users, folder_name) VALUES ('" . $usuario->getId() . "',sf_fc_remove_signals(trim('" . pg_escape_string($param) . "')))  RETURNING pk_web_users_folders" ;
	$result=pg_query( $conexao , $query );
	
	$num_rows = pg_fetch_assoc($result);
	
	$result_sel=pg_query( $conexao , "SELECT * FROM sf_web_users_folders WHERE pk_web_users_folders=" . $num_rows['pk_web_users_folders'] );
	$row = pg_fetch_assoc($result_sel);
	
	
	$json = array(
					'rows' => $num_rows['pk_web_users_folders'],
					'parametros' => $row,
					'error' => 0,
					'acao'		=> 1
					);
			echo json_encode($json);
			exit;
	
	
	
	
	
	
	
	
	
} else if ( $acao == 'mov' )
{
	
	//Folders ----  Campo 0 do array sempre sera o id da pasta que sera movida 
	for( $i = 1; $i < count($param); $i++ )
	{
		$query = "UPDATE sf_web_users_or SET fk_web_users_folders=".$param[0] ." WHERE pk_web_users_or='".$param[$i]."' AND fk_web_users=".$usuario->getId();
		$result	= pg_query($conexao, $query);
		$num_rows = pg_affected_rows($result);
	}
	
	$json = array(
					'rows' => $num_rows,
					'query' => $query,
					'acao'=> 2
					);
			echo json_encode($json);
			exit;
			
			
}else if ( $acao == 'exc' )
{
			
	$query 	= "SELECT * FROM sf_web_users_folders WHERE fk_web_users = ".$usuario->getId()." AND replace( sf_fc_remove_acentuation(LOWER(folder_name)), ' ' , '') = replace( sf_fc_remove_acentuation(LOWER('" . $param['title']. "')), ' ' , '') AND pk_web_users_folders=" . $param['id'];

	$result	= pg_query($conexao, $query);
	$num_rows = pg_num_rows($result);
	
	//print $num_rows;
	//exit;
	if( $num_rows )
	{	
		$query_del = "DELETE FROM sf_web_users_folders WHERE pk_web_users_folders =" . $param['id'];
		$result	= @pg_query($conexao, $query_del);
		$num_rows = @pg_affected_rows($result);
		$error = @pg_last_error($conexao);
	}

	$json = array(
					'rows' => $num_rows,
					'error' => $error,
					'acao'		=> 3
					);
			echo json_encode($json);
			exit;
}


?>