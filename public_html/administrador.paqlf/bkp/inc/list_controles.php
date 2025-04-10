<?php 
    require ('../modal/functions.php');
    require ('../modal/conex_bd.php');
    $conexao = conexao();

    $query = "SELECT * FROM ep_samp_control ORDER BY description";

	$result = pg_query( $conexao, $query );
	$int = 0;
	while( $array = pg_fetch_array($result) )
	{
		$int++;
		print '<tr ' . ( $int%2 == 1 ? 'class="cinza_claro"' : '') . '>';
			print '<td>' . $array['description'] . '</td>';
			print '<td>' . mostraData($array['manu_date']) . '</td>';
			print '<td>' . $array['inf_add'] . '</td>';
			print '<td width="100"><a href="/areferencias/uso/' . $array['pk_samp_control'] . '" class="edit"></a></td>';	
			print '<td width="100"><a href="/areferencias/alterar/' . $array['pk_samp_control'] . '" class="edit"></a></td>';
			print '<td><a href="javascript:void(0);" data-id="' . $array['pk_samp_control'] . '" class="excluir"></a></td>';
		print '</tr>';
	}
?>