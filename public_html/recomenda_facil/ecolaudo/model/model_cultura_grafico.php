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
$param = $_GET['parametro'];

$size = strlen($param);

$param = substr($param,0, $size-1);




	$query_cultura 	= 'select
	  pk_culture
	 ,culture
	from
	  lb_cultures
	where
	  exists(
		select true from
		  lb_samp_service_det
		  inner join lb_pa_evaluation_items on lb_pa_evaluation_items.fk_pa_det_res = lb_samp_service_det.fk_pa_det_res
		where
		      lb_samp_service_det.fk_samp_service in ('.$param.')
		  and lb_pa_evaluation_items.fk_pa_evaluation = 9
		  and lb_pa_evaluation_items.fk_culture = lb_cultures.pk_culture
	  )
	order by
	  culture;';
	
	//echo $query_cultura;
	//exit;
	$result=pg_query( $conexao , $query_cultura );
	while ( $row = pg_fetch_array($result) ) 
	{
		$html .= '<li data-id="'.$row['pk_culture'].'"><div id="botao" class="bt_down fonte_padrao">'.$row['culture'].'</div></li>';
		
	}


//$result = array();


	$json = array('html' => $html );
		echo json_encode($json);
		exit;


?>