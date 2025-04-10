<?php
	require_once '../controller/login_autenticador.php';
	require_once '../controller/login_sessao.php';
	require_once '../controller/login_usuario.php';
    session_start();
	 
	$aut = Autenticador::instanciar();
    // Verificando login do usuÃ¡rio //	 
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}
	else {
		$aut->expulsar();
	}

	include 'conexao_bd.php';
	$conexao = conexao();

	

	$query_update = "UPDATE 
	  sf_amostras_recomendacoes 
	SET 
	  recomendacao_html = '" . pg_escape_string($_POST['tags_html']) . "'
	WHERE 
	      sf_amostras_recomendacoes.laboratorio = 1
	  and sf_amostras_recomendacoes.id = ". $_POST['id'] . "
	  and sf_amostras_recomendacoes.amostra = ". $_POST['amostra'] . "
	  and sf_amostras_recomendacoes.ano = " . $usuario->getId();


	$result = pg_query($conexao, $query_update);
	if( pg_affected_rows($result) > 0 )
	{
		$json = array(	'error' => 0
						,'query' => $query_update	);
			echo json_encode($json);
			exit;
	}else
	{
		$json = array(	'error' => 1
		,'query' => $query_update	);
			echo json_encode($json);
			exit;
	}
?>