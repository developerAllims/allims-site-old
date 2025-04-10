<?php 
	require('../modal/acessos.php'); 

	if( ( ! $user->getResultado() == 'true' && ! $user->getResultado() == 't' ) || ( ! $user->getLaboratorioAtivo() == 't' && ! $user->getLaboratorioAtivo() == 'true' ) )
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

	<h2 class="titulo">REGISTRO DE RESULTADOS</h2>

	<table cellspacing="1" cellpadding="0" border="0" class="listagem_resultado" >
		
			<?php include '../inc/list_result_open.php' ?>			
		
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>