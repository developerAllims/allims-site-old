<?php 
	include 'conexao_bd.php';
	$conexao = conexao();

	$pk_samp_service_folha = 0;

	if( $_GET['amostra-folha'] != '' && $_GET['ano-folha'] != '' )
	{
		$query_folha = "SELECT
						   lb_samp_service.pk_samp_service
						FROM
						   lb_samp
						   INNER JOIN lb_samp_service ON ( lb_samp_service.fk_samp = lb_samp.pk_samp )
						WHERE
						       lb_samp.number_main = " . $_GET['amostra-folha'] . "
						   AND lb_samp.nyear = " . $_GET['ano-folha'] . "
						   AND lb_samp_service.fk_lab = 2
						ORDER BY
						   lb_samp_service.pk_samp_service
						LIMIT 1";

		$result_folha = pg_query( $conexao, $query_folha );
		$array_folha = pg_fetch_assoc( $result_folha );
		$pk_samp_service_folha = $array_folha['pk_samp_service'];
	}

		$json = array(
					'result' => $pk_samp_service_folha
				);
			echo json_encode($json);
			exit;	

?>