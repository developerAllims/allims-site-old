<?php 

	require ('../modal/functions.php');

	//require ('../modal/acessos.php');

	require ('../modal/conex_bd.php');

	$conexao = conexao();



	$query = "SELECT

				person

			  FROM 

			  	ep_people

			  WHERE 

			   	pk_person = " . $pk_person ;



	$result = pg_query($conexao, $query);	

	$array_nome = pg_fetch_all($result);



	$query_foundation = "SELECT * FROM ep_foundation";

	$result_foundation = pg_query($conexao, $query_foundation);	

?>

<form class="novo_contrato">

	<table border="0">

		<tr>

			<td width="135">

				<label class="lab_primeiro">Laboratório</label>

			</td>

			<td colspan="3">

				<input type="text" name="nome" readonly value="<?php print $array_nome[0]['person']; ?>">

			</td>

		</tr>

		<tr>

			<td width="135">

				<label class="lab_primeiro">Nº Contrato</label>

			</td>

			<td>

				<input type="text" name="n_contrato" required maxlength="45">

			</td>



			<td width="135">

				<label class="lab_primeiro">Valor Anual</label>

			</td>

			<td>

				<input type="text" name="valor_anual" required maxlength="14">

			</td>

		</tr>

		<tr>

			<td width="135">

				<label class="lab_primeiro">Data Inicial</label>

			</td>

			<td>

				<input type="text" name="data_inicial" required class="data_completa" placeholder="00/00/0000" maxlength="10">

			</td>



			<td width="135">

				<label class="lab_primeiro">Data Final</label>

			</td>

			<td>

				<input type="text" name="data_final" onpaste="return false;" required class="data_completa" placeholder="00/00/0000" maxlength="10">

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

							print '<option value="' . $array['pk_foundation'] . '">' . $array['identification'] . '</option>';

						}

					?>

				</select>

				<!--<input type="text" name="email" required>-->

			</td>

		</tr>



		<tr>

			<td width="135" valign="top">

				<label class="lab_primeiro">Observação</label>

			</td>

			<td  colspan="3">

				<textarea name="observacao" maxlength="500"></textarea>

			</td>

		</tr>

		

		<tr>

			<td colspan="7" align="right" style="border:none;">

				<input type="hidden" name="lab_on" class="lab_on" value="<?php print $_GET['samp']; ?> "

				>

				<a href="/laboratorio/contrato/<?php print $_GET['samp']; ?>" class="cancelar">CANCELAR</a>

				<button type="button" class="salvar">SALVAR</button>

			</td>

		</tr>

	</table>

</form>