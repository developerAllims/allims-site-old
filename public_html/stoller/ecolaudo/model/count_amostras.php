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
	include 'conexao_bd.php';
	$conexao = conexao();
	

	$query_verificacao = "
            SELECT 
               sf_samp_service.imput_type
              ,COALESCE(sf_recomendacoes_controle.qtty_rec, 0) as qtty_fert
            FROM
              sf_samp_service
              LEFT JOIN sf_recomendacoes_controle ON (     sf_recomendacoes_controle.Laboratorio = 1
                                                         AND sf_recomendacoes_controle.Amostra = sf_samp_service.pk_samp_service
                                                         AND sf_recomendacoes_controle.Ano = " . $usuario->getId()  . " )
            WHERE 
              sf_samp_service.pk_samp_service = " . $_GET['samp_service'];
        $result_verificacao = @pg_query($conexao, $query_verificacao);
        $array_verificacao = @pg_fetch_assoc($result_verificacao);

    if( $array_verificacao['qtty_fert'] > 0 )
    {
     	$json = array(
     				'error' => 1
					,'message' => 'Você não pode alterar uma amostra com recomendações agoranômicas'
				);
			echo json_encode($json);
			exit;	
   
    }else
    {
    	$json = array(
     				'error' => 0
				);
			echo json_encode($json);
			exit;	
    	//header('Location: /cadastro/'+$_GET['samp']);
    }
?>