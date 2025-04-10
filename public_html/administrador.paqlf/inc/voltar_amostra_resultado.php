<?php 
    require_once ('../modal/functions.php');
    require_once ('../modal/conex_bd.php');
    $conexao = conexao();

    $query_titulo = "
        SELECT 
            pk_program_year
        FROM 
            ep_program_year_samp
            INNER JOIN ep_program_year_steps ON ep_program_year_steps.pk_program_year_steps = ep_program_year_samp.fk_program_year_steps
            INNER JOIN ep_program_year ON ep_program_year.pk_program_year = ep_program_year_steps.fk_program_year
        WHERE pk_program_year_samp = " . $_GET['samp'];

	$result_titulo = pg_query( $conexao, $query_titulo );
	$array_titulo_a = pg_fetch_all($result_titulo);


	//print  $array_titulo[0]['person'];

	print '<a href="/programa/amostra/' . $array_titulo_a[0]['pk_program_year'] . '" class="voltar"></a>';
?>