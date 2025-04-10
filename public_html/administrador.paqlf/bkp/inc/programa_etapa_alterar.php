<?php 
    require_once ('../modal/functions.php');
    require_once ('../modal/conex_bd.php');
    $conexao = conexao();

    $query = "SELECT * FROM ep_program_year_steps WHERE pk_program_year_steps = " . $_GET['samp'];
	$result = pg_query( $conexao, $query );
	$array = pg_fetch_all($result);
?>

<table cellspacing="1" cellpadding="0" border="0">	
	<tr height="40">
		<td width="150"><label class="lab_primeiro">Data de Envio da Amostra</label></td>
		<td><input type="text" maxlength="10" name="data_envio" value="<?php print mostraData($array[0]['send_date']) ?>" class="data_completa"></td>
	</tr>
	<tr height="40">
		<td width="135"><label class="lab_primeiro">Data Inicial de Envio dos Resultados</label></td>
		<td><input type="text" maxlength="10" name="data_inicial" value="<?php print mostraData($array[0]['date_initial']) ?>" class="data_completa"></td>
	</tr>
	<tr height="40">
		<td width="135"><label class="lab_primeiro">Data Final de Envio dos Resultados</label></td>
		<td><input type="text" maxlength="10" name="data_final" value="<?php print mostraData($array[0]['date_final']) ?>" class="data_completa"></td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="hidden" name="programa" class="programa" value="<?php print $_GET['samp']; ?>">
			<input type="hidden" name="voltar" class="voltar" value="<?php print $array[0]['fk_program_year']; ?>">
			<a href="/programa/etapa/<?php print $array[0]['fk_program_year']; ?>" class="cancelar">CANCELAR</a>
			<button type="button">SALVAR</button>
		</td>
	</tr>
</table>