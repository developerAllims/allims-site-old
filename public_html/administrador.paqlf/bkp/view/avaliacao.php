<?php 
	require('../modal/acessos.php'); 
	//print_r( $user );
	$pk_person = $_GET['samp'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">
	<link rel="stylesheet" type="text/css" href="/css/avaliacao.css">

	<style type="text/css">
		.tabela_avaliacoes .cabecalho span{ width: auto; position: absolute; border-left: 2px solid #FFF; padding-left: 10px; margin-left: -12px;}
		.tabela_avaliacoes .cabecalho p{ color: #cfcfcf; margin:0; padding: 0; text-align: center;}
		.barra_colorida{ height: 35px; background: #cfcfcf !important; display: none; margin: 0 0 0 15px; }
	</style>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$(window).scroll(function() {
				if( $(this).scrollTop() > 195 )
				{
					$('.barra_colorida').css({ 'width': $('.tabela_avaliacoes').width() ,'display':'block', 'position': 'fixed', 'top':'0' });
					$('.tabela_avaliacoes .cabecalho span').css({'position':'fixed', 'top':0, 'margin-top': 0});

				}else
				{
					$('.barra_colorida').css({'display': 'none'});
					$('.tabela_avaliacoes .cabecalho span').css({'position':'absolute', 'top':'200px', 'margin-top': '-15px'});
				}
			});

			$('.data').keypress(function(event)
			{
				var tecla = event.keyCode;
				
				if ( tecla < 48 || tecla > 57 )
			        return false;
			    //alert(tecla);
			});
			
		})
	</script>
	<script type="text/javascript" src="/js/admin.js"></script>
</head>
<body><!--- onload=setInterval("window.clipboardData.clearData()",20)>-->
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
		AVALIAÇÕES 

		<?php print ($pk_person != '-10' && $pk_person != '' ? '<a href="/laboratorio" class="voltar"></a>' : ''); ?>

		<?php if( !isset($pk_person) ) { ?> 
			<form class="filtro form_avaliacoes">
				<input type="text" name="ano" class="data" maxlength="4" placeholder="Digite um Ano" value="<?php print date('Y')-1; ?>" autocomplete="off">
				<a href="javascript:void(0);" class="pesquisar"></a>
			</form>
		<?php } ?>
	</h2>
	<?php 
		if( isset($_GET['samp']) )
		{
			print '<h2 class="sub_titulo">';
				include '../inc/titulo_laboratorio.php';
			print '</h2>';
		}
	?>

	<div class="barra_colorida"></div>


	<!-- <div class="abas">
		<a href="javascript:void(0)" class="aba selected" data-id="1">MACRONUTRIENTE</a>
		<a href="javascript:void(0)" class="aba" data-id="3">TEXTURA</a>
	</div> -->

	<table class="tabela_avaliacoes">
		<thead>
        <tr class="cabecalho">
            <td><span><b class="pointer" data-rel="ASC">Número</b></span><p>Número</p></td>
            <td align="left"><span><b class="pointer" data-rel="DESC">Laboratório</b></span><p>Laboratório</p></td>
            <td><span><b>Ano</b></span><p>Ano</p></td>
            <td><span><b class="pointer" data-rel="ASC">Total Anual</b></span><p>Total Anual</p></td>
            <td><span><b class="pointer" data-rel="ASC">Total com Repetição</b></span><p>Total com Repetição</p></td>
            <td><span><b class="pointer" data-rel="ASC">Ponderado</b></span><p>Ponderado</p></td>
            <td><span><b class="pointer" data-rel="ASC">Inexatidão</b></span><p>Inexatidão</p></td>
            <td><span><b class="pointer" data-rel="ASC">Imprecisão</b></span><p>Imprecisão</p></td>
            <td><span><b class="pointer" data-rel="ASC">I.E.</b></span><p>I.E.</p></td>
            <td><span><b class="pointer" data-rel="ASC">Grupo</b></span><p>Grupo</p></td>
        </tr>
        </thead>

        <tbody>
			<?php include '../inc/list_avaliacoes.php' ?>
		</tbody>
	</table>
    <span class="observacao">* Laboratório Desclassificado</span>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>