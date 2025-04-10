<?php 
	require('../modal/acessos.php'); 
	$pk_laboratorio = $_GET['samp'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/programa_ano_novo.css">

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
		CADASTRO PROGRAMA
		<a href="/programa/novo" class="mais"></a>
	</h2>

	<form class="novo_ano_programa">
		<table cellspacing="1" cellpadding="0" border="0" width="500">	
			<tr class="cabecalho">
				<td width="135"><label class="lab_primeiro">Ano</label></td>
				<td><input type="text" maxlength="4" name="ano"></td>
			</tr>
			<tr>
				<td colspan="2">
					<a href="/programa" class="cancelar">CANCELAR</a>
					<button type="button">SALVAR</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>