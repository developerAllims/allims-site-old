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


	 $query = " 
		select 
	  * 
	from 
	  sf_fc_getrelations
	  (
	    " . $_POST['k_id'] . "
	    ," . $_POST['k_unity'] . "
	    ," . str_replace(',', '.', ($_POST['k_result'] ? $_POST['k_result'] : 0)) . "
	    ," . $_POST['ca_id'] . "
	    ," . $_POST['ca_unity'] . "
	    ," . str_replace(',', '.', ($_POST['ca_result'] ? $_POST['ca_result'] : 0)) . "
	    ," . $_POST['mg_id'] . "
	    ," . $_POST['mg_unity'] . "
	    ," . str_replace(',', '.', ($_POST['mg_value'] ? $_POST['mg_value'] : 0)) . "
	    ," . $_POST['hal_id'] . "
	    ," . $_POST['hal_unity'] . "
	    ," . str_replace(',', '.', ($_POST['hal_value'] ? $_POST['hal_value'] : 0)) . "
	    ," . $_POST['al_id'] . "
	    ," . $_POST['al_unity'] . "
	    ," . str_replace(',', '.', ($_POST['al_value'] ? $_POST['al_value'] : 0)) . "
	    ," . $_POST['na_id'] . "
	    ," . $_POST['na_unity'] . "
	    ," . str_replace(',', '.', ($_POST['na_value'] ? $_POST['na_value'] : 0)) . "
	    ," . $_POST['argila_id'] . "
	    ," . $_POST['argila_unity'] . "
	    ," . str_replace(',', '.', ($_POST['argila_value'] ? $_POST['argila_value'] : 0)) . "
	    ," . str_replace(',', '.', ($_POST['silte_value'] ? $_POST['silte_value'] : 0)) . "
	  )
	";
	$result = pg_query($conexao, $query);
	$array = pg_fetch_assoc($result);

	$json = $array;
		echo json_encode($json);
		exit;
?>