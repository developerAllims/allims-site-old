<?php 
	require('../modal/acessos.php'); 
	
	if( ! $user->getUsuario() == 'true' || ! $user->getUsuario() == 't' )
	{
		header('Location: /avaliacao');
	}

	if( $_GET['usuario'] == $user->getId() )
	{
		header('Location: /usuario/alterar');
	}
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

	<h2 class="titulo subtitulo">Cadastro de Novo Usuário</h2>

	<form class="alterar_usuario_cadastrado">
		<table border="0">
			<?php include '../inc/alter_user.php' ?>
			<tr>
				<td colspan="7" align="right" style="border:none;">
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