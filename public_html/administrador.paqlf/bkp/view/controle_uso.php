<?php 
	require('../modal/acessos.php'); 
	$v_pk_samp_control = $_GET['samp'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">
	<link rel="stylesheet" type="text/css" href="/css/controle_uso.css">
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
		AMOSTRAS DE REFERÊNCIAS
		

		<?php include '../inc/controles_filtro.php'; ?>
	</h2>
	

	<table cellspacing="1" cellpadding="0" border="0" class="lista_controle">	
		<thead>
		<tr class="cabecalho">
			<td><span><b>Ano</b></span></td>
			<td><span><b>Etapa</b></span></td>
			<td><span><b>Amostra</b></span></td>
			<td><span><b>Amostras de Referências</b></span></td>
			<td><span><b>Informações</b></span></td>
		</tr>
		</thead>
		<tbody>
		<?php include '../inc/list_controles_uso.php' ?>
		</tbody>
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>