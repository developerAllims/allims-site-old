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
// Parametros passados por POST
$email = $_POST['email'];
$param = $_POST['parametro'];

//Variavel de erro
$error = '';

	//Verifica se o usuario já existe
	$query = "SELECT * FROM sf_web_users WHERE user_login ='" . pg_escape_string($email) . "'";
	$result=pg_query( $conexao , $query );
	$num_rows = pg_num_rows($result);
	
	//Verificação de resultados da query anterior, caso não haja retorno ele entrará no IF
	
	if( ! $num_rows )
	{
		$error = 'Usuário não cadastrado.';
	}else if( $num_rows )
	{
		$export_amostras = "
				SELECT
				  *
				FROM
				  sf_fc_copy_samp_service( array[" . implode(',', $param ) . "] , '" . pg_escape_string($email) . "')
			";

		$result_amostras = pg_query($conexao, $export_amostras);
		$row_amostras = pg_fetch_assoc($result_amostras);

		if( $row_amostras['sucessful'] == 'f' || $row_amostras['sucessful'] == 'false' )
		{
			$json = array(
					'error' 	=> $row_amostras['message']
					);
			echo json_encode($json);
			exit;
		}
		
	} 
	
	
	$json = array(
					'error' 	=> $error
					,'query'	=> $export_amostras
					);
			echo json_encode($json);
			exit;
	
	
?>