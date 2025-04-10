<?php 
	include ('../modal/functions.php');
	require ('../modal/conex_bd.php');
	$conexao = conexao();

	$query = "SELECT 
		  ep_seals.pk_seals
		  ,ep_seals.price
		  ,ep_seals.description || ' (' || (ep_program_year.number_year+1) || ')' as description
		FROM 
		  ep_seals 
		  INNER JOIN ep_program_year ON ep_program_year.pk_program_year = ep_seals.fk_program_year
		WHERE 
		  is_disable = false 
		ORDER BY 
		  ep_program_year.number_year DESC";	

	$query_payment = "SELECT * FROM ep_payment_methods ORDER BY description";

	$query_contract = "SELECT ep_fc_contract_is_ok({$samp}, 'NOW()', 'NOW()')";

	$result = pg_query($conexao, $query);

	$result_payment = pg_query($conexao, $query_payment);

    $result_contract = pg_query( $query_contract );
    $array_contract = pg_fetch_all($result_contract);
    if( $array_contract[0]['ep_fc_contract_is_ok'] != 't' && $array_contract[0]['ep_fc_contract_is_ok'] != 'true' )
    {
        header('Location: /selo/');
        exit;
    }
?>

		<tr>
			<td><label>Descrição</label></td>
			<td>
				<select name="description" class="description">
					<?php 
						while ( $array = pg_fetch_array($result) ) 
						{
							print '<option value="'. $array['pk_seals'].'" data-rel="'. number_format($array['price'],2, ',', '').'">'. $array['description'].'</option>';
						}
					?>
				</select>
			</td>
		</tr>
			<td><label>Quantidade</label></td>
			<td><input type="text" name="quant" maxlength="9" class="quantidade"></td>
		</tr>
		<tr>
			<td><label>Valor Unitário</label></td>
			<td><span class="vlr_unitario readonly"></span></td>
		</tr>
		<tr>
			<td><label>Valor Total</label></td>
			<td><span class="vlr_total readonly"></span></td>
		</tr>
		<tr>
			<td><label>Método de Pagamento</label></td>
			<td>
				<select name="metodo_pagamento" class="metodo_pagamento">
					<?php 
						while ( $array_payment = pg_fetch_array($result_payment) ) 
						{
							print '<option value="'. $array_payment['pk_payment_methods'].'">'. $array_payment['description'].'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top"><label>Observação</label></td>
			<td><textarea name="obs" maxlength="90" class="observacao"></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="right" style="border:none;">
				<input type="hidden" name="lab_on" class="lab_on" value="<?php print $samp; ?>">
				<a href="/laboratorio/selo/<?php print $samp; ?>" class="cancelar">CANCELAR</a>
				<button type="button" class="salvar">SALVAR</button>
			</td>
		</tr>

