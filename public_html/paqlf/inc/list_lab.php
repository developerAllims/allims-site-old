<?php 
	include ('../modal/functions.php');
	require('../modal/conex_bd.php');
	$conexao = conexao();

	$query = "SELECT * FROM ep_people LEFT JOIN ep_cities ON ( ep_people.fk_city = ep_cities.pk_city ) LEFT JOIN ep_states ON ( ep_cities.fk_state = ep_states.pk_state ) WHERE ep_people.pk_person =" . $user->getLaboratorio();


	$error_code = fc_test_query( $conexao, $query );

	if( $error_code == '' )
	{

		$result = pg_query($query);
		$int = 0;
		while ( $array = pg_fetch_array($result) ) 
		{
		//print ( $array['can_imput_results'] == 't' ? 'checked' : '')
?>


	<tr>
		<td colspan="2">
			<label class="lab_primeiro">Razão Social</label>
			<input type="text" name="razao" value="<?php print $array['person']; ?>" maxlength="80"> 

			<label class="lab_lab">Código do Laboratório</label>
			<input type="text" name="cod" value="<?php print $array['lab_number']; ?>" readonly>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label class="lab_primeiro">Nome Fantasia</label>
				<input type="text" name="fantasia" value="<?php print $array['fantasy_name']; ?>" maxlength="80">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label class="lab_primeiro">CNPJ</label>
				<input type="text" name="cnpj" value="<?php print $array['insc_juridic']; ?>" maxlength="20">
		</td>
	</tr>
	<tr>
		<td>
			<label class="lab_primeiro">Inscrição Estadual</label>
			<input type="text" name="insc_estadual" value="<?php print $array['insc_state']; ?>" maxlength="20">
		</td>
		<td>
			<label class="lab_im">Instrição Municipal</label>
			<input type="text" name="insc_municipal" value="<?php print $array['insc_city']; ?>" maxlength="20">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label class="lab_primeiro">Endereço</label>
			<input type="text" name="endereco" value="<?php print $array['address']; ?>" maxlength="130">

			<label class="lab_cep">Nº</label>
			<input type="text" name="endereco_numero" value="<?php print $array['address_number']; ?>" maxlength="5">
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<label class="lab_primeiro">Complemento</label>
				<input type="text" name="complemento" value="<?php print $array['complement']; ?>" maxlength="25">
		</td>
	</tr>
	<tr>
		<td>
			<label class="lab_primeiro">Cidade</label>
			<input type="text" name="cidade" value="<?php print $array['city']; ?>" autocomplete="off" maxlength="35">
			<input type="hidden" name="city" value="<?php print $array['pk_city']; ?>">
			<table class="nome_cidades">

			</table>
		</td>
		<td>
			<label class="lab_med">Estado</label>
			<input type="text" name="estado" value="<?php print $array['abbreviature']; ?>" maxlength="2">
			<input type="hidden" name="state" value="<?php print $array['pk_state']; ?>">

			<label class="lab_cep">CEP</label>
			<input type="text" name="cep" value="<?php print $array['zip_code']; ?>" maxlength="12">

			<label class="lab_med">Caixa Postal</label>
				<input type="text" name="caixa_postal" value="<?php print $array['post_box']; ?>" maxlength="12">
		</td>
	</tr>
	<tr>
		<td>
			<label class="lab_primeiro">Telefone</label>
				<input type="text" name="telefone" value="<?php print $array['phone']; ?>" maxlength="80">
		</td>
		<td>
			<label class="lab_med">Fax</label>
				<input type="text" name="fax" value="<?php print $array['fax']; ?>" maxlength="25">

			<label class="lab_med">Celular</label>
				<input type="Celular" name="celular" value="<?php print $array['cellular']; ?>" maxlength="20">
		</td>
		
	</tr>
	<tr>
		<td colspan="2">
			<label class="lab_primeiro">Email</label>
				<input type="email" name="email" value="<?php print $array['e_mail']; ?>" maxlength="140">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label class="lab_primeiro">Tipo de Participação</label>
				<input type="text" name="participacao" readonly value="<?php print ($array['participation_type'] == 0 ? 'Participa da avaliação anual, incluindo os resultados nos cálculos de médias anuais.' : 'Não participa da avaliação anual, sem incluir seus resultados nas médias anuais.'); ?>" maxlength="25">
		</td>
	</tr>

<?php 
		} 
	}else
	{
		print '<tr class="readonly" colspan="2">';
			print '<td>'. $error_code .'</td>';
		print '</tr>';			
	}
?>
