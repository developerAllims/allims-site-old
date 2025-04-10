<?php 

	require_once ('../modal/conex_bd.php');
	$conexao = conexao();
	

	$query = 'SELECT * FROM ep_users WHERE fk_person = ' . $fk_person . ' ORDER BY user_name';

	$result = pg_query($query);

	$int = 0;
	while ( $array = pg_fetch_array($result) ) 
	{
            print '<tr '.( $int%2 != 1 ? 'class="cinza_claro"' : '') .'>';
?>

	<td><span><?php print $array['user_email']; ?></span></td>

	<td><span><?php print $array['user_name']; ?></span></td>
	
	<!--<td><input type="password" name="senha" required readonly value="**********"></td>-->
		
	<?php if( $fk_person != '-10' ) { ?>

	<td align="center">
		<input type="checkbox" id="amostra<?php print '_'.$int; ?>" name="amostra" value="1" <?php print ( $array['can_imput_results'] == 't' ? 'checked' : ''); ?>> 
		<label for="amostra<?php print '_'.$int; ?>" class="readonly <?php print ( $array['can_imput_results'] == 't' ? 'checked' : 'check'); ?>"></label>
	</td>
	
	
	<td align="center">
		<label class="readonly <?php print ( $array['can_update_lab'] == 't' ? 'checked' : 'check'); ?>"></label>
	</td>
	
	<td align="center">
		<label class="readonly <?php print ( $array['can_adm_users'] == 't' ? 'checked' : 'check'); ?>"></label>
	</td>
	<td align="center">
		<label class="readonly <?php print ( $array['can_request_seals'] == 't' ? 'checked' : 'check'); ?>"></label>
	</td>
	<?php } ?>
	<td align="center">
		<label class="readonly <?php print ( $array['is_active'] == 't' ? 'checked' : 'check'); ?>"></label>
	</td>
	<td>
		<a href="<?php print ($fk_person != '-10' ? '/laboratorio/usuario/alterar/' . $array['pk_user'] : '/usuario/alterar/' . $array['pk_user'] ) ?>" class="edit"></a>
	</td>
	<td>
		<a href="javascript:void(0);" data-id="<?php print $array['pk_user']; ?>" data-rel="<?php print $array['user_email']; ?>" class="excluir"></a>
	</td>
</tr>
<?php
		$int++;
	 } 
?>