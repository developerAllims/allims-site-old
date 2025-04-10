<?php 
date_default_timezone_set('America/Sao_Paulo');
	require('../modal/acessos.php'); 
?>

<!DOCTYPE html>

<html lang="pt">

<head>

	<meta charset="utf-8">

	

	<?php include('../inc/head.php'); ?>

	

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">

	<link rel="stylesheet" type="text/css" href="/css/avaliacao.css">



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



	<h2 class="titulo">AVALIAÇÃO ANUAL</h2>



	<!-- <div class="abas">

		<a href="javascript:void(0)" class="aba selected" data-id="1">MACRONUTRIENTE</a>

		<a href="javascript:void(0)" class="aba" data-id="3">TEXTURA</a>

	</div> -->



	<table cellspacing="1" cellpadding="0" border="0" class="avaliacao">

		<thead>

			<tr class="cabecalho readonly">

				<th>ANO</th>

				<th>TOTAL ANUAL</th>

				<th>TOTAL COM REPET.</th>

				<th>PONDERADO</th>

				<th>INEXATIDÃO</th>

				<th>IMPRECISÃO</th>

				<th>I.E.</th>

				<th>GRUPO</th>

				<th>GERAL</th>

			</tr>

		</thead>

		<tbody>

			<?php include '../inc/list_avaliacao.php'; ?>

		</tbody>

	</table>

</div>

<?php include '../inc/rodape.php'; ?>

</body>

</html>