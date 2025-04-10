<?php 
	date_default_timezone_set('America/Sao_Paulo');

	session_start();

	require_once '../controller/login_usuario.php';

	require_once '../controller/login_autenticador.php';

	require_once '../controller/login_sessao.php';



	$aut = Autenticador::instanciar();

	if( $aut->esta_logado() )

	{

		$user = $aut->pegar_usuario();

	}else

	{

		$aut->expulsar();

	}

	//print_r($user);

?>