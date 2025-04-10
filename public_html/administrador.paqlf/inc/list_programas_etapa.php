<?php 
    require ('../modal/functions.php');
    require ('../modal/conex_bd.php');
    $conexao = conexao();

    $query_titulo = "SELECT number_year FROM ep_program_year WHERE pk_program_year = " . $_GET['samp'];
	$result_titulo = pg_query( $conexao, $query_titulo );
	$array_titulo = pg_fetch_all($result_titulo);

    $query = "SELECT 
			pk_program_year_steps
			, number_of_year
			, date_initial
			, date_final
			, send_date
			, is_visible
			--,( SELECT true FROM ep_program_year_samp WHERE ep_program_year_samp.fk_program_year_steps = ep_program_year_steps.pk_program_year_steps AND ep_program_year_samp.is_calculed = true ) as is_calculed 
			,(EXISTS ( SELECT true FROM ep_program_year_samp INNER JOIN ep_program_year_avg ON ( fk_program_year_samp = pk_program_year_samp  ) WHERE fk_program_year_steps = ep_program_year_steps.pk_program_year_steps  )) as is_calculed 
			FROM ep_program_year_steps WHERE fk_program_year = " . $_GET['samp'] . " ORDER BY number_of_year ";
	$result = pg_query( $conexao, $query );
?>
	
	<h2 class="titulo">
		ETAPAS DO PROGRAMA 

		<?php print (pg_num_rows($result) < 4 ? '<a href="/programa/etapa/novo/'.$_GET['samp'].'" class="mais"></a>' : ''); ?>
		<a href="/programa" class="voltar"></a>
	</h2>

	<h2 class="sub_titulo">
		<?php print $array_titulo[0]['number_year']; ?>
	</h2>

	<table cellspacing="1" cellpadding="0" border="0" class="list_programas_etapa">	
		<tr class="cabecalho">
			<td><span><b>Etapa</b></span></td>
			<td><span><b>Envio Amostra Referência</b></span></td>
			<td><span><b>Início de Envio de Resultados</b></span></td>
			<td><span><b>Fim de Envio de Resultados</b></span></td>
			<td><span><b>L. Sem Envio</b></span></td>
			<td><span><b>Calcular</b></span></td>
			<td><span><b>Publicar</b></span></td>
			<td><span><b>Editar</b></span></td>
			<td align="center"><span><b>Excluir</b></span></td>
		</tr>

<?php 
	$int = 0;
	while( $array = pg_fetch_array($result) )
	{
		$int++;
		print '<tr ' . ( $int%2 == 1 ? 'class="cinza_claro"' : '') . '>';
			print '<td>' . $array['number_of_year'] . '</td>';
			print '<td>' . mostraData($array['send_date']) . '</td>';
			print '<td>' . mostraData($array['date_initial']) . '</td>';
			print '<td>' . mostraData($array['date_final']) . '</td>';


			print '<td width="100"><a href="/programa/etapa/senvio/' . $array['pk_program_year_steps'] . '" class="link_pesquisa"></a></td>';


			if( $array['is_calculed'] == 't' || $array['is_calculed'] == 'true' )
			{
				$read = 'readonly';	
			}else
			{
				$read = '';	
			}
			print '<td width="100"><a href="javascript:void(0);" data-id="'.$array['pk_program_year_steps'].'" class="calcule ' . $read . '"></a></td>';
			

			print '<td align="center">';
				print '<input type="checkbox" id="ativo_' . $int . '" name="ativo_' . $int . '" '. ($array['is_visible'] == 't' || $array['is_visible'] == 'true' ? 'checked' : '') . ' data-id="'.$array['pk_program_year_steps'].'">';
				print '<label for="ativo_' . $int . '" class="' . ($array['is_visible'] == 't' || $array['is_visible'] == 'true' ? 'checked' : 'check') . '"></label>';
			print '</td>';

			//print '<td>' . $array['is_visible'] . '</td>';

			if( $array['is_calculed'] == 't' || $array['is_calculed'] == 'true' )
			{
				print '<td width="100"><a href="javascript:void(0);" class="edit readonly"></a></td>';		
			}else
			{
				print '<td width="100"><a href="/programa/etapa/alterar/' . $array['pk_program_year_steps'] . '" class="edit"></a></td>';	
			}
			
			print '<td width="100"><a href="javascript:void(0);" data-id="'.$array['pk_program_year_steps'].'" class="excluir"></a></td>';
		print '</tr>';
	}
?>
	</table>