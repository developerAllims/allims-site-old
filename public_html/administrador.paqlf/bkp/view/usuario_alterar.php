<?php 
	require('../modal/acessos.php');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/novo_usuario.css">

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

	<h2 class="titulo subtitulo">Alteração de Usuário</h2>

	<form class="alterar_usuario">
		<table border="0">
			<tr>
				<td width="135">
					<label class="lab_primeiro">Nome</label>
				</td>
				<td>
					<input type="text" name="nome" required value="<?php print $user->getNome(); ?>" maxlength="90">
				</td>
			</tr>
			<tr>
				<td>
					<label class="lab_primeiro">Email</label>
				</td>
				<td>
					<span><?php print $user->getEmail(); ?></span>
					
				</td>
			</tr>
			<tr>
				<td height="30">
				</td>
			</tr>
			<tr>
				
				<td>
					<input type="checkbox" id="troca_senha" name="trocar_senha" value="1"> 
					<label for="troca_senha" class="check">Alterar senha ?</label>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<label class="lab_primeiro">Nova Senha</label>
				</td>
				<td>
					<input type="password" name="senha" readonly maxlength="18">
				</td>
			</tr>
			<tr>
				<td rowspan="4" valign="top">
					<label class="lab_primeiro">Redigite Nova Senha</label>
				</td>
				<td>
					<input type="password" name="re-senha" readonly maxlength="18">
				</td>
			</tr>
			<tr>
				<td align="right">
					<a href="/usuario" class="cancelar">CANCELAR</a>
					<button type="button" class="salvar">SALVAR</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>