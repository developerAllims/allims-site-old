<?php 
	include_once ('../modal/functions.php');
	include_once ('../modal/conex_bd.php');
	$conexao = conexao();

	$query_request_status = "SELECT * FROM ep_request_seals_status ORDER BY norder";
	$result_request_status = pg_query($conexao, $query_request_status);
?>
<div class="filtro">
	<select name="where" class="where">
		<option value="aberto">Em Aberto</option>
		
		<?php 
			while ( $array_request_status = pg_fetch_array($result_request_status) ) 
			{
				print '<option value="' . $array_request_status['pk_request_seals_status'] . '">' . $array_request_status['identification'] . '</option>';
			}
		?>
		<option value="todos">Todos</option>
		<option value="cancelados">Cancelados</option>
	</select>
</div>