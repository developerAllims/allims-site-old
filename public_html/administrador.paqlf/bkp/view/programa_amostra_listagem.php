<?php 
	require('../modal/acessos.php'); 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">
	<link rel="stylesheet" type="text/css" href="/css/amostras.css">

	<style type="text/css">
		.listagem_amostra_etapa .cabecalho{ line-height: 10px; text-align: center; }
		.listagem_amostra_etapa .cabecalho td{ height: auto; line-height: 20px; padding: 0; }
		.listagem_amostra_etapa .cabecalho span{ width: auto; line-height: 20px; position: absolute; border-left: 1px solid #FFF; margin-left: -1px; padding: 5px 0; text-align: center; display: block; font-size: 13px !important; }
		.listagem_amostra_etapa .cabecalho span b{ font-size: 15px !important; display: block; }


		.listagem_amostra_etapa .cabecalho p{ color: #cfcfcf; margin:0; padding: 7px; text-align: center; font-size: 13px !important; }
		.listagem_amostra_etapa .cabecalho p b{ font-size: 15px !important; }

		.barra_colorida{ background: #cfcfcf !important; display: none; margin: 0 0 0 15px; }
	</style>

	<script type="text/javascript">
		$(document).ready(function()
		{

			$(window).resize(function()
			{
				$('.listagem_amostra_etapa .cabecalho span').each(function()
				{
					//alert($(this).parent().width());
					$(this).css('width', $(this).parent().width());
				});
				$('.listagem_amostra_etapa .cabecalho span').css('height', $('.cabecalho').height()-12);
				$('.barra_colorida').css('height', $('.cabecalho').height());
			});

			$('.listagem_amostra_etapa .cabecalho span').each(function()
			{
				//alert($(this).parent().width());
				$(this).css('width', $(this).parent().width());
			});
			$('.listagem_amostra_etapa .cabecalho span').css('height', $('.cabecalho').height()-12);
			$('.barra_colorida').css('height', $('.cabecalho').height());


			$(window).scroll(function() {
				if( $(this).scrollTop() > 210 )
				{
					//alert('oi');
					$('.barra_colorida').css({ 'width': $('.listagem_amostra_etapa').width() ,'display':'block', 'position': 'fixed', 'top':'0' });
					$('.listagem_amostra_etapa .cabecalho span').css({'position':'fixed', 'top':0, 'margin-top': 0});

					//$('.barra_branca').css({ 'width': $('.listagem_amostra').width() ,'display':'block', 'position': 'fixed', 'top':'35px' });
					//$('.listagem_amostra .sub_cabecalho span').css({'position':'fixed', 'top':'35px', 'margin-top': 0});
				}else
				{
					$('.barra_colorida').css({'display': 'none'});
					$('.listagem_amostra_etapa .cabecalho span').css({'position':'absolute', 'top':'230px', 'margin-top': '-15px'});

					//$('.barra_branca').css({'display': 'none'});
					//$('.listagem_amostra .sub_cabecalho span').css({'position':'absolute', 'top':'235px', 'margin-top': '-15px'});
				}
			});

			$('.data').keypress(function(event)
			{
				var tecla = event.keyCode;
				
				if ( tecla < 48 || tecla > 57 )
			        return false;
			    //alert(tecla);
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
		AMOSTRAS

		<?php include '../inc/voltar_amostra_resultado.php' ?>
		
	</h2>

	<?php 
		print '<h2 class="sub_titulo">';
			include '../inc/titulo_amostra_resultado.php';
		print '</h2>';
	?>

	<div class="barra_colorida"></div>
	<div class="barra_branca"></div>
	<table cellspacing="1" cellpadding="0" border="0" class="listagem_amostra_etapa" >		
			<?php include '../inc/list_programa_amostras_resultados.php'; ?>
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>