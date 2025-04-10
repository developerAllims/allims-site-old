<?php 
	


	require_once ('acessos.php'); 

	require_once ('conex_bd.php');

	//include 'functions.php';



	/*print '0';

	exit;*/



	$conexao = conexao();



//$param = $_GET['web_id_relatorio'];





/*if( empty($param) ) 

{

	header("Location:javascript://history.go(-1)");

	exit;

}*/



$name = date("YmdHis");



header('Content-Type: text/csv; charset=utf-8');

header('Content-Disposition: attachment; filename='.$name.'.csv');





$fp = fopen('php://output', 'w');



	//pg_escape_string($_GET['year_samp']);

	//ep_program_year_steps.fk_program_year = " . $_GET['program_year'] . "



	$query_ano = "

		SELECT 

		    ep_program_year_samp.pk_program_year_samp

		   ,ep_program_year_steps.number_of_year

		   ,ep_program_year_samp.samp_number

		   ,ep_program_year.number_year

		   ,ep_program_year_steps.fk_program_year

		FROM

		   ep_program_year_samp

		   INNER JOIN ep_program_year_steps ON ( ep_program_year_steps.pk_program_year_steps = ep_program_year_samp.fk_program_year_steps )

		   INNER JOIN ep_program_year ON ( ep_program_year.pk_program_year = ep_program_year_steps.fk_program_year )

		   LEFT JOIN ep_samp_control ON ( ep_samp_control.pk_samp_control = ep_program_year_samp.fk_samp_control )

		WHERE 

		   ep_program_year_samp.pk_program_year_samp in ( " . pg_escape_string($_GET['year_samp']) . " )

		ORDER BY 

		   ep_program_year_samp.samp_number

	";



	$result_ano = pg_query($conexao, $query_ano);







	







	//Declaração de Variaveis

	$verificacao = ''; //Teste de tipo de amostra

	$cabecalho = array();

	$tecnica= array();

	$unidade = array();

	$valores = array();



	//Iniciando matriz que sera o csv

	$matriz = array();

	



	$l = 0;

	while ( $array_ano = pg_fetch_array($result_ano) ) 

	{

		//print $_GET['program_year'];

		$l = $l + 2;

		$v = 0;



		$matriz[($l+1)][$v] = zeraCabecalho();

		$matriz[($l+2)][$v] = zeraTecnica();

		$matriz[($l+3)][$v] = zeraUnidade();

		$matriz[($l+4)] = zeraValores();





		$query_determinacao = "

		SELECT

		     ep_pa_det_res.report_abbrev

		    ,ep_pa_unity.abbrev as unity

		    ,ep_pa_det_res.report_technic

		    ,ep_pa_det_res.norder

		    ,ep_pa_unity.pk_pa_unity

		    ,ep_pa_det_res.pk_pa_det_res

		FROM

		    ep_program_year_det_res

		    INNER JOIN ep_pa_det_res ON ( ep_pa_det_res.pk_pa_det_res = ep_program_year_det_res.fk_pa_det_res )

		    INNER JOIN ep_pa_unity   ON ( ep_pa_unity.pk_pa_unity = ep_program_year_det_res.fk_pa_unity )

		WHERE

			    ep_program_year_det_res.fk_program_year = " . $array_ano['fk_program_year'] . "

			AND ep_program_year_det_res.is_enabled = true

		ORDER BY 

		    ep_pa_det_res.norder

		";



		$result_determinacao = pg_query($conexao, $query_determinacao);





		while ( $array_determinacao = pg_fetch_array($result_determinacao ) )

		{

			$matriz[($l+1)][0][] = utf8_decode($array_determinacao['report_abbrev']);

			$matriz[($l+2)][0][] = utf8_decode($array_determinacao['report_technic']);

			$matriz[($l+3)][0][] = utf8_decode($array_determinacao['unity']);

		}



		$l = $l+4;



		$query_laboratorios = "

			SELECT

			    ep_people.pk_person

			    ,ep_people.lab_number

			    ,ep_people_samp.pk_people_samp

			FROM

			    ep_program_year_samp

			    INNER JOIN ep_people_samp    ON ( ep_people_samp.fk_program_year_samp        = ep_program_year_samp.pk_program_year_samp )

			    INNER JOIN ep_people	     ON ( ep_people.pk_person = ep_people_samp.fk_person )

			WHERE

				ep_program_year_samp.pk_program_year_samp = " . $array_ano['pk_program_year_samp'] . "

				AND ep_people_samp.not_send = false

				AND ep_people_samp.is_used = true

			ORDER BY

				ep_people.lab_number

		";

		

		$result_laboratorios = pg_query( $conexao, $query_laboratorios);

		while ( $array_laboratorios = pg_fetch_array($result_laboratorios) ) 

		{



			$matriz[$l][$v][] = utf8_decode($array_ano['number_of_year']); //Etapa

			$matriz[$l][$v][] = utf8_decode($array_ano['samp_number']);//Amostra

			$matriz[$l][$v][] = utf8_decode($array_ano['number_year']);//Ano

			$matriz[$l][$v][] = utf8_decode($array_laboratorios['lab_number']);//Laboratório



			$query_resultados = "

				SELECT    

				     pk_pa_det_res

				    ,ep_fc_get_res_from_samp_clear 

				    ( 

				     " . $array_laboratorios['pk_people_samp'] . "

				    ,ep_pa_det_res.pk_pa_det_res

				    ,ep_fc_get_pk_unity_for_det_res ( " . $array_laboratorios['pk_person'] . " , pk_pa_det_res ) 

				    ,true

				    ) as resultado

				FROM

				    ep_pa_det_res

				WHERE

				    is_enabled = true

				ORDER BY

				    norder

			";



			$result_resultados = pg_query( $conexao, $query_resultados );

			while ( $array_resultados = pg_fetch_array($result_resultados) ) 

			{

				$matriz[$l][$v][] = $array_resultados['resultado'];



			}

			$v++;

		}





		$l += 1;

		$v = 0;

		for( $int = 1; $int <= 3; $int++)

		{

			

			$matriz[$l][$v][] = utf8_decode($int.'ª');

			$matriz[$l][$v][] = 'MED';

			$matriz[$l][$v][] = '';

			$matriz[$l][$v][] = '';

			$query = "SELECT    

					     pk_pa_det_res

					    ,(ep_fc_get_avgs_from_samp ( ". $array_ano['pk_program_year_samp'] . ", ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( 1, pk_pa_det_res ) )).value_".$int."_avg as n_avg

					    ,norder

					FROM

					    ep_pa_det_res

					WHERE

					    is_enabled = true

					ORDER BY

					    norder";

			//print $query;

		    $result = pg_query($conexao, $query);

		    while ( $array_med = pg_fetch_array($result) ) 

			{

				$matriz[$l][$v][] = ($array_med['n_avg'] == null ? '-' : str_replace('.',',',$array_med['n_avg']));

			}

			$v++;

		

			$matriz[$l][$v][] = utf8_decode($int.'ª');

			$matriz[$l][$v][] = 'S';

			$matriz[$l][$v][] = '';

			$matriz[$l][$v][] = '';

			$query = "SELECT    

					     pk_pa_det_res

					    ,(ep_fc_get_avgs_from_samp ( ". $array_ano['pk_program_year_samp'] . ", ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res (1, pk_pa_det_res ) )).value_".$int."_s as n_s

					    ,norder

					FROM

					    ep_pa_det_res

					WHERE

					    is_enabled = true

					ORDER BY

					    norder";

			//print $query;

		    $result = pg_query($conexao, $query);

		    while ( $array = @pg_fetch_array($result) ) 

			{

				$matriz[$l][$v][] = ($array['n_s'] == null ? '-' : str_replace('.',',',$array['n_s']));

			}

			$v++;

		

			$matriz[$l][$v][] = utf8_decode($int.'ª');

			$matriz[$l][$v][] = 'CV%';

			$matriz[$l][$v][] = '';

			$matriz[$l][$v][] = '';

			$query = "SELECT    

					     pk_pa_det_res

					    ,(ep_fc_get_avgs_from_samp ( ". $array_ano['pk_program_year_samp'] . ", ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( 1, pk_pa_det_res ) )).value_".$int."_cv as n_cv

					    ,norder

					FROM

					    ep_pa_det_res

					WHERE

					    is_enabled = true

					ORDER BY

					    norder";

			//print $query;

		    $result = pg_query($conexao, $query);

		    while ( $array = @pg_fetch_array($result) ) 

			{

				$matriz[$l][$v][] = ($array['n_cv'] == null ? '-' : str_replace('.',',',$array['n_cv']));

			}

			$v++;

		

			$matriz[$l][$v][] = utf8_decode($int.'ª');

			$matriz[$l][$v][] = 'MIN';

			$matriz[$l][$v][] = '';

			$matriz[$l][$v][] = '';

			$query = "SELECT    

					     pk_pa_det_res

					    ,(ep_fc_get_avgs_from_samp ( ". $array_ano['pk_program_year_samp'] . ", ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( 1, pk_pa_det_res ) )).value_".$int."_min as n_min

					    ,norder

					FROM

					    ep_pa_det_res

					WHERE

					    is_enabled = true

					ORDER BY

					    norder";

			//print $query;

		    $result = pg_query($conexao, $query);

		    while ( $array = @pg_fetch_array($result) ) 

			{

				$matriz[$l][$v][] = ($array['n_min'] == null ? '-' : str_replace('.',',',$array['n_min']));

			}

			$v++;

		

			$matriz[$l][$v][] = utf8_decode($int.'ª');

			$matriz[$l][$v][] = 'MAX';

			$matriz[$l][$v][] = '';

			$matriz[$l][$v][] = '';

			$query = "SELECT    

					     pk_pa_det_res

					    ,(ep_fc_get_avgs_from_samp ( ". $array_ano['pk_program_year_samp'] . ", ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( 1, pk_pa_det_res ) )).value_".$int."_max as n_max

					    ,norder

					FROM

					    ep_pa_det_res

					WHERE

					    is_enabled = true

					ORDER BY

					    norder";

			//print $query;

		    $result = pg_query($conexao, $query);

		    while ( $array = @pg_fetch_array($result) ) 

			{

				$matriz[$l][$v][] = ($array['n_max'] == null ? '-' : str_replace('.',',',$array['n_max']));

			}

			$v++;

		}





		



		/*print '<pre>';

		print_r($matriz);

		print '</pre>';

		exit;*/

		

	}



/*

	print '<pre>';

	print_r($matriz);

	print '</pre>';



	print 'minha conta - ' . count($matriz);

	print 'minha conta com max ' . max(array_keys($matriz));

	exit;*/





	gravaLinha( $fp, $matriz[0][0] );

	gravaLinha( $fp, $matriz[1][0] );

	gravaLinha( $fp, $matriz[2][0] );	

	

	for($f = 1; $f <= max(array_keys($matriz)); $f++ )

	{

		for( $c = 0; $c < count($matriz[$f]); $c++ )

		{

			//ksort($matriz[3][$f]);

			//if( empty($matriz[3][$f][$c]) || ( ! array_key_exists( $c, $matriz[3][$f] ) ) || (!isset($matriz[3][$f][$c]) ) )

			/*if( !array_key_exists($c,$matriz[3][$f]) )

			{

				$matriz[3][$f][$c] = ' - ';

			}*/

			gravaLinha( $fp, $matriz[$f][$c] );

			//print $matriz[$f][$c] . '<br>';

		}

		

		

	}

	

	//print array_key_exists('[50]',$matriz[3][3]);

	//print strripos($matriz[3][3][40],'97');

	

	

	/*print '<pre>';

	print_r($matriz);

	print '</pre>';

	print '----';

	gravaLinha( $fp, $cabecalho );

	gravaLinha( $fp, $tecnica );

	gravaLinha( $fp, $unidade );

	

	for( $f = 0; $f < count($valores); $f++ )

	{

		gravaLinha( $fp, $valores[$f] );

	}*/

//Instacia Cabeçalho

	//zera_cabecalho();

//Cabeçalho aparentemente padrão ------------- FIM

// A partir daqui, o cabeçalho muda conforme a tipo de amostra - Siglas da amostra - Dinamica





//2 linha, essa será populada somente as celulas apos a identificação

	//zera_tecnica();

//A partir daqui, ela deve ser populada com as tecnicas, e será dinamico





//3 linha, essa será populada somente as celulas apos a identificação

	//zera_unidade();

//A partir daqui, ela deve ser populada com a unidade, e será dinamico



//Linha 4 -> Valores

//$valores = array();









fclose($fp);







//ALL Functions ------

	//Function Zera Cabeçalho

	function zeraCabecalho()

	{

		$cabecalho = array();

		//Cabeçalho aparentemente padrão ------------- Inicio 

		$cabecalho[] = utf8_decode('Etapa');

		$cabecalho[] = utf8_decode('Amostra');

		$cabecalho[] = utf8_decode('Ano');

		$cabecalho[] = utf8_decode('Número Laboratório');

		



		return $cabecalho;

	}



	//Function Zera Tecnica

	function zeraTecnica()

	{

		$tecnica = array();

		$tecnica[] = '';

		$tecnica[] = '';

		$tecnica[] = '';

		$tecnica[] = '';

		

		return $tecnica;

	}



	// Function zera Unidade

	function zeraUnidade()

	{

		$unidade = array();

		$unidade[] = '';

		$unidade[] = '';

		$unidade[] = '';

		$unidade[] = '';

		

		return $unidade;

	}

	

	function zeraValores()

	{

		return $valores = array();

	}

	// Passando data do banco "AAAA-MM-DD" para "DD/MM/AAAA" //

	function mostraData ($data) {

		if ($data!='') {

		   return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4));

		}

		else { return ''; }

	}	

	

	function gravaLinha( $fp, $array )

	{

		if( is_array($array) )

		{

			fputcsv($fp, array_values($array), ';');

		}else

		{

			//print 'estou aqui';

		}

	}

?>