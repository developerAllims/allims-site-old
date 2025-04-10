<?php 
    require_once ('../modal/functions.php');
    require_once ('../modal/conex_bd.php');
    $conexao = conexao();

    $v_pk_samp_control = $_GET['samp'];

    $query = "
    		SELECT 
			   ep_samp_control.description
			  ,ep_samp_control.inf_add 			  
			  ,ep_program_year.number_year
			  ,ep_program_year_steps.number_of_year
			  ,ep_program_year_samp.samp_number
			FROM 
			  ep_samp_control
			  INNER JOIN ep_program_year_samp ON ep_program_year_samp.fk_samp_control = ep_samp_control.pk_samp_control
			  INNER JOIN ep_program_year_steps ON ep_program_year_steps.pk_program_year_steps = ep_program_year_samp.fk_program_year_steps  
			  INNER JOIN ep_program_year ON ep_program_year.pk_program_year = ep_program_year_steps.fk_program_year
			WHERE 
			  ep_samp_control.pk_samp_control = {$v_pk_samp_control}
			ORDER BY 
			  ep_program_year.number_year
			  ,ep_program_year_steps.number_of_year
			  ,ep_program_year_samp.samp_number
    		";

	$result = pg_query( $conexao, $query );
	$int = 0;
	while( $array = pg_fetch_array($result) )
	{
		$int++;
		print '<tr ' . ( $int%2 == 1 ? 'class="cinza_claro"' : '') . '>';
			print '<td>' . $array['number_year'] . '</td>';	//Ano
			print '<td>' . $array['number_of_year'] . '</td>'; //Etapa
			print '<td>' . $array['samp_number'] . '</td>'; //Amostra
			print '<td>' . $array['description'] . '</td>'; //descrição
			print '<td>' . $array['inf_add'] . '</td>'; //Info
		print '</tr>';
	}
?>