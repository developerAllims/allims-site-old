<?php 
	include ('../modal/functions.php');
	require ('../modal/conex_bd.php');
	$conexao = conexao();

	$query = "SELECT * FROM ep_request_seals WHERE pk_request_seals = {$pk_selo}";

	$result = pg_query($conexao, $query);

	while ( $array = pg_fetch_array($result) ) 
	{

?>

	<tr>
		<td><label>Descrição</label></td>
		<td>
			<?php 
				$query_description = "
					SELECT 
					  ep_seals.pk_seals
					  ,ep_seals.price
					  ,ep_seals.description || ' (' || (ep_program_year.number_year+1) || ')' as description
					FROM 
					  ep_seals 
					  INNER JOIN ep_program_year ON ep_program_year.pk_program_year = ep_seals.fk_program_year
					WHERE 
					  ep_seals.pk_seals = {$array['fk_seals']} AND is_disable = false 
					ORDER BY 
					  ep_program_year.number_year DESC";
				$result_description = pg_query($conexao, $query_description);
				while ( $array_description = pg_fetch_array($result_description) ) 
				{
					print '<input type="text" maxlength="90" readonly class="observacao readonly" value="'.$array_description['description'].'">';
				}
			?>
		</td>
	</tr>
	<tr>
		<td><label>Status</label></td>
		<td>
			<select name="status">
				<?php 
					$query_status = "SELECT * FROM ep_request_seals_status ORDER BY pk_request_seals_status";
					$result_status = pg_query($conexao, $query_status);
					while ( $array_status = pg_fetch_array($result_status) ) 
					{
						print '<option value="'. $array_status['pk_request_seals_status'].'" ' . ( $array['fk_request_seals_status'] == $array_status['pk_request_seals_status'] ? 'selected' : '' ) . '>'. $array_status['identification'].'</option>';
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label>Quantidade</label></td>
		<td><input type="text" name="quant" class="quantidade readonly" readonly maxlength="9" value="<?php print $array['qtty']; ?>"></td>
	</tr>
	<tr>
		<td><label>Valor Unitário</label></td>
		<td><span class="vlr_unitario readonly">  <?php  print 'R$ ' . number_format(( $array['price'] ),2, ',', '') ?> </span></td>
	</tr>
	<tr>
		<td><label>Valor Total</label></td>
		<td><span class="vlr_total readonly"> <?php  print 'R$ ' . number_format(( $array['qtty'] * $array['price'] ),2, ',', '') ?> </span></td>
	</tr>
	<tr>
		<td><label>Método de Pagamento</label></td>
		<td>
			<select name="metodo_pagamento" class="metodo_pagamento readonly" disabled>
				<?php 
					$query_payment = "SELECT * FROM ep_payment_methods ORDER BY description";
					$result_payment = pg_query($conexao, $query_payment);
					while ( $array_payment = pg_fetch_array($result_payment) ) 
					{
						print '<option value="'. $array_payment['pk_payment_methods'].'" ' . ( $array['fk_payment_methods'] == $array_description['pk_payment_methods'] ? 'selected' : '' ) . '>'. $array_payment['description'].'</option>';
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label>Observação</label></td>
		<td><input type="text" maxlength="90" readonly class="observacao readonly" value="<?php print $array['obs']; ?>"></td>
	</tr>
	<tr>
		<td><label>Númeração Inicial</label></td>
		<td>
			<input type="text" name="initial" class="" maxlength="10" value="<?php print $array['number_initial']; ?>">
		</td>
	</tr>
	<tr>
		<td><label>Númeração Final</label></td>
		<td>
			<input type="text" name="final" class="" maxlength="10" value="<?php print $array['number_final']; ?>">
		</td>
	</tr>

	<tr>
		<td valign="top"><label>Observação Interna</label></td>
		<!--<td><input type="text" name="observacao_interna" maxlength="90" class="observacao" value="<?php print $array['internal_obs']; ?>"></td>-->
		<td><textarea name="observacao_interna" maxlength="90" class="observacao"><?php print $array['internal_obs']; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="right" style="border:none;">
			<input type="hidden" name="pk_selo" value="<?php print $array['fk_seals']; ?>">
			<input type="hidden" name="selo" value="<?php print $array['pk_request_seals']; ?>">
			<input type="hidden" name="laboratorio" value="<?php print $array['fk_person']; ?>">
			<a href="/selo" class="cancelar">CANCELAR</a>
			<button type="button" class="salvar">SALVAR</button>
		</td>
	</tr>
<?php } ?>