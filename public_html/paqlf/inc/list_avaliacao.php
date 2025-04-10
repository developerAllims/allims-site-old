<?php 
	date_default_timezone_set('America/Sao_Paulo');
	require_once ('../modal/functions.php');

	require_once ('../modal/acessos.php');

	require_once ('../modal/conex_bd.php');

	$conexao = conexao();

	$fk_pa_det_res_groups = ($_GET['id'] ? $_GET['id'] : 1);

	

	$query = "SELECT

			     ep_people_program_year.pk_people_program_year

			    ,ep_people_program_year.total_annual

			    ,ep_people_program_year.full_repeat 

			    ,ep_people_program_year.considerate 

			    ,ep_people_program_year.inaccuracy  

			    ,ep_people_program_year.haziness    

			    ,ep_people_program_year.ie          

			    ,ep_people_program_year.final_group 

			    ,ep_program_year.number_year

			FROM

			    ep_people_program_year

			    INNER JOIN ep_program_year ON ( ep_program_year.pk_program_year = ep_people_program_year.fk_program_year )

			WHERE

			    fk_person = " . $user->getLaboratorio() . " 

			    AND need_calcule = false

			    AND fk_pa_det_res_groups = " . pg_escape_string($fk_pa_det_res_groups) . " 

			    AND ep_program_year.is_visible = true

			ORDER BY ep_program_year.number_year";





	$error_code = fc_test_query( $conexao, $query );

	if( $error_code == '' )

	{



		$result = @pg_query($conexao, $query);

		//print pg_last_error($conexao);

		$int = 0;

		while ( $array = @pg_fetch_array($result) ) 

		{

			$int++;

			print '<tr '.( $int%2 == 1 ? 'class="cinza_claro"' : '') .'>';

				print '<td>' . $array['number_year'] . '</td>';

				print '<td>' . $array['total_annual'] . '</td>';

				print '<td>' . $array['full_repeat'] . '</td>';

				print '<td>' . $array['considerate'] . '</td>';

				print '<td>' . number_format($array['inaccuracy'],2, ',', '') . '</td>';

				print '<td>' . number_format($array['haziness'],2, ',', '') . '</td>';

				print '<td>' . number_format($array['ie'],2, ',', '') . '</td>';

				print '<td>' . $array['final_group'] . '</td>';

				print '<td align="center"><a href="/avaliacao/' . $array['number_year'] . '" class="link_pesquisa"></a></td>';

			print '</tr>';

		}

	}else

	{

		print '<tr class="readonly">';

			print '<td colspan="8"><label>'. $error_code .'</label></td>';

		print '</tr>';			

	}

?>