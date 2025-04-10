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

	//print_r($_POST);


	$query_delete = " DELETE FROM sf_samp_service WHERE pk_samp_service = " . $_POST['samp_service'];
			
	$result_samp_service = pg_query( $conexao, $query_delete );


	$root = $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/upload/';
	$uploadfile = $root . '00img_' . $_POST['samp_service'] . '_' .$usuario->getId();

	if( file_exists( $uploadfile.'.png' ) )
	{
		@unlink($uploadfile . '.png');
	}else if( file_exists( $uploadfile.'.jpg' ) )
	{
		@unlink($uploadfile . '.jpg');
	}else if( file_exists( $uploadfile.'.jpeg' ) )
	{
		@unlink($uploadfile . '.jpeg');
	}


	

	if( ! @pg_affected_rows ($result_samp_service) )
	{
		$json = array(
				'error' => '10'
				//'query' => $query
				);
		echo json_encode($json);
		exit;
	}


	$json = array(
				'error' => '0'
				//'query' => $query
				);
		echo json_encode($json);
		exit;

?>