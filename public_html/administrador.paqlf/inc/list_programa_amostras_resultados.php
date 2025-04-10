<?php 

	include_once ('../modal/functions.php');

	require_once ('../modal/conex_bd.php');

	$conexao = conexao();



	$query = "

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

				    ep_program_year_det_res.fk_program_year = " . $array_titulo_a[0]['pk_program_year'] . "

				AND ep_program_year_det_res.is_enabled = true

			ORDER BY 

			    ep_pa_det_res.norder";



	$result = pg_query($conexao, $query);



	$elemento = array();

	$unidade = array();



	while ( $array = pg_fetch_array($result) ) 

	{

		$elemento[$array['norder']] = '<b>' . $array['report_abbrev'] . '</b>' . $array['report_technic'] . ' </br> ' . $array['unity'];

		//$elemento[$array['norder']] = $array['report_abbrev'];

		//$unidade[$array['norder']] 	= $array['unity'];

	}



	print '<thead>';

		print '<tr class="cabecalho" valign="top">';

			print '<td colspan="2" ><span></br><b>NÚMERO</b></span><p></br>NÚMERO</p></td>';

			//print '<td><span></br><b>AMOSTRA</b></span><p></br>AMOSTRA</p></td>';

			foreach ($elemento as $value) 

			{

				print '<td><span>'. $value . '</span><p>'. $value . '</p></td>';

			}

		print '</tr>';

	print '</thead>';





	$query_corpo = "SELECT

				    ep_program_year_samp.pk_program_year_samp

				    ,ep_people_samp.pk_people_samp

				    ,ep_people.lab_number

				    ,ep_people.pk_person

				    ,ep_program_year_samp.is_calculed

				FROM

				    ep_program_year_samp

				    INNER JOIN ep_people_samp        ON ( ep_people_samp.fk_program_year_samp        = ep_program_year_samp.pk_program_year_samp )

				    INNER JOIN ep_people	     ON ( ep_people.pk_person = ep_people_samp.fk_person )

				WHERE

					ep_program_year_samp.pk_program_year_samp = " . $_GET['samp'] . "

					AND ep_people_samp.not_send = false

					AND ep_people_samp.is_used = true

				ORDER BY

					ep_people.lab_number";



	$result_corpo = pg_query($conexao, $query_corpo);	



	print '<tbody>';

			if( @pg_num_rows($result_corpo) < 1 )

			{

				print '<tr class="readonly">';

					print '<td>Nenhuma amostra encontrada</td>';// rowspan="3"

				print '</tr>';					

			}



			while ( $array_corpo = pg_fetch_array($result_corpo) ) 

			{

				print '<tr class="abrir ' . ( $array_corpo['is_calculed'] == 't' || $array_corpo['is_calculed'] == 'true' ? 'calculed' : 'not_calculed' ) . '" data-id="' . $array_corpo['pk_program_year_samp'] .'" data-rel="'.$array_corpo['pk_person'].'">';

					print '<td  colspan="2" align="center" >'.$array_corpo['lab_number'].'</td>';// rowspan="3"

					//print '<td align="center">'.$array_corpo['samp_number'].'/'.$array_corpo['number_year'] .'</td>';



					$query_valores = "SELECT    

						             pk_pa_det_res

						            ,ep_fc_get_res_from_samp ( {$array_corpo['pk_people_samp']}, ep_pa_det_res.pk_pa_det_res, ep_pa_det_res.decimals_min_max, ep_fc_get_pk_unity_for_det_res ( {$array_corpo['pk_person']} , pk_pa_det_res ) ) as resultado

						            ,norder

						        FROM

						            ep_pa_det_res

						        WHERE

						            is_enabled = true

						        ORDER BY

						            norder";



					if( $array_corpo['pk_people_samp'] == '' )

					{

						for( $for = 0; $for < count( $elemento ); $for++)

						{

							print '<td align="center"> - </td>';

						}

					}else

					{

						$result_valores = pg_query($conexao, $query_valores);	

					

						while ( $array_valores = pg_fetch_array($result_valores) ) 

						{

							print '<td align="center">' . $array_valores['resultado'] . '</td>';

						}

					}

				print '</tr>';

			}

	print '</tbody>';

?>