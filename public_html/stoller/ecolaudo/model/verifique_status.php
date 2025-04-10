<?php
	header ('Content-type: text/html; charset=iso-8859-1');
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



	/*$query = "SELECT
		sf_fc_get_recomendation_status
		  (
		    sf_amostras_recomendacoes.id
		    , sf_amostras_recomendacoes.calculado
		    , sf_amostras_recomendacoes.have_error
		  ) 
		  , sf_amostras_recomendacoes.message_error
		FROM 
		  sf_amostras_recomendacoes 
		WHERE
		  sf_amostras_recomendacoes.laboratorio = 1 
		  AND sf_amostras_recomendacoes.amostra = " . $_REQUEST['pk_samp_service'] . " /*pk_samp_service
		  AND sf_amostras_recomendacoes.ano = ".$usuario->getId()." /*pk_web_user";*/

   $query = "
		SELECT    
             COALESCE(sf_recomendacoes_controle.qtty_rec, 0) as qtty_fert
            ,sf_recomendacoes_controle.id[1] as rec_id_1
            ,sf_recomendacoes_controle.id[2] as rec_id_2
            ,sf_recomendacoes_controle.id[3] as rec_id_3
            ,sf_recomendacoes_controle.id[4] as rec_id_4
            ,sf_recomendacoes_controle.id[5] as rec_id_5

            ,sf_recomendacoes_controle.cultura[1] as rec_cultura_1
            ,sf_recomendacoes_controle.cultura[2] as rec_cultura_2
            ,sf_recomendacoes_controle.cultura[3] as rec_cultura_3
            ,sf_recomendacoes_controle.cultura[4] as rec_cultura_4
            ,sf_recomendacoes_controle.cultura[5] as rec_cultura_5

            ,sf_recomendacoes_controle.status[1] as rec_status_1
            ,sf_recomendacoes_controle.status[2] as rec_status_2
            ,sf_recomendacoes_controle.status[3] as rec_status_3
            ,sf_recomendacoes_controle.status[4] as rec_status_4
            ,sf_recomendacoes_controle.status[5] as rec_status_5

            ,sf_recomendacoes_controle.message_error[1] as rec_message_1
            ,sf_recomendacoes_controle.message_error[2] as rec_message_2
            ,sf_recomendacoes_controle.message_error[3] as rec_message_3
            ,sf_recomendacoes_controle.message_error[4] as rec_message_4
            ,sf_recomendacoes_controle.message_error[5] as rec_message_5

		FROM
		 	sf_recomendacoes_controle 
		 WHERE    
			sf_recomendacoes_controle.Laboratorio = 1
             AND sf_recomendacoes_controle.Amostra = " . $_REQUEST['pk_samp_service'] . "
             AND sf_recomendacoes_controle.Ano = ".$usuario->getId()."

    ";


 	$result = pg_query( $conexao, $query );
	$array = pg_fetch_assoc( $result );
	//$sf_fc_request_recomendation = $array_recomendation['sf_fc_request_recomendation'];


	$html = '';
	
	if( $array['sf_fc_get_qtty_rec'] < 5 )
	{
		$html .= '<button class="recomendar" data-id="'.$_REQUEST['pk_samp_service'].'" type="button"></button>';
	}

	for( $int_rec = 1; $int_rec <= $array['sf_fc_get_qtty_rec']; $int_rec++ )
	{
		if( $array["rec_status_".$int_rec] == 0 ) 
		{
			
		}else if( $array["rec_status_".$int_rec] == 1 ) 
		{
			$html .= '<button class="rec_editar" title="'. utf8_decode($array["rec_cultura_".$int_rec]) .'" data-id="'.$_REQUEST['pk_samp_service'].'" data-value="'.$array["rec_id_".$int_rec].'"></button>';

		}else if( $array["rec_status_".$int_rec] == 2 ) 
		{
			$html .= '<div class="calc_aguardando" title="'. utf8_decode($array["rec_cultura_".$int_rec]) .'" data-id="'.$_REQUEST['pk_samp_service'].'"></div>';
		}else if( $array["rec_status_".$int_rec] == 3 ) 
		{
			$html .= '<div class="calc_erro" data-rel="'.utf8_decode($array["rec_message_".$int_rec]).'"  data-id="'.$_REQUEST["pk_samp_service"].'" data-value="'.$array["rec_id_".$int_rec].'"></div>';
			//$html .=  preg_replace('/\s/',' ',preg_replace('/( )+/',' ',utf8_decode($array["rec_message_".$int_rec])));
			//$html .= '<div class="calc_erro" data-id="'.utf8_decode($array["rec_message_".$int_rec]).'" data-id="'.$_REQUEST['pk_samp_service'].'" data-value="'.$array["rec_id_".$int_rec].'"></div>';
		}
	}
	



	$json = array(
					'error' => '0'
					,'result' => $html
					//, 'message_error' => 'data-rel="'.preg_replace('/\s/',' ',utf8_decode($array["rec_message_".$int_rec]))
					//, 'query' => $query
				);
			echo json_encode($json);
			exit;	
?>