<?php 
	require('../modal/acessos.php'); 
	$samp = $_GET['samp'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">
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
	<?php include '../inc/menu.php'; ?>

	<h2 class="titulo">
		SOLICITAÇÃO DE SELOS
		
		<?php 
			print (!empty($samp) ? '<a href="javascript:void(0)" class="mais add_selos"></a>' : '');

			print (!empty($samp) ? '<a href="/laboratorio" class="voltar"></a>' : '');

			include '../inc/selos_filtro.php'; 
		?>
	</h2>

	<table border="0" class="listagem_selos" data-id="<?php print $samp ?>">
		<thead>
			<tr class="cinza_escuro">
				<td><span><b>Data da Solicitação</b></span></td>
				<td><span><b>Nº Laboratório</b></span></td>
				<td><span><b>Laboratório</b></span></td>
				<td><span><b>Solicitado por</b></span></td>
				<td><span><b>Númeração</b></span></td>
				<td><span><b>Descrição</b></span></td>
				<td><span><b>Quantidade</b></span></td>
				<td><span><b>Valor Unitário</b></span></td>
				<td><span><b>Valor Total</b></span></td>
				<td><span><b>Status do Pedido</b></span></td>
				<td><span><b>Observação</b></span></td>
				<td><span><b>Observação Interna</b></span></td>
				<td><b>Editar</b></td>
				<!--<td><b>Cancelar</b></td>-->
			</tr>
		</thead>
		<tbody>
			<?php include '../inc/list_selos.php'; ?>
		</tbody>
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>