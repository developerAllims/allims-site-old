<?php 

	require ('../modal/functions.php');

	//require ('../modal/acessos.php');

	require ('../modal/conex_bd.php');

	$conexao = conexao();



	$query_etapa = "SELECT * FROM ep_program_year_steps WHERE fk_program_year = " . $_GET['samp'] ;

	$result_etapa = pg_query($conexao, $query_etapa);	



	if( pg_num_rows($result_etapa) < 1 )

	{

		print '<script>$(\'body\').append(\'<div class="modal"><div class="box_alert"><p></p></div></div>\');</script>';

		print '<script>alerta("Sem Etapas cadastradas para este Ano");</script>';

		print '<script>setTimeout(function(){location.href="/programa/amostra/' . $_GET['samp'] . '"},3000)</script>';

	}



	$query_amostra = "SELECT max(samp_number) FROM ep_program_year_samp";

	$result_amostra = pg_query($conexao, $query_amostra);	

	$array_amostra = pg_fetch_all($result_amostra);



	$query_control = "SELECT * FROM ep_samp_control";

	$result_control = pg_query($conexao, $query_control);	



	if( pg_num_rows($result_control) < 1 )

	{

		print '<script>$(\'body\').append(\'<div class="modal"><div class="box_alert"><p></p></div></div>\');</script>';

		print '<script>alerta("Sem Amostras de Referências cadastradas");</script>';

		print '<script>setTimeout(function(){location.href="/programa/amostra/' . $_GET['samp'] . '"},3000)</script>';

	}

?>



<tr height="40">

	<td width="135"><label class="lab_primeiro">Etapa</label></td>

	<td>

		<select name="etapa">

			<?php 

				while ( $array_etapa = pg_fetch_array($result_etapa) ) 

				{ 

					print '<option value="' . $array_etapa['pk_program_year_steps'] . '">' . $array_etapa['number_of_year'] . '</option>';

				}

			?>

		</select>					

	</td>

</tr>

<tr height="40">

	<td width="135"><label class="lab_primeiro">Nº Amostra</label></td>

	<td><input type="text" maxlength="10" name="amostra" value="<?php print ($array_amostra[0]['max']+1); ?>"></td>

</tr>

<tr height="40">

	<td width="135"><label class="lab_primeiro">A. de Referência</label></td>

	<td>

		<select name="controle">

			<?php 

				while ( $array_control = pg_fetch_array($result_control) ) 

				{ 

					print '<option value="' . $array_control['pk_samp_control'] . '">' . $array_control['description'] . '</option>';

				}

			?>

		</select>					

	</td>

</tr>