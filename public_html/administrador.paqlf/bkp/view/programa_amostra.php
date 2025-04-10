<?php 

	require('../modal/acessos.php'); 

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



	<h2 class="titulo">

		AMOSTRAS DO PROGRAMA

		<a href="/programa/amostra/novo/<?php print $_GET['samp']; ?>" class="mais"></a>



		<a href="/programa" class="voltar"></a>

	</h2>



	<h2 class="sub_titulo">

		<?php include '../inc/titulo_programa.php'; ?>


		<a href="javascript:void(0)" class="exportar_csv" style="float: right; color: #14346D;">Exportar</a>

		<!-- <a href="/modal/export_csv.php?program_year=<?php print $_GET['samp']; ?>" style="float: right; color: #14346D;">Exportar</a> -->
	</h2>



	<table cellspacing="1" cellpadding="0" border="0" class="list_programa_amostras">	

		<tr class="cabecalho">

			<td>
				<input type="checkbox" id="check_all">
				<label for="check_all" class="check check_all"></label>
			</td>

			<td><span><b>Etapa</b></span></td>

			<td><span><b>Número da Amostra</b></span></td>

			<td><span><b>Controle</b></span></td>

			<td><span><b>Resultados</b></span></td>

			<td><span><b>Editar</b></span></td>

			<td align="center"><span><b>Exluir</b></span></td>

		</tr>

		<?php include '../inc/list_programa_amostras.php' ?>

	</table>

</div>

<?php include '../inc/rodape.php'; ?>

</body>

</html>