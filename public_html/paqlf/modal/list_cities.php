<?php 
	include ('functions.php');
	require ('conex_bd.php');
	$conexao = conexao();

	$cidade = pg_escape_string(strtolower($_GET['cidade']));

	$query = "select 
				ep_cities.city,
				ep_cities.pk_city,
				ep_states.abbreviature, 
				ep_states.pk_state
			 FROM ep_cities 
			 INNER JOIN ep_states ON ( ep_cities.fk_state = ep_states.pk_state ) 
			 	WHERE 
			 		ep_fc_remove_acentuation(lower(ep_cities.city)) like '%". cleanString( $cidade ) ."%' ORDER BY ep_cities.city";

	$result = pg_query($query);
	while ( $array = pg_fetch_array($result) ) 
	{
		$dados .= '<tr>';
			$dados .= '<td><a href="javascript:void(0)" data-city="'.$array['city'].'" data-id-city="'.$array['pk_city'].'" data-state="'.$array['abbreviature'].'" data-id-state="'.$array['pk_state'].'" >'. $array['city'] . ' - ' . $array['abbreviature'] .'</a></td>';
		$dados .= '</tr>';
	}


	$json = array(
					'error' => $error,
					'dados' => $dados,
					'acao'		=> 1
					);
			echo json_encode($json);
			exit;



?>
