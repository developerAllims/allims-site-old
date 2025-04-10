<?php 
	require('../modal/acessos.php'); 
	$pk_selo = $_GET['samp'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/selos.css">
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

	<h2 class="titulo">SOLICITAÇÃO DE SELOS </h2>

	<form class="alterar_selos_laboratorio form_selos">
		<table border="0" cellpadding="0" cellspacing="2">
			<?php include '../inc/list_alt_selos_laboratorio.php' ?>
		</table>
	</form>

</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>