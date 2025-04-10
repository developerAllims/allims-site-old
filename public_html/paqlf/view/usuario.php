<?php 
	require('../modal/acessos.php'); 

	if( ! $user->getUsuario() == 'true' || ! $user->getUsuario() == 't' )
	{
		header('Location: /avaliacao');
	}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">

	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">
	<link rel="stylesheet" type="text/css" href="/css/usuario.css">

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

	<h2 class="titulo">CADASTRO DE USUÁRIOS <a href="/usuario/novo" class="mais"></a></h2>

	<table border="0" class="usuarios">
		<tr class="cinza_escuro">
			<td><span>Email</span></td>
			<td><span>Nome</span></td>
			<td class="icons amostra"></td>
			<td class="icons laboratorio"></td>
			<td class="icons usuario"></td>
			<td class="icons selos"></td>
			<td width="51">Ativo</td>
			<td width="51">Editar</td>
			<td width="51">Excluir</td>
		</tr>
		<?php include '../inc/list_users.php'; ?>
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>