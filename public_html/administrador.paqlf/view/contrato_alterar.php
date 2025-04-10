<?php 
	require('../modal/acessos.php'); 

	$pk_contracts = $_GET['pk_contracts'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<?php include('../inc/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="/css/contrato_novo.css">

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

	<h2 class="titulo subtitulo"><?php print ( $pk_contracts != '' ? 'ALTERAR' : 'CADASTRO NOVO');?> CONTRATO</h2>

	<?php include '../inc/alterar_contrato.php'; ?>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>