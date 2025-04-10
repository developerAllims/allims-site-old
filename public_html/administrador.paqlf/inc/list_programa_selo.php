<?php 
    require ('../modal/functions.php');
    require ('../modal/conex_bd.php');
    $conexao = conexao();

    $query_titulo = "SELECT number_year FROM ep_program_year WHERE pk_program_year = " . pg_escape_string($_GET['samp']);
	$result_titulo = pg_query( $conexao, $query_titulo );
	$array_titulo = pg_fetch_all($result_titulo);

    $query = "
    	 SELECT
        	 ep_seals.pk_seals
        	,ep_seals.description
        	,ep_seals.price
        	,ep_seals.is_disable
	    FROM
	        ep_seals
	        INNER JOIN ep_program_year ON ( ep_program_year.pk_program_year = ep_seals.fk_program_year )
	    WHERE
	        fk_program_year  = " . pg_escape_string($_GET['samp']);


	$result = pg_query( $conexao, $query );
?>
	
	<h2 class="titulo">
		SELOS DO PROGRAMA 

		<?php print (pg_num_rows($result) < 4 ? '<a href="/programa/selo/novo/'.$_GET['samp'].'" class="mais"></a>' : ''); ?>
		<a href="/programa" class="voltar"></a>
	</h2>

	<h2 class="sub_titulo">
		<?php print $array_titulo[0]['number_year']; ?>
	</h2>

	<table cellspacing="1" cellpadding="0" border="0" class="list_programa_selo">	
		<tr class="cabecalho">
			<td><span><b>Descrição do Selo</b></span></td>
			<td><span><b>Preço</b></span></td>
			<td><span><b>Ativo</b></span></td>
			<td><span><b>Editar</b></span></td>
			<td align="center"><span><b>Excluir</b></span></td>
		</tr>

<?php 
	$int = 0;
	while( $array = pg_fetch_array($result) )
	{
		$int++;
		print '<tr ' . ( $int%2 == 1 ? 'class="cinza_claro"' : '') . '>';
			print '<td>' . $array['description'] . '</td>';
			print '<td>' . $array['price'] . '</td>';

			print '<td align="center">';
				//print '<input type="checkbox" id="ativo_' . $int . '" name="ativo_' . $int . '" '. ($array['is_disable'] != 't' || $array['is_disable'] != 'true' ? 'checked' : '') . ' data-id="'.$array['pk_program_year_steps'].'">';
				print '<label  class="readonly ' . ($array['is_disable'] == 't' || $array['is_disable'] == 'true' ? 'check' : 'checked') . '"></label>';
			print '</td>';

			//print '<td>' . $array['is_visible'] . '</td>';

			if( $array['is_calculed'] == 't' || $array['is_calculed'] == 'true' )
			{
				print '<td width="100"><a href="javascript:void(0);" class="edit readonly"></a></td>';		
			}else
			{
				print '<td width="100"><a href="/programa/selo/alterar/' . $array['pk_seals'] . '" class="edit"></a></td>';	
			}
			
			print '<td width="100"><a href="javascript:void(0);" data-id="'.$array['pk_seals'].'" class="excluir"></a></td>';
		print '</tr>';
	}
?>
	</table>