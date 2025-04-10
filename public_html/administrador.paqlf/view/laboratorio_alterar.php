<?php 
	require('../modal/acessos.php'); 
	$pk_laboratorio = $_GET['samp'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/laboratorio.css">

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

	<h2 class="titulo">CADASTRO DO LABORATÓRIO</h2>

	
	<form class="alt_lab">
		<table border="0" cellpadding="1" cellspacing="1">	
			<?php include '../inc/list_lab_alterar.php'; ?>
			<tr>
				<td colspan="2">
					<a href="/laboratorio" class="cancelar">CANCELAR</a>
					<button type="button">SALVAR</button>
				</td>
			</tr>
		</table>
		<input type="hidden" name="laboratorio" value="<?php print $_GET['samp']; ?>">
	</form>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>