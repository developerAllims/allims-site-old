<?php 

	require('../modal/functions.php');

	require('../modal/conex_bd.php');

	$conexao = conexao();



	$query = "SELECT * FROM ep_samp_control WHERE pk_samp_control =" . $_GET['samp'];

	$result = pg_query($query);

	while ( $array = pg_fetch_array($result) ) 

	{

		//print ( $array['can_imput_results'] == 't' ? 'checked' : '')

?>



		<tr>

			<td width="135"><label class="lab_primeiro">Amostra de Referência</label></td>

			<td><input type="text" maxlength="90" name="controle" value="<?php print $array['description']; ?>"></td>

		</tr>

		<tr>

			<td width="135"><label class="lab_primeiro">Produzido em</label></td>

			<td><input type="text" maxlength="10" name="criacao" class="data_completa" value="<?php print mostraData($array['manu_date']); ?>"></td>

		</tr>

		<tr>

			<td width="135" valign="top"><label class="lab_primeiro">Informações Adicionais</label></td>

			<td><textarea name="informacoes"><?php print $array['inf_add']; ?></textarea></td>

		</tr>

		<tr>

			<td colspan="2">

				<input type="hidden" name="programa" value="<?php print $_GET['samp'] ?>">

				<a href="/areferencias" class="cancelar">CANCELAR</a>

				<button type="button">SALVAR</button>

			</td>

		</tr>



<?php } ?>