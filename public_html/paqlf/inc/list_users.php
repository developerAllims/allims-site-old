<?php 
	require('../modal/functions.php');
	require('../modal/conex_bd.php');
	$conexao = conexao();

	$query = 'SELECT * FROM ep_users WHERE fk_person =' . $user->getLaboratorio() . ' ORDER BY user_name';


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
				<td><span><?php print $array['user_email']; ?></span></td>

				<td><span><?php print $array['user_name']; ?></span></td>
								
				<td>
					<input type="checkbox" id="amostra<?php print '_'.$int; ?>" name="amostra" value="1" <?php print ( $array['can_imput_results'] == 't' ? 'checked' : ''); ?>> 
					<label for="amostra<?php print '_'.$int; ?>" class="readonly <?php print ( $array['can_imput_results'] == 't' ? 'checked' : 'check'); ?>"></label>
				</td>
				
				<td>
					<label class="readonly <?php print ( $array['can_update_lab'] == 't' ? 'checked' : 'check'); ?>"></label>
				</td>
				
				<td>
					<label class="readonly <?php print ( $array['can_adm_users'] == 't' ? 'checked' : 'check'); ?>"></label>
				</td>
				<td>
					<label class="readonly <?php print ( $array['can_request_seals'] == 't' ? 'checked' : 'check'); ?>"></label>
				</td>
				<td>
					<label class="readonly <?php print ( $array['is_active'] == 't' ? 'checked' : 'check'); ?>"></label>
				</td>
				<td align="center">
					<a href="/usuario/alterar/<?php print $array['pk_user']; ?>" class="edit"></a>
				</td>
				<td>
					<a href="javascript:void(0);" data-id="<?php print $array['pk_user']; ?>" data-rel="<?php print $array['user_email']; ?>" class="excluir"></a>
				</td>
			</tr>
<?php
		$int++;
	 	} 
	}else
	{
		print '<tr class="readonly">';
			print '<td colspan="9">'. $error_code .'</td>';
		print '</tr>';
	}
?>