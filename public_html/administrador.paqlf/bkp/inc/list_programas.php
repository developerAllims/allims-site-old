<?php 
    require ('../modal/functions.php');
    require ('../modal/conex_bd.php');
    $conexao = conexao();

    $query = "SELECT * FROM ep_program_year";

	$result = pg_query( $conexao, $query );
	$int = 0;
	while( $array = pg_fetch_array($result) )
	{
		$int++;
		print '<tr ' . ( $int%2 == 1 ? 'class="cinza_claro"' : '') . '>';
			print '<td>' . $array['number_year'] . '</td>';


			if( $array['is_calculed'] == 't' || $array['is_calculed'] == 'true' )
			{
				$read = 'readonly';	
			}else
			{
				$read = '';	
			}


			print '<td width="100"><a href="javascript:void(0);" data-id="'.$array['pk_program_year'].'" class="calcule ' . $read . '"></a></td>';


			print '<td align="center" width="100">';
				print '<input type="checkbox" id="ativo_' . $int . '" name="ativo_' . $int . '" '. ($array['is_visible'] == 't' || $array['is_visible'] == 'true' ? 'checked' : '') . ' data-id="'.$array['pk_program_year'].'">';
				print '<label for="ativo_' . $int . '" class="' . ($array['is_visible'] == 't' || $array['is_visible'] == 'true' ? 'checked' : 'check') . '"></label>';
			print '</td>';

		
			print '<td width="100"><a href="/programa/etapa/' . $array['pk_program_year'] . '" class="edit"></a></td>';
			print '<td width="100"><a href="/programa/amostra/' . $array['pk_program_year'] . '" class="edit"></a></td>';
			print '<td width="100"><a href="javascript:void(0);" data-id="'.$array['pk_program_year'].'" class="excluir"></a></td>';
		print '</tr>';
	}
?>