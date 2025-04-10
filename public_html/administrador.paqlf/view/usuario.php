<?php 
	require('../modal/acessos.php'); 
	$fk_person = ( $_GET['samp'] != '' ? $_GET['samp'] : '-10' ) ;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">
	<link rel="stylesheet" type="text/css" href="/css/avaliacao.css">
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

	<h2 class="titulo">
		USUÁRIOS 
		<a href="<?php print ($fk_person != '-10' ? '/laboratorio/usuario/novo/' . $fk_person : '/usuario/novo/' ); ?>" class="mais"></a>

		<?php print ($fk_person != '-10' ? '<a href="/laboratorio" class="voltar"></a>' : ''); ?>
	</h2>

	<?php 
		if( isset($_GET['samp']) )
		{
			print '<h2 class="sub_titulo">';
				include '../inc/titulo_laboratorio.php';
			print '</h2>';
		}
	?>

	<table border="0" class="usuarios">
		<tr class="cabecalho">
			<td><span>Email</span></td>
			<td><span>Nome</span></td>
			<?php if( $_GET['samp'] != '' ) { ?>
			<td class="icons amostra"></td>
			<td class="icons laboratorio"></td>
			<td class="icons usuario"></td>
			<td class="icons selos"></td>
			<?php } ?>
			<td width="51" align="center">Ativo</td>
			<td width="51" align="center">Editar</td>
			<td width="51" align="center">Excluir</td>
		</tr>
		<?php include '../inc/list_usuarios.php'; ?>
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>