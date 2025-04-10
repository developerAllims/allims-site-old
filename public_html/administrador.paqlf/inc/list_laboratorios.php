<?php 
	include ('../modal/functions.php');
	require ('../modal/conex_bd.php');
	$conexao = conexao();

	$order = ( $_GET['order'] != '' ? $_GET['order'] . ',' : '');

	if( isset($_GET['status']) )
	{
		if( $_GET['status'] == 1 )
		{
			$enabled = ' and ep_fc_people_program_active(ep_people.pk_person) = true ';
		}else if( $_GET['status'] == 0 )
		{
			$enabled = ' and ep_fc_people_program_active(ep_people.pk_person) = false ';
		}
	}


	$query = "SELECT
			   ep_people.pk_person 
			   , ep_people.lab_number
			   , ep_people.person
			   , ep_cities.city
			   , ep_states.state
			   , ep_fc_people_program_active(ep_people.pk_person) as active
			FROM 
			   ep_people
			   LEFT JOIN ep_cities ON ( ep_cities.pk_city = ep_people.fk_city )
			   LEFT JOIN ep_states ON ( ep_states.pk_state = ep_cities.fk_state )
			WHERE 
				ep_people.pk_person > 0
			" . $enabled . "
			ORDER BY
			   " . $order ."ep_people.person ASC";

	$result = pg_query($conexao, $query);

	$int = 0;
	while ( $array = pg_fetch_array($result) ) 
	{

		print '<tr ' . ( $int%2 == 0 ? 'class="cinza_claro"' : '') . '>';
			print '<td width="50" align="center" class="td_check_all">
						<input type="checkbox" id="check_'. $array['pk_person'] .'" name="impressoes" value="'. $array['pk_person'] .'"> 
						<label for="check_'. $array['pk_person'] .'" class="check"></label>
					</td>';
			print '<td align="center">' . $array['lab_number'] . '</td>';
			print '<td>' . $array['person'] . '</td>';
			print '<td>' . $array['city'] . '</td>';
			print '<td>' . $array['state'] . '</td>';


			print 	'<td align="center">
						<input type="checkbox" id="amostra_'.$int.'" name="amostra" value="1" '. ( $array['active'] == 't' ? 'checked' : '') . '> 
						<label for="amostra_'.$int.'" class="readonly '. ( $array['active'] == 't' ? 'checked' : 'check') . '"></label>
					</td>';

			print '<td><a href="/laboratorio/alterar/' . $array['pk_person'] . '" class="edit"></a></td>';
			print '<td><a href="/laboratorio/usuario/' . $array['pk_person'] . '" class="edit"></a></td>';
			print '<td><a href="/laboratorio/contrato/' . $array['pk_person'] . '" class="edit"></a></td>';
			print '<td><a href="/laboratorio/contato/' . $array['pk_person'] . '" class="edit"></a></td>';

			print '<td><a href="/laboratorio/selo/' . $array['pk_person'] . '" class="edit"></a></td>';
			
			print '<td><a href="/laboratorio/amostra/' . $array['pk_person'] . '" class="link_pesquisa"></a></td>';
			print '<td><a href="/laboratorio/avaliacao/' . $array['pk_person'] . '" class="link_pesquisa"></a></td>';
			print '<td><a href="javascript:void(0);" data-id="' . $array['pk_person'] . '" class="excluir"></a></td>';
		print '</tr>';
		$int++;
	}
?>
