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



$id 	    = $_POST['id'];

$amostra 	= $_POST['amostra'];





$query = "DELETE FROM sf_amostras_recomendacoes WHERE laboratorio = 1 AND id = {$id} AND amostra = {$amostra}";

$result = @pg_query($conexao, $query);



$acao = @pg_affected_rows( $result ) ; 






$json = array(

			'acao'	=> ($acao == '' ? 0 : $acao )

			);

	echo json_encode($json);

	exit;



?>