<?php 

	include ('../modal/functions.php');

	require ('../modal/conex_bd.php');

	$conexao = conexao();



	$query_description = "
		SELECT 
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



	$query = "SELECT * FROM ep_request_seals WHERE pk_request_seals = " . pg_escape_string($pk_selo);





	$error_code = fc_test_query( $conexao, $query );

	$error_code_payment = fc_test_query( $conexao, $query_payment );

	$error_code_description = fc_test_query( $conexao, $query_description );



	if( $error_code == '' && $error_code_payment == '' && $error_code_description == '' )

	{



		$result = pg_query($conexao, $query);



		while ( $array = pg_fetch_array($result) ) 

		{

			if( $array['fk_request_seals_status'] != 1 )

			{

				header('Location: /selo/');

			}

?>



	<tr>

		<td><label>Descrição</label></td>

		<td>

			<select name="description" class="description" disabled="disabled">

				<?php 

					

					$result_description = pg_query($conexao, $query_description);

					while ( $array_description = pg_fetch_array($result_description) ) 

					{

						print '<option value="'. $array_description['pk_seals'].'" data-rel="'. replace('.',',',$array_description['price']).'" '. ( $array['fk_seals'] == $array_description['pk_seals'] ? 'selected' : '' ) . '>'. $array_description['description'].'</option>';

					}

				?>

			</select>

		</td>

	</tr>

		<td><label>Quantidade</label></td>

		<td><input type="text" name="quant" class="quantidade" maxlength="9" value="<?php print $array['qtty']; ?>"></td>

	</tr>

	<tr>

		<td><label>Valor Unitário</label></td>

		<td><span class="vlr_unitario readonly"></span></td>

	</tr>

	<tr>

		<td><label>Valor Total</label></td>

		<td><span class="vlr_total readonly"> <?php  print 'R$ ' . number_format(( $array['qtty'] * $array['price'] ),2, ',', '.') ?> </span></td>

	</tr>

	<tr>

		<td><label>Método de Pagamento</label></td>

		<td>

			<select name="metodo_pagamento" class="metodo_pagamento">

				<?php 

					

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

		<td valign="top"><label>Observação</label></td>

		<td><textarea name="obs" maxlength="90" class="observacao"><?php print $array['obs']; ?></textarea></td>

	</tr>

	<tr>

		<td colspan="2" align="right" style="border:none;">

			<input type="hidden" name="selo" value="<?php print $array['pk_request_seals']; ?>">

			<a href="/selo" class="cancelar">CANCELAR</a>

			<button type="button" class="salvar">SALVAR</button>

		</td>

	</tr>



<?php 

		}

	}else

	{

		print '<tr class="readonly" colspan="2">';

			if( $error_code != '' )

			{

				print '<td>'. $error_code .'</td>';	



			}else if( $error_code_payment != '' )

			{

				print '<td>'. $error_code_payment .'</td>';

			}else

			{

				print '<td>'. $error_code_description .'</td>';

			}

		print '</tr>';		

	}



?>