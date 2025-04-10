<?php 
	include '../model/conexao_bd.php';
	$conexao = conexao();
	

	$query_cultures = "SELECT * FROM sf_cultures WHERE is_enabled = true AND project = 1 AND fk_technology = " . $_GET['fk_technology'] . " ORDER BY identification";

	$result_cultures = pg_query($conexao, $query_cultures);
	$html = '<div class="inline">';

	$html .= '<p>Cultura</p>';
			$html .= '<select name="cultures">';


	$html .= '<option hidden="hidden">Selecione uma Cultura</option>';
	while ( $array = pg_fetch_array($result_cultures) ) 
	{
		$html .= '<option value="' . $array['id'] . '">' . utf8_decode($array['identification']) . '</option>';
	}
		$html .= '</select>';

		$html .= '</div>';

	$json = array(
					'html' => utf8_encode($html)
				);
			echo json_encode($json);
			exit;	
?>