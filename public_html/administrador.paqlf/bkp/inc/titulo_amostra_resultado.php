<?php 
    require_once ('../modal/functions.php');
    require_once ('../modal/conex_bd.php');
    $conexao = conexao();

    $query_titulo = "SELECT
    ep_program_year.number_year
    ,ep_program_year_steps.number_of_year
    ,ep_program_year_samp.samp_number
    ,ep_samp_control.description
FROM
    ep_program_year
    INNER JOIN ep_program_year_steps ON ( ep_program_year_steps.fk_program_year      = ep_program_year.pk_program_year             )
    INNER JOIN ep_program_year_samp  ON ( ep_program_year_samp.fk_program_year_steps = ep_program_year_steps.pk_program_year_steps )
    LEFT JOIN ep_samp_control 	     ON ( ep_samp_control.pk_samp_control 	     = ep_program_year_samp.fk_samp_control )
    WHERE
		ep_program_year_samp.pk_program_year_samp = " . $_GET['samp'] . "
	ORDER BY
	     ep_program_year.number_year DESC
	    ,ep_program_year_samp.samp_number ASC";

	$result_titulo = pg_query( $conexao, $query_titulo );
	$array_titulo = pg_fetch_all($result_titulo);


	//print  $array_titulo[0]['person'];

	print 'Ano ' . $array_titulo[0]['number_year'] . ' - Etapa ' . $array_titulo[0]['number_of_year'] . ' - Amostra ' . $array_titulo[0]['samp_number'] . ' - ' . $array_titulo[0]['description'];
?>