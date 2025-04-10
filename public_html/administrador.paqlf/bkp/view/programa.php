<?php 
	require('../modal/acessos.php'); 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">
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
		PROGRAMA
		<a href="/programa/novo" class="mais"></a>
	</h2>

	<table cellspacing="1" cellpadding="0" border="0" class="list_programas">	
		<tr class="cabecalho">
			<td><span><b>Programa</b></span></td>
			<td><span><b>Calcular</b></span></td>
			<td><span><b>Publicar</b></span></td>
			<td><span><b>Etapas</b></span></td>
			<td><span><b>Amostras</b></span></td>
			<td align="center"><span><b>Excluir</b></span></td>
		</tr>
		<?php include '../inc/list_programas.php' ?>
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>