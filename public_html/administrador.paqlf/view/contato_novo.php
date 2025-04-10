<?php 
	require('../modal/acessos.php'); 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/contato.css">

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

	<h2 class="titulo">
		CADASTRO CONTATO
	</h2>

	<form class="novo_contato">
		<table cellspacing="1" cellpadding="0" border="0">	
			<tr>
				<td width="135"><label class="lab_primeiro">Nome</label></td>
				<td><input type="text" maxlength="90" name="nome"></td>
			</tr>
			<tr>
				<td width="135"><label class="lab_primeiro">Escritório</label></td>
				<td><input type="text" maxlength="90" name="escritorio"></td>
			</tr>
			<tr>
				<td width="135"><label class="lab_primeiro">Departamento</label></td>
				<td><input type="text" maxlength="90" name="departamento"></td>
			</tr>
			<tr>
				<td width="135"><label class="lab_primeiro">Telefone</label></td>
				<td><input type="text" maxlength="90" name="telefone"></td>
			</tr>
			<tr>
				<td width="135"><label class="lab_primeiro">Celular</label></td>
				<td><input type="text" maxlength="90" name="celular"></td>
			</tr>
			<tr>
				<td width="135"><label class="lab_primeiro">Email</label></td>
				<td><input type="text" maxlength="140" name="email"></td>
			</tr>
			<tr>
				<td width="135" valign="top"><label class="lab_primeiro">Informações Adicionais</label></td>
				<td><textarea name="informacoes" maxlength="190"></textarea></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="hidden" name="lab_on" class="lab_on" value="<?php print $_GET['samp']; ?>">
					<a href="/laboratorio/contato/<?php print $_GET['samp']; ?>" class="cancelar">CANCELAR</a>
					<button type="button">SALVAR</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>