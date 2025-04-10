<?php 
	require('../modal/acessos.php'); 
	$pk_laboratorio = $_GET['samp'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/laboratorio.css">

	<script type="text/javascript" src="/js/admin.js"></script>
</head>
<body>
<div class="header">
	<div class="logo_embrapa"></div>

	<div class="menu_superior_login">
        <div class="drop">
         	<span><?php print $user->getNome(); ?></span>
			<ul>  
              <li><a href="/usuario/alterar">Editar Usuário</a></li>
              <li><a href="javascript:void(0)" class="logout">Sair</a></li>
          	</ul>
        </div>  
	</div>
</div>
<div class="body">
	<?php include '../inc/menu.php' ?>

	<h2 class="titulo">CADASTRO DO LABORATÓRIO</h2>

	
	<form class="novo_lab">
		<table border="0" cellpadding="1" cellspacing="1">	
			<tr>
				<td colspan="2">
					<label class="lab_primeiro">Razão Social</label>
					<input type="text" name="razao" value="<?php print $array['person']; ?>" maxlength="80"> 

					<label class="lab_lab">Código do Laboratório</label>
					<input type="text" name="cod" value="<?php print $array['lab_number']; ?>" maxlength="10">
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
						<input type="text" name="complemento" value="<?php print $array['complement']; ?>" maxlength="25"/>
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
						<select name="participacao">
							<option value="0">Participa da avaliação anual, incluindo os resultados nos cálculos de médias anuais.</option>
							<option value="1">Não participa da avaliação anual, sem incluir seus resultados nas médias anuais.</option>
						</select>
				</td>
			</tr>


			<tr>
				<td colspan="2">
					<label class="lab_primeiro" style="float:left;">Observações Internas</label>
						<textarea name="observacao" maxlength="2000"></textarea>
				</td>
			</tr>


			<tr>
				<td colspan="2">
					<a href="/laboratorio" class="cancelar">CANCELAR</a>
					<button type="button">SALVAR</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>