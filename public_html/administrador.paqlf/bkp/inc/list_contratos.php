<?php 
	include_once ('../modal/functions.php');
	require_once ('../modal/conex_bd.php');
	$conexao = conexao();

	$insert_pk = ($pk_person != '' ? ' pk_person = ' . $pk_person : ' CAST(NOW() as DATE) >= date_initial AND CAST(NOW() as DATE) <= date_final AND is_canceled = false ' );

	$query = "SELECT 
				  ep_contracts.pk_contracts
				  , ep_contracts.contract_number
				  , ep_contracts.date_initial
				  , ep_contracts.date_final
				  , ep_contracts.is_canceled
				  , ep_people.person  
				FROM 
				  ep_contracts 
				INNER JOIN ep_people ON ( ep_people.pk_person = ep_contracts.fk_person) 
				WHERE 
				  " . $insert_pk . "  ORDER BY person, date_initial ";

	$result = pg_query($query);
	$int = 0;
	while ( $array = pg_fetch_array($result) ) 
	{
		$int++;
		print '<tr '.( $int%2 != 0 ? 'class="cinza_claro"' : '') .'>';
			print '<td>' . $array['person'] . '</td>';
			print '<td>' . $array['contract_number'] . '</td>';
			print '<td>' . mostraData($array['date_initial']) . '</td>';
			print '<td>' . mostraData($array['date_final']) . '</td>';

			if ($pk_person != '' )
			{
				print '<td align="center" width="100"><label for="cancelado" class="' .( $array['is_canceled'] == 't' ? 'checked' : 'check') .  ' readonly"></label></td>';
				print '<td><a href="/laboratorio/contrato/alterar/' .  $array['pk_contracts']. '" class="edit"></a></td>' ;
				print '<td><a href="javascript:void(0);" data-id="' . $array['pk_contracts'] . '" class="excluir"></a></td>';
			}
		print '</tr>';
	}
?>