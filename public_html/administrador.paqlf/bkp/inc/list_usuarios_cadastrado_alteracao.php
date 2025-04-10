<?php 
	require('../modal/conex_bd.php');
	$conexao = conexao();

	$query = 'SELECT * FROM ep_users WHERE pk_user =' . $_GET['samp'];

	$result = pg_query($query);

	if( pg_num_rows($result) < 1 )
	{
		header('Location: /usuario/alterar');
	}
	while ( $array = pg_fetch_array($result) ) 
	{
?>

<tr>
	<td width="135">
		<label class="lab_primeiro">Nome</label>
	</td>
	<td>
		<input type="text" name="nome" required value="<?php print $array['user_name'] ?>">
	</td>
</tr>
<tr>
	<td>
		<label class="lab_primeiro">Email</label>
	</td>
	<td>
		<span><?php print $array['user_email'] ?></span>
	</td>
</tr>
<tr>
	<td rowspan="4" valign="top">
		<label class="lab_primeiro">Privilégios</label>
	</td>
	<td class="sub_td">
		<table border="0" class="table_interna">
			<?php if( $array['fk_person'] != '-10' ) { ?>
			<tr>
				<td>
					<input type="checkbox" id="novo_amostra" name="amostra" <?php print ($array['can_imput_results'] == 't' || $array['can_imput_results'] == 'true' ? 'checked' : '') ?> value="true"> 
						<label for="novo_amostra" class="<?php print ($array['can_imput_results'] == 't' || $array['can_imput_results'] == 'true' ? 'checked' : 'check') ?>">
							<img src="/images/ico_novo_resultado_on.png" class="img_amostra">
							Cadastrar Resultados de Amostras
			</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="checkbox" id="novo_laboratorio" name="laboratorio" <?php print ($array['can_update_lab'] == 't' || $array['can_update_lab'] == 'true' ? 'checked' : '') ?> value="true"> 
						<label for="novo_laboratorio" class="<?php print ($array['can_update_lab'] == 't' || $array['can_update_lab'] == 'true' ? 'checked' : 'check') ?>">
							<img src="/images/ico_laboratorio_on.png">
							Alterar Cadastro do Laboratório
						</label>
				</td>
			</tr>
				
			<tr>	
				<td>
					<input type="checkbox" id="novo_usuario" name="check_usuario" <?php print ($array['can_adm_users'] == 't' || $array['can_adm_users'] == 'true' ? 'checked' : '') ?> value="true">
						<label for="novo_usuario" class="<?php print ($array['can_adm_users'] == 't' || $array['can_adm_users'] == 'true' ? 'checked' : 'check') ?>">
							<img src="/images/ico_usuario_on.png" class="img_usuario">
							Administrar Usuários
						</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="checkbox" id="selo" name="selo" <?php print ($array['can_request_seals'] == 't' || $array['can_request_seals'] == 'true' ? 'checked' : '') ?> value="true"> 
						<label for="selo" class="<?php print ($array['can_request_seals'] == 't' || $array['can_request_seals'] == 'true' ? 'checked' : 'check') ?>">
							<img src="/images/ico_selos_on.png">
							Solicitar Selos
						</label>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td>
					<input type="checkbox" id="ativo" name="ativo" <?php print ($array['is_active'] == 't' || $array['is_active'] == 'true' ? 'checked' : '') ?> value="true"> 
						<label for="ativo" class="<?php print ($array['is_active'] == 't' || $array['is_active'] == 'true' ? 'checked' : 'check') ?>">
							Ativo
						</label>
				<input type="hidden" name="usuario" value="<?php print $array['pk_user'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="7" align="right" style="border:none;">
		<input type="hidden" name="lab_on" class="lab_on" value="<?php print $array['fk_person']; ?>">
		<a href="<?php print ($array['fk_person'] != '-10' ? '/laboratorio/usuario/'.$array['fk_person'] : '/usuario'); ?>" class="cancelar">CANCELAR</a>
		<button type="button" class="salvar">SALVAR</button>
	</td>
</tr>
<?php } ?>