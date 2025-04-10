<?php 

	require ('../modal/functions.php');

	//require ('../modal/acessos.php');

	require ('../modal/conex_bd.php');

	$conexao = conexao();



	$query_completa = "SELECT 

					 ep_people.pk_person 

					,ep_people.person 

					,ep_contracts.pk_contracts

					,ep_contracts.fk_foundation

					,ep_contracts.contract_number

					,ep_contracts.date_initial

					,ep_contracts.date_final

					,ep_contracts.inf_add

					,ep_contracts.value_year

					,ep_contracts.is_canceled

				FROM 

					ep_contracts 

					INNER JOIN ep_people ON ( ep_people.pk_person = ep_contracts.fk_person )

				WHERE 

					pk_contracts = " . $pk_contracts;

	$result_completa = pg_query($conexao, $query_completa);	



	$query_foundation = "SELECT * FROM ep_foundation";

	$result_foundation = pg_query($conexao, $query_foundation);	

	while ( $array_completa = pg_fetch_array($result_completa) ) 

	{ 

?>



<form class="alterar_contrato">

	<table border="0">

		<tr>

			<td width="135">

				<label class="lab_primeiro">Laboratório</label>

			</td>

			<td colspan="2">

				<input type="text" name="nome" readonly value="<?php print $array_completa['person']; ?>">

			</td>



			<td>

				<input type="checkbox" id="cancelado" name="cancelado" value="true" <?php print ( $array_completa['is_canceled'] == 't' ? 'checked' : ''); ?>> 

				<label for="cancelado" class="<?php print ( $array_completa['is_canceled'] == 't' ? 'checked' : 'check'); ?>"> Desativar</label>

			</td>

		</tr>

		<tr>

			<td width="135">

				<label class="lab_primeiro">Nº Contrato</label>

			</td>

			<td>

				<input type="text" name="n_contrato" required value="<?php print $array_completa['contract_number']; ?>" maxlength="45">

			</td>



			<td width="135">

				<label class="lab_primeiro">Valor Anual</label>

			</td>

			<td>

				<input type="text" name="valor_anual" required value="<?php print replace('.',',',$array_completa['value_year']); ?>" maxlength="14">

			</td>

		</tr>

		<tr>

			<td width="135">

				<label class="lab_primeiro">Data Inicial</label>

			</td>

			<td>

				<input type="text" name="data_inicial" required class="data_completa" placeholder="00/00/0000" maxlength="10" value="<?php print mostraData($array_completa['date_initial']); ?>">

			</td>



			<td width="135">

				<label class="lab_primeiro">Data Final</label>

			</td>

			<td>

				<input type="text" name="data_final" required class="data_completa" placeholder="00/00/0000" maxlength="10" value="<?php print mostraData($array_completa['date_final']); ?>">

			</td>

		</tr>



		<tr>

			<td>

				<label class="lab_primeiro">Fundação</label>

			</td>

			<td colspan="3">

				<select name="fundacao">

					<?php 

						while ( $array = pg_fetch_array($result_foundation) ) 

						{ 

							print '<option value="' . $array['pk_foundation'] . '" '.( $array_completa['fk_foundation'] == $array['pk_foundation'] ? 'selected' : '').'>' . $array['identification'] . '</option>';

						}

					?>

				</select>

			</td>

		</tr>



		<tr>

			<td width="135" valign="top">

				<label class="lab_primeiro">Observação</label>

			</td>

			<td  colspan="3">

				<textarea name="observacao" maxlength="500"><?php print $array_completa['inf_add']; ?></textarea>

			</td>

		</tr>

		

		<tr>

			<td colspan="7" align="right" style="border:none;">

				<input type="hidden" name="lab_on" class="lab_on" value="<?php print $array_completa['pk_person']; ?> "

				>

				<input type="hidden" name="contrato" value="<?php print $array_completa['pk_contracts']; ?> "

				>

				<a href="/laboratorio/contrato/<?php print $array_completa['pk_person']; ?>" class="cancelar">CANCELAR</a>

				<button type="button" class="salvar">SALVAR</button>

			</td>

		</tr>

	</table>

</form>











<?php 

	}



?>

