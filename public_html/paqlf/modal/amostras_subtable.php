<?php 
	require('functions.php'); 
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();
	$year_samp = pg_escape_string($_GET['samp']);
	$html = '';

	for( $int = 1; $int <= 3; $int++)
	{
		$html .= '<tr class="'.( $int%2==0?'cinza':'cinza_claro').' readyonly sub_item"><td rowspan="5">'.$int.'ª</td><td class="align_left">MED</td>';
		$query = "SELECT    
				     pk_pa_det_res
				    ,(ep_fc_get_avgs_from_samp ( $year_samp, ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( {$user->getLaboratorio()}, pk_pa_det_res ) )).value_".$int."_avg as n_avg
				    ,norder
				FROM
				    ep_pa_det_res
				WHERE
				    is_enabled = true
				ORDER BY
				    norder";
		//print $query;
	    $result = @pg_query($conexao, $query);
	    while ( $array = @pg_fetch_array($result) ) 
		{
			$html .= '<td align="center">' . ($array['n_avg'] == null ? '-' : replace('.',',',$array['n_avg'])) . '</td>';
		}
		$html .= '<td align="center">-</td>';
		$html .= '</tr>';
	
	
		$html .= '<tr class="'.( $int%2==0?'cinza':'cinza_claro').' readyonly sub_item"><td>S</td>';
		$query = "SELECT    
				     pk_pa_det_res
				    ,(ep_fc_get_avgs_from_samp ( $year_samp, ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( {$user->getLaboratorio()}, pk_pa_det_res ) )).value_".$int."_s as n_s
				    ,norder
				FROM
				    ep_pa_det_res
				WHERE
				    is_enabled = true
				ORDER BY
				    norder";
		//print $query;
	    $result = @pg_query($conexao, $query);
	    while ( $array = @pg_fetch_array($result) ) 
		{
			$html .= '<td align="center">' . ($array['n_s'] == null ? '-' : replace('.',',',$array['n_s'])) . '</td>';
		}
		$html .= '<td align="center">-</td>';
		$html .= '</tr>';
	
	
		$html .= '<tr class="'.( $int%2==0?'cinza':'cinza_claro').' readyonly sub_item"><td>CV%</td>';
		$query = "SELECT    
				     pk_pa_det_res
				    ,(ep_fc_get_avgs_from_samp ( $year_samp, ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( {$user->getLaboratorio()}, pk_pa_det_res ) )).value_".$int."_cv as n_cv
				    ,norder
				FROM
				    ep_pa_det_res
				WHERE
				    is_enabled = true
				ORDER BY
				    norder";
		//print $query;
	    $result = @pg_query($conexao, $query);
	    while ( $array = @pg_fetch_array($result) ) 
		{
			$html .= '<td align="center">' . ($array['n_cv'] == null ? '-' : replace('.',',',$array['n_cv'])) . '</td>';
		}
		$html .= '<td align="center">-</td>';
		$html .= '</tr>';
	
	
		$html .= '<tr class="'.( $int%2==0?'cinza':'cinza_claro').' readyonly sub_item"><td>MIN</td>';
		$query = "SELECT    
				     pk_pa_det_res
				    ,(ep_fc_get_avgs_from_samp ( $year_samp, ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( {$user->getLaboratorio()}, pk_pa_det_res ) )).value_".$int."_min as n_min
				    ,norder
				FROM
				    ep_pa_det_res
				WHERE
				    is_enabled = true
				ORDER BY
				    norder";
		//print $query;
	    $result = @pg_query($conexao, $query);
	    while ( $array = @pg_fetch_array($result) ) 
		{
			$html .= '<td align="center">' . ($array['n_min'] == null ? '-' : replace('.',',',$array['n_min'])) . '</td>';
		}
		$html .= '<td align="center">-</td>';
		$html .= '</tr>';
	
	
		$html .= '<tr class="'.( $int%2==0?'cinza':'cinza_claro').' readyonly sub_item"><td>MAX</td>';
		$query = "SELECT    
				     pk_pa_det_res
				    ,(ep_fc_get_avgs_from_samp ( $year_samp, ep_pa_det_res.pk_pa_det_res, ep_fc_get_pk_unity_for_det_res ( {$user->getLaboratorio()}, pk_pa_det_res ) )).value_".$int."_max as n_max
				    ,norder
				FROM
				    ep_pa_det_res
				WHERE
				    is_enabled = true
				ORDER BY
				    norder";
		//print $query;
	    $result = @pg_query($conexao, $query);
	    while ( $array = @pg_fetch_array($result) ) 
		{
			$html .= '<td align="center">' . ($array['n_max'] == null ? '-' : replace('.',',',$array['n_max'])) . '</td>';
		}

		$html .= '<td align="center">-</td>';
		$html .= '</tr>';
	}
	

	$last_error = @pg_last_error($conexao);
	if( $last_error != '' )
	{
		$html = '<tr><td></td></tr>';
	}
	$var_erro = @explode('CONTEXT', $last_error);

	$json = array(
					'error' => $error,
					'frase' => $var_erro[0],
					'html' => $html
					);
				echo json_encode($json);
				exit;	
?>