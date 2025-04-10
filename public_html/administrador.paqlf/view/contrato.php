<?php 
	require('../modal/acessos.php'); 

	$pk_person = $_GET['samp'];
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
	<?php include '../inc/menu.php'; ?>

	<h2 class="titulo">
		<?php print ( $pk_person != '' ? 'CONTRATOS DO LABORATÓRIO' : 'CONTRATOS VIGENTES'); ?>
		
		
		<?php print ( $pk_person != '' ? '<a href="/laboratorio/contrato/novo/'. $pk_person . '" class="mais"></a>' : '');  ?>

		<?php print ($pk_person != '-10' && $pk_person != '' ? '<a href="/laboratorio" class="voltar"></a>' : ''); ?>
	</h2>

	
	<?php 
		if( isset($_GET['samp']) )
		{
			print '<h2 class="sub_titulo">';
				include '../inc/titulo_laboratorio.php';
			print '</h2>';
		}
	?>

	<table class="lista_contratos">
		<tr class="cabecalho">
			<td><b>Laboratório</b></td>
			<td><b>Nº do Contrato</b></td>
			<td><b>Data Inicial</b></td>
			<td><b>Data Final</b></td>
			
			<?php print ( $pk_person != '' ? '<td><b>Desativado</b></td> <td align="center"><b>Editar</b></td><td align="center"><b>Excluir</b></td>' : ''); ?>
		</tr>
		<?php include '../inc/list_contratos.php'; ?>
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>