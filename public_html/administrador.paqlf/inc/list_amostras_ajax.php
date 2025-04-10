<?php 

	require ('../modal/functions.php');

	require ('../modal/acessos.php');

	require ('../modal/conex_bd.php');

	$conexao = conexao();

	$pk_laboratorio = $_GET['laboratorio'];

	



	$query_corpo = "SELECT

			     ep_program_year.number_year

			    ,ep_program_year_steps.number_of_year

			    ,ep_program_year_samp.samp_number

			    ,ep_program_year_samp.pk_program_year_samp

			    ,ep_program_year_samp.is_calculed

			    ,ep_people_samp.pk_people_samp

			FROM

			    ep_program_year

			    INNER JOIN ep_program_year_steps ON ( ep_program_year_steps.fk_program_year      = ep_program_year.pk_program_year             )

			    INNER JOIN ep_program_year_samp  ON ( ep_program_year_samp.fk_program_year_steps = ep_program_year_steps.pk_program_year_steps )

			    LEFT JOIN ep_people_samp        ON ( ep_people_samp.fk_program_year_samp        = ep_program_year_samp.pk_program_year_samp  AND ep_people_samp.fk_person = {$pk_laboratorio} )

			WHERE

			        ep_program_year.number_year between " . $_GET['data_inicial'] . " and ". $_GET['data_final'] . 

		"	ORDER BY

			     ep_program_year_samp.samp_number DESC

			     ,ep_program_year.number_year";



	$result_corpo = pg_query($conexao, $query_corpo);	



			if( pg_num_rows($result_corpo) < 1 )

			{

				$html .= '<tr class="readonly">';

					$html .= '<td>Nenhuma amostra encontrada</td>';// rowspan="3"

				$html .= '</tr>';					

			}



			while ( $array_corpo = pg_fetch_array($result_corpo) ) 

			{

				if( $array_corpo['pk_people_samp'] != '')

				{

					//$html .= '<tr class="abrir" data-id="' . $array_corpo['pk_program_year_samp'] .'">';

					$html .=  '<tr class="abrir ' . ( $array_corpo['is_calculed'] == 't' || $array_corpo['is_calculed'] == 'true' ? 'calculed' : 'not_calculed' ) . ' " data-id="' . $array_corpo['pk_program_year_samp'] .'">';

						$html .= '<td>'.$array_corpo['number_of_year'].'</td>';// rowspan="3"

						$html .= '<td>'.$array_corpo['samp_number'].'/'.$array_corpo['number_year'] .'</td>';



						$query_valores = "SELECT    

							             pk_pa_det_res

							            ,ep_fc_get_res_from_samp ( {$array_corpo['pk_people_samp']}, ep_pa_det_res.pk_pa_det_res, ep_pa_det_res.decimals_min_max, ep_fc_get_pk_unity_for_det_res ( {$pk_laboratorio} , pk_pa_det_res ) ) as resultado

							            ,norder

							        FROM

							            ep_pa_det_res

							        WHERE

							            is_enabled = true

							        ORDER BY

							            norder";

						$result_valores = pg_query($conexao, $query_valores);	



						while ( $array_valores = pg_fetch_array($result_valores) ) 

						{

							$html .= '<td>' . $array_valores['resultado'] . '</td>';

						}

					$html .= '</tr>';

				}

			}



	$json = array(

					'error' => '0',

					'html' => $html

					);

			echo json_encode($json);

			exit;

?>