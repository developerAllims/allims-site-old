<?php 

	require ('../modal/functions.php');

	//require ('../modal/acessos.php');

	require ('../modal/conex_bd.php');

	$conexao = conexao();



	$query = "

				SELECT 

				   --*,

				    ep_program_year_samp.pk_program_year_samp

				   ,ep_program_year_samp.fk_program_year_steps

				   ,ep_program_year_samp.samp_number

				   ,ep_program_year_samp.fk_samp_control

				   ,ep_program_year_steps.fk_program_year

				FROM 

				   ep_program_year_samp 

				   INNER JOIN ep_program_year_steps ON ( ep_program_year_steps.pk_program_year_steps = ep_program_year_samp.fk_program_year_steps )

				WHERE 

				   pk_program_year_samp = " . $_GET['samp'] ;



	$result = pg_query($conexao, $query);	

	$array = pg_fetch_all($result);



	$query_etapa = "SELECT * FROM ep_program_year_steps WHERE fk_program_year = " . $array[0]['fk_program_year'] ;

	$result_etapa = pg_query($conexao, $query_etapa);	



	$query_control = "SELECT * FROM ep_samp_control";

	$result_control = pg_query($conexao, $query_control);	

?>



<tr height="40">

	<td width="135"><label class="lab_primeiro">Etapa</label></td>

	<td>

		<select name="etapa">

			<?php 

				while ( $array_etapa = pg_fetch_array($result_etapa) ) 

				{ 

					print '<option value="' . $array_etapa['pk_program_year_steps'] . '" '. ( $array[0]['fk_program_year_steps'] == $array_etapa['pk_program_year_steps'] ? 'SELECTED' : ''  ) .'>' . $array_etapa['number_of_year'] . '</option>';

				}

			?>

		</select>					

	</td>

</tr>

<tr height="40">

	<td width="135"><label class="lab_primeiro">Nº Amostra</label></td>

	<td><input type="text" maxlength="10" name="amostra" value="<?php print $array[0]['samp_number']; ?>"></td>

</tr>

<tr height="40">

	<td width="135"><label class="lab_primeiro">A. de Referência</label></td>

	<td>

		<select name="controle">

			<?php 

				while ( $array_control = pg_fetch_array($result_control) ) 

				{ 

					print '<option value="' . $array_control['pk_samp_control'] . '" '. ( $array[0]['fk_samp_control'] == $array_control['pk_samp_control'] ? 'SELECTED' : ''  ) .'>' . $array_control['description'] . '</option>';

				}

			?>

		</select>					

	</td>

</tr>



<tr>

	<td colspan="2">

		<input type="hidden" name="programa" class="programa" value="<?php print $array[0]['pk_program_year_samp']; ?>">

		<input type="hidden" name="voltar" class="voltar" value="<?php print $array[0]['fk_program_year']; ?>">

		<a href="/programa/amostra/<?php print $array[0]['fk_program_year']; ?>" class="cancelar">CANCELAR</a>

		<button type="button">SALVAR</button>

	</td>

</tr>