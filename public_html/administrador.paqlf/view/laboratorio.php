<?php 

	require('../modal/acessos.php'); 
?>

<!DOCTYPE html>

<html lang="pt">

<head>

	<meta charset="utf-8">

	

	<?php include('../inc/head.php'); ?>



	<link rel="stylesheet" type="text/css" href="/css/listagem.css">

	<style type="text/css">

		.listagem_laboratorio .cabecalho span{ width: auto; position: absolute; border-left: 2px solid #FFF; margin-left: -12px; padding-left: 10px;}

		.listagem_laboratorio .cabecalho p{ color: #cfcfcf; margin: 0; padding: 0 5px;  }

		.barra_colorida{ height: 35px; background: #cfcfcf !important; display: none; margin: 0 0 0 15px; }

	</style>

	<script type="text/javascript">

		$(document).ready(function()

		{

			$(window).scroll(function() {

				if( $(this).scrollTop() > 190 )

				{

					//alert('oi');

					$('.barra_colorida').css({ 'width': $('.listagem_laboratorio').width() ,'display':'block', 'position': 'fixed', 'top':'0' });

					$('.listagem_laboratorio .cabecalho span').css({'position':'fixed', 'top':0, 'margin-top': 0});

				}else

				{

					$('.barra_colorida').css({'display': 'none'});

					$('.listagem_laboratorio .cabecalho span').css({'position':'absolute', 'top':'200px', 'margin-top': '-15px'});

				}

			});

		});

	</script>

	<script type="text/javascript" src="/js/admin.js"></script>

</head>

<body>

<div class="header">

	<div class="logo_embrapa"></div>



	<div class="menu_superior_login">

        <div class="drop">

         	<span><?php print $user->getNome() ?></span>

		<ul>  

              		<li><a href="/usuario/alterar">Editar Usuário</a></li>

              		<li><a href="javascript:void(0)" class="logout">Sair</a></li>

          	</ul>

        </div>  

	</div>

</div>

<div class="body">

	<?php include '../inc/menu.php' ?>



	<h2 class="titulo">LABORATÓRIOS 



		<a href="/laboratorio/novo/" class="mais"></a> 



		<select name="ocultar_laboratorios" style="width: 150px; height: 30px; margin-right: 40px; border-radius: 2px; float: right;">

			<option value="-1">Todos</option>

			<option value="1">Ativos</option>

			<option value="0">Inativos</option>

		</select>

	</h2>

	<div class="barra_colorida"></div>

	<table class="listagem_laboratorio">

		<thead>

			<tr class="cabecalho">

				<td width="50" align="center">

					<input type="checkbox" id="check_all"> 

					<span style="width: 50px; margin:-15px 0 0 -37px;"><label for="check_all" class="check check_all"></label></span>

				</td>

				<td width="50"><span><b class="pointer" data-rel="ASC">Número</b></span><p>Número</p></td>

				<td><span><b class="pointer" data-rel="DESC">Laboratório</b></span><p>Laboratório</p></td>

				<td><span><b class="pointer" data-rel="ASC">Cidade</b></span><p>Cidade</p></td>

				<td><span><b class="pointer" data-rel="ASC">Estado</b></span><p>Estado</p></td>

				<td><span><b>Ativo</b></span><p>Ativo</p></td>

				<td><span><b>Alterar</b></span><p>Alterar</p></td>

				<td><span><b>Usuários</b></span><p>Usuários</p></td>

				<td><span><b>Contratos</b></span><p>Contratos</p></td>

				<td><span><b>Contatos</b></span><p>Contatos</p></td>

				<td><span><b>Selos</b></span><p>Selos</p></td>

				<td><span><b>Amostras</b></span><p>Amostras</p></td>

				<td><span><b>Avaliações</b></span><p>Avaliações</p></td>

				<td><span><b>Excluir</b></span><p>Excluir</p></td>

			</tr>

		</thead>

		<tbody>

			<?php include '../inc/list_laboratorios.php' ?>

		</tbody>

		<tr style="background:#FFF;">

			<td colspan="13">

				<button type="button" class="gerar_selos">GERAR SELOS</button>

			</td>

		</tr>

	</table>

</div>

<?php include '../inc/rodape.php'; ?>

</body>

</html>