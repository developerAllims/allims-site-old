<?php 
	require('../modal/acessos.php'); 
	if( (! $user->getSelo() == 'true' && ! $user->getSelo() == 't' ) || ( ! $user->getLaboratorioAtivo() == 't' && ! $user->getLaboratorioAtivo() == 'true' ) )
	{
		header('Location: /avaliacao');
	}
	$pk_selo = $_GET['selo'];
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

	<form class="alterar_selos form_selos">
		<table border="0" cellpadding="0" cellspacing="2">
			<?php include '../inc/list_alt_selos.php' ?>
		</table>
	</form>

</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>