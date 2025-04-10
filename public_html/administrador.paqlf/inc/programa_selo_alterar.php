<?php 

	require('../modal/functions.php');

	require('../modal/conex_bd.php');

	$conexao = conexao();


	$query = "SELECT * FROM ep_seals WHERE pk_seals =" . pg_escape_string($_GET['samp']);

	$result = pg_query($query);

	while ( $array = pg_fetch_array($result) ) 

	{

		//print ( $array['can_imput_results'] == 't' ? 'checked' : '')

?>



		<tr>

			<td width="135"><label class="lab_primeiro">Descrição</label></td>

			<td><input type="text" maxlength="90" name="descricao" value="<?php print $array['description']; ?>"></td>

		</tr>

		<tr>

			<td width="135"><label class="lab_primeiro">Preço</label></td>

			<td><input type="text" onkeyup="k(this);" maxlength="10" name="preco" value="<?php print $array['price']; ?>"></td>

		</tr>

		
			<tr>
				<td width="135"><label class="lab_primeiro">Ativo</label></td>
				<td align="center">
					<input type="checkbox"  <?php print ($array['is_disable'] == 't' || $array['is_disable'] == 'true' ? '' : 'checked') ?> id="ativo" name="ativo" >
					<label for="ativo"  class=" <?php print ($array['is_disable'] == 't' || $array['is_disable'] == 'true' ? 'check' : 'checked') ?>" ></label>
					 

				</td>
			</tr>

		<tr>

			<td colspan="2">

				<input type="hidden" name="samp" value="<?php print $_GET['samp'] ?>">

				<input type="hidden" name="return" value="<?php print $array['fk_program_year']; ?>">

				<a href="/programa/selo/<?php print $array['fk_program_year']; ?>" class="cancelar">CANCELAR</a>

				<button type="button">SALVAR</button>

			</td>

		</tr>



<?php } ?>