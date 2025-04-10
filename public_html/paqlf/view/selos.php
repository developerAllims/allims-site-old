<?php 

	require('../modal/acessos.php');  

	if( (! $user->getSelo() == 'true' && ! $user->getSelo() == 't' ) || ( ! $user->getLaboratorioAtivo() == 't' && ! $user->getLaboratorioAtivo() == 'true' ) )

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



	<h2 class="titulo">

		SOLICITAÇÃO DE SELOS 

		<a href="javascript:void(0)" class="mais add_selos"></a>

	</h2>



	<table border="0" class="listagem_selos">

		<tr class="cinza_escuro">

			<td><span><b>Data da Solicitação</b></span></td>

			<td><span><b>Solicitado por</b></span></td>

			<td><span><b>Númeração</b></span></td>

			<td><span><b>Descrição</b></span></td>

			<td><span><b>Quantidade</b></span></td>

			<td><span><b>Valor Unitário</b></span></td>

			<td><span><b>Valor Total</b></span></td>

			<td><span><b>Status do Pedido</b></span></td>

			<td><b>Editar</b></td>

			<td><b>Cancelar</b></td>

		</tr>



		<?php include '../inc/list_selos.php'; ?>



		

	</table>

</div>

<?php include '../inc/rodape.php'; ?>

</body>

</html>