<?php 
//echo 'oi';
include_once 'conexao_bd.php';

function logs( $amostra = 0, $login = false, $exportation = false ) 
{
	session_start();
	require_once $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/controller/login_usuario.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/controller/login_sessao.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/controller/login_autenticador.php';
	 
	$aut = Autenticador::instanciar();
	 
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}
	else {
		$aut->expulsar();
	}
	
	
	$conn = conexao();
		
	$query = "INSERT INTO lb_web_users_logs ";
	$query .= "( fk_web_users, fk_samp_service, user_ip, is_login, is_exportation, date_time) ";
	$query .= " VALUES ( ";
	$query .= $usuario->getId() . " ,";
	$query .= $amostra . " ,";
	$query .= "'" . $_SERVER['REMOTE_ADDR'] . "' ,";
	$query .= $login ? "true," : "false," ;
	$query .= $exportation ? "true," : "false,";
	$query .= "NOW()";
	$query .= ")";
	
	$res=pg_query( $conn , $query );

	
}
?>