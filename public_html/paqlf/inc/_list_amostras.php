<?php 
	include ('../modal/functions.php');
	require ('../modal/conex_bd.php');
	$conexao = conexao();

	$query = "
			SELECT
		     sub_sel.*
		    ,ep_pa_unity.abbrev as unity
		    FROM (
		        SELECT    
		             pk_pa_det_res
		            ,report_abbrev
		            ,report_technic
		            ,ep_fc_get_pk_unity_for_det_res ( {$user->getLaboratorio()}, pk_pa_det_res ) as fk_pa_unity
		            ,norder
		        FROM
		            ep_pa_det_res
		        WHERE
		            is_enabled = true
		    ) as sub_sel
		    INNER JOIN ep_pa_unity ON ( ep_pa_unity.pk_pa_unity = sub_sel.fk_pa_unity )
		ORDER BY
		    norder";

	$query_corpo = "SELECT
			     ep_program_year.number_year
			    ,ep_program_year_steps.number_of_year
			    ,ep_program_year_samp.samp_number
			    ,ep_program_year_samp.pk_program_year_samp
			    ,ep_program_year_samp.is_calculed
			    ,ep_people_samp.pk_people_samp
			    ,ep_people_samp.not_send
			FROM
			    ep_program_year
			    INNER JOIN ep_program_year_steps ON ( ep_program_year_steps.fk_program_year      = ep_program_year.pk_program_year             )
			    INNER JOIN ep_program_year_samp  ON ( ep_program_year_samp.fk_program_year_steps = ep_program_year_steps.pk_program_year_steps )
			    LEFT JOIN ep_people_samp        ON ( ep_people_samp.fk_program_year_samp        = ep_program_year_samp.pk_program_year_samp  AND ep_people_samp.fk_person = {$user->getLaboratorio()} )
			WHERE
			        ep_program_year.number_year between " . (date('Y')-1) . " and ". date('Y') . 
		"	ORDER BY
				ep_program_year_samp.samp_number DESC
			     ,ep_program_year.number_year
			    -- ep_program_year.number_year
			    --,ep_program_year_samp.samp_number";


	$error_code = fc_test_query( $conexao, $query );
	$error_code_corpo = fc_test_query( $conexao, $query_corpo );

	if( $error_code == '' && $error_code_corpo == '' )
	{

		$result = pg_query($conexao, $query);

		$elemento = array();
		$technic = array();
		$unidade = array();

		while ( $array = pg_fetch_array($result) ) 
		{
			$elemento[$array['norder']] = '<b>' . $array['report_abbrev'] . '</b> </br> ' . $array['report_technic'] . ' </br> ' . $array['unity'];
			/*$elemento[$array['norder']] = $array['report_abbrev'];
			$technic[$array['norder']] = $array['report_technic'];
			$unidade[$array['norder']] 	= $array['unity'];*/
		}

		print '<thead>';
			print '<tr class="cabecalho" valign="top">';
				print '<td><span></br><b>REMESA</b></span><p>REMESA</p></td>';
				print '<td><span></br><b>AMOSTRA</b></span><p>AMOSTRA</p></td>';
				foreach ($elemento as $value) 
				{
					print '<td><span>'. $value . '</span><p>'. $value . '</p></td>';
				}

				print '<td><span></br><b>STATUS</b></span><p>STATUS</p></td>';
			print '</tr>';
		print '</thead>';


	

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
				print '<tr class="abrir ' . ( $array_corpo['is_calculed'] == 't' || $array_corpo['is_calculed'] == 'true' ? 'calculed' : 'not_calculed' ) . ' " data-id="' . $array_corpo['pk_program_year_samp'] .'">';
					print '<td>'.$array_corpo['number_of_year'].'</td>';// rowspan="3"
					print '<td>'.$array_corpo['samp_number'].'/'.$array_corpo['number_year'] .'</td>';

					
					if( $array_corpo['pk_people_samp'] == '' )
					{
						for( $for = 0; $for < count( $elemento ); $for++)
						{
							print '<td> - </td>';
						}
					}else
					{
						$query_valores = "SELECT    
						             pk_pa_det_res
						            ,ep_fc_get_res_from_samp ( {$array_corpo['pk_people_samp']}, ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( {$user->getLaboratorio()} , pk_pa_det_res ) ) as resultado
						            ,norder
						        FROM
						            ep_pa_det_res
						        WHERE
						            is_enabled = true
						        ORDER BY
						            norder";

						$error_valores = fc_test_query( $conexao, $query_valores );	

						if( $error_valores == '')
						{
							$result_valores = pg_query($conexao, $query_valores);	
					
							while ( $array_valores = pg_fetch_array($result_valores) ) 
							{
								print '<td>' . $array_valores['resultado'] . '</td>';
							}
						}else
						{
							print '<td colspan="' . count( $elemento ) . '">'. $error_valores .'</td>';
						}
					}

					if( $array_corpo['not_send'] == 'f' || $array_corpo['not_send'] == 'false' )
					{
						print '<td>Participante</td>';
					}else if( $array_corpo['not_send'] == 't' || $array_corpo['not_send'] == 'true' )
					{
						print '<td>Não Participante</td>';
					}else
					{
						print '<td>Não Preenchido</td>';
					}

				print '</tr>';
			}
	

		print '</tbody>';

	}else
	{
			print '<tr class="readonly" colspan="2">';
				if( $error_code != '' )
				{
					print '<td>'. $error_code .'</td>';
				}else
				{
					print '<td>'. $error_code_corpo .'</td>';
				}
				
			print '</tr>';		
	}
?>