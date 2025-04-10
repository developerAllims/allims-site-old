<?php 
    require_once ('../modal/functions.php');
    require_once ('../modal/conex_bd.php');
    $conexao = conexao();

    $query = "SELECT 
    				ep_program_year_samp.pk_program_year_samp
				   ,ep_program_year_steps.number_of_year
				   ,ep_program_year_samp.samp_number
				   ,ep_samp_control.description  
				   ,is_calculed 
				FROM
				   ep_program_year_samp
				   INNER JOIN ep_program_year_steps ON ( ep_program_year_steps.pk_program_year_steps = ep_program_year_samp.fk_program_year_steps )
				   LEFT JOIN ep_samp_control ON ( ep_samp_control.pk_samp_control = ep_program_year_samp.fk_samp_control )
				WHERE 
				   ep_program_year_steps.fk_program_year = {$_GET['samp']}
				ORDER BY 
				  ep_program_year_steps.number_of_year, ep_program_year_samp.samp_number";

	$result = pg_query( $conexao, $query );
	$int = 0;
	while( $array = pg_fetch_array($result) )
	{
		$int++;
		print '<tr ' . ( $int%2 == 1 ? 'class="cinza_claro"' : '') . '>';
			print '<td class="td_check_all">';
				print '<input type="checkbox" id="n_' . $array['pk_program_year_samp'] . '" class="check_" name="n_' . $array['pk_program_year_samp'] . '" value="' . $array['pk_program_year_samp'] . '">';
				print '<label for="n_' . $array['pk_program_year_samp'] . '" class="checked" style="background-image: url(&quot;/images/ico_check_off.png&quot;);"></label>';
			print '</td>';
			//print '<td><input type="checkbox" name="vehicle1" value="' . $array['pk_program_year_samp'] . '" /></td>';
			print '<td>' . $array['number_of_year'] . '</td>';
			print '<td>' . $array['samp_number'] . '</td>';
			print '<td>' . $array['description'] . '</td>';

			print '<td width="100"><a href="/programa/amostra/resultados/' . $array['pk_program_year_samp'] . '" class="link_pesquisa"></a></td>';

			if( $array['is_calculed'] == 't' || $array['is_calculed'] == 'true' )
			{
				print '<td width="100"><a href="javascript:void(0);" class="edit readonly"></a></td>';		
			}else
			{
				print '<td width="100"><a href="/programa/amostra/alterar/' . $array['pk_program_year_samp'] . '" class="edit"></a></td>';
			}
			print '<td width="100"><a href="javascript:void(0);" data-id="'.$array['pk_program_year_samp'].'" class="excluir"></a></td>';
		print '</tr>';
	}
?>