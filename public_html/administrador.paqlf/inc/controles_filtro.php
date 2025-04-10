<?php 
	include_once ('../modal/functions.php');
	include_once ('../modal/conex_bd.php');
	$conexao = conexao();

	$query_controls = "SELECT * FROM ep_samp_control ORDER BY description";
	$result_controls = pg_query($conexao, $query_controls);
?>
<div class="filtro">
	<select name="filtro_control" class="filtro_control">		
		<?php 
			while ( $array_controls = pg_fetch_array($result_controls) ) 
			{
				print '<option value="' . $array_controls['pk_samp_control'] . '" '. ( $array_controls['pk_samp_control'] == $v_pk_samp_control ? 'selected' : '' ) .' >' . $array_controls['description'] . '</option>';
			}
		?>
	</select>
</div>