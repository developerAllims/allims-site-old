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


	//print_r($usuario);

	//print_r($_GET);


	$pk_samp_service_folha = 'NULL';

	if( ($_GET['hidden_classe_r_foliar'] == 't' || $_GET['hidden_classe_r_foliar'] == 'true') && ( $_GET['amostra-folha'] != '' && $_GET['ano-folha'] != '' ) )
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

		if( pg_num_rows($result_folha) < 1 )
		{
			$json = array(
					'error' => '9'
				);
			echo json_encode($json);
			exit;	
		}

		$array_folha = pg_fetch_assoc( $result_folha );
		$pk_samp_service_folha = $array_folha['pk_samp_service'];
	}
	

	if ( (( str_replace(',', '.', $_GET['esprua'] ) ) * ( str_replace(',', '.', $_GET['espcova'] ) )) > 0 )
 	{
 		$result = ( 10000 / ( (str_replace(',', '.', $_GET['esprua'])) *  (str_replace(',', '.', $_GET['espcova']) ) ) );
	}else
	{
     	$result = 0;
	}


	if( $_GET['hidden_classe_espacamento'] == 't' || $_GET['hidden_classe_espacamento'] == 'true' )
	{
		$_GET['hidden_classe_espacamento'] = 'true';
	}else
	{
		$_GET['hidden_classe_espacamento'] = 'false';
	}

	if( $_GET['hidden_classe_c_resposta'] == 't' || $_GET['hidden_classe_c_resposta'] == 'true' )
	{
		$_GET['hidden_classe_c_resposta'] = 'true';
	}else
	{
		$_GET['hidden_classe_c_resposta'] = 'false';
	}

	//amostras_recomendaçoes -- Criar Campo para produção anterior

	$result = explode('.', $result);

	$query_recomendation = "SELECT * FROM sf_fc_request_recomendation(
		  1 
	    , " . $usuario->getId() . " 
	    , " . $_GET['hidden_classe_data_id'] . " 
	    , " . $pk_samp_service_folha . " 
	    , " . $_GET['cultures'] . " 
	    , " . $_GET['hidden_classe_espacamento'] . " 
	    , " . ( $_GET['esprua'] != '' ? str_replace(',', '.', $_GET['esprua']) : 'NULL') . " 
	    , " . ( $_GET['espcova'] != '' ? str_replace(',', '.', $_GET['espcova']) : 'NULL') . " 
	    , " . ( $result[0] != '' ? $result[0] : 'NULL') . " 
	    , 'MT' 
	    , " . ( $_GET['p-esperada'] != '' ? str_replace(',', '.', $_GET['p-esperada']) : 'NULL') . " 
	    , " . ( $_GET['p-anterior'] != '' ? str_replace(',', '.', $_GET['p-anterior']) : 'NULL') . " 
	    , '" . $_GET['hidden_classe_p_unidade'] . "' 
	    , " . ( $_GET['c-anterior'] != '' ? $_GET['c-anterior'] : 'NULL') . " 
	    , " . $_GET['hidden_classe_c_resposta'] . " 
	    , 'N' 
	    , " . ( $_GET['c-resposta'] != '' ? $_GET['c-resposta'] : 'NULL' ) . " 
	    , " . ( $_GET['q-sementes'] != '' ? str_replace(',', '.', $_GET['q-sementes']) : 'NULL' ) . " 
	    , '" . $_GET['hidden_classe_s_unidade'] . "' 
	    , " . ( $_GET['q-calda'] != '' ? str_replace(',', '.', $_GET['q-calda']) : 'NULL' ) . " 
	    , '" . $_GET['hidden_classe_c_unidade'] . "' 
	    , " . ( $_GET['t-cova'] != '' ? str_replace(',', '.', $_GET['t-cova']) : 'NULL' ) . "
	    , 7 
	    , true
	)";

	$result_recomendation = pg_query( $conexao, $query_recomendation );
	$array_recomendation = pg_fetch_assoc( $result_recomendation );
	$sf_fc_request_recomendation = $array_recomendation['sf_fc_request_recomendation'];


	$json = array(
					'error' => '0'
					,'result' => $sf_fc_request_recomendation
					//, 'query' => $query_recomendation
				);
			echo json_encode($json);
			exit;	

/*
--SELECT id_sf_tecnologia, id_sf_cultura, id_sf_versao FROM sf_cultures WHERE is_enabled = true AND project = 1 AND fk_technology = 1 AND id = 1 ORDER BY identification
--SELECT * FROM sf_pa_culturas WHERE tecnologia = 2 AND cultura = 19 AND versao = 1



SELECT 
  * 
FROM 
  sf_fc_request_recomendation(
	  1  --p_project integer,
	, 5 --p_pk_web_users integer,
	p_pk_samp_service_s integer,
	p_pk_samp_service_f integer,
	, 1 -- p_id_cultures integer,
	, true -- p_espacamento boolean,
	, 0.5 --p_esprua numeric,
	, 0.05 --p_espcova numeric,
	, 400000 --p_nroplantas integer,
	, 'MT' --p_unidadeespacamento character varying,
	, 2.50 --p_producaodesejada numeric,
	, 't/ha' --p_unidadeproducao character varying,
	, 64 --p_culturaanterior integer,
	, true --p_temclasseresposta boolean,
	, 'N' --Fixada por enquanto, porem deve ser buscada tb_determinações --p_cr_determinacao character varying,
	, 1 --p_cr_classeresposta integer,
	, 80.00 --p_qtdesementes numeric,
	, 'kg/ha' --p_unidsementes character varying,
	, 0.02 --p_qtdecaldapulverizacao numeric,
	,  --p_unidcaldapulverizacao character varying,
	p_qtdem3solocova numeric,
	, 7 --p_formulario integer,
	, true --p_gera_texto_rec boolean
	)
*/
 ?>