<?php 
	require('../modal/acessos.php'); 

	require_once ('../modal/conex_bd.php');
	$conexao = conexao();
	//$query_ano = "select number_year from ep_program_year where is_calculed = true and is_visible = true order by number_year desc limit 1";
	$query_ano = "
		select 
		  number_year 
		from 
		  ep_program_year 
		  inner join ep_program_year_steps on ep_program_year_steps.fk_program_year = ep_program_year.pk_program_year
		  inner join ep_program_year_samp on ep_program_year_samp.fk_program_year_steps = ep_program_year_steps.pk_program_year_steps
		where 
		  ep_program_year_samp.is_calculed = true 
		order by 
		  ep_program_year.number_year 
		desc limit 1";
	$result_ano = pg_query($conexao, $query_ano);
	$row_ano = pg_fetch_assoc($result_ano);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/listagem.css">
	<link rel="stylesheet" type="text/css" href="/css/amostras.css">

	<style type="text/css">
		.listagem_amostra .cabecalho{ line-height: 10px; text-align: center; }
		.listagem_amostra .cabecalho td{ height: auto; line-height: 20px; padding: 0; }
		.listagem_amostra .cabecalho span{ width: auto; line-height: 20px; position: absolute; border-left: 1px solid #FFF; margin-left: -1px; padding: 5px 0; text-align: center; display: block; font-size: 13px !important; }
		.listagem_amostra .cabecalho span b{ font-size: 15px !important; }


		.listagem_amostra .cabecalho p{ color: #cfcfcf; margin:0; padding: 7px; text-align: center; font-size: 13px }
		.listagem_amostra .cabecalho p b{ font-size: 15px !important; }

		.barra_colorida{ background: #cfcfcf !important; display: none; margin: 0 0 0 15px; }
	</style>

	<script type="text/javascript">
		$(document).ready(function()
		{
			$(window).resize(function()
			{
				$('.listagem_amostra .cabecalho span').each(function()
				{
					//alert($(this).parent().width());
					$(this).css('width', $(this).parent().width());
				});
				$('.listagem_amostra .cabecalho span').css('height', $('.cabecalho').height()-12);
				$('.barra_colorida').css('height', $('.cabecalho').height());
			});

			$('.listagem_amostra .cabecalho span').each(function()
			{
				//alert($(this).parent().width());
				$(this).css('width', $(this).parent().width());
			});
			$('.listagem_amostra .cabecalho span').css('height', $('.cabecalho').height()-12);
			$('.barra_colorida').css('height', $('.cabecalho').height());

			$(window).scroll(function() {
				if( $(this).scrollTop() > 190 )
				{
					//alert('oi');
					$('.barra_colorida').css({ 'width': $('.listagem_amostra').width() ,'display':'block', 'position': 'fixed', 'top':'0' });
					$('.listagem_amostra .cabecalho span').css({'position':'fixed', 'top':0, 'margin-top': 0});

					//$('.barra_branca').css({ 'width': $('.listagem_amostra').width() ,'display':'block', 'position': 'fixed', 'top':'35px' });
					//$('.listagem_amostra .sub_cabecalho span').css({'position':'fixed', 'top':'35px', 'margin-top': 0});

					//$('.listagem_amostra .sub_sub_cabecalho span').css({'position':'fixed', 'top':'45px', 'margin-top': 0});
				}else
				{
					$('.barra_colorida').css({'display': 'none'});
					$('.listagem_amostra .cabecalho span').css({'position':'absolute', 'top':'200px', 'margin-top': '-15px'});

					/*$('.barra_branca').css({'display': 'none'});
					$('.listagem_amostra .sub_cabecalho span').css({'position':'absolute', 'top':'235px', 'margin-top': '-15px'});*/
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

	<h2 class="titulo">AMOSTRAS ENVIADAS 
		<form class="filtro">
			Exercício &nbsp;&nbsp;
			<input type="text" name="data_inicial" class="data" maxlength="4" placeholder="Ano Inicial" value="<?php print $row_ano['number_year']; ?>"> -
			<input type="text" name="data_final" class="data" maxlength="4" placeholder="Ano Final" value="<?php print $row_ano['number_year']; ?>">
			<a href="javascript:void(0);" class="pesquisar"></a>
		</form>
	</h2>
	<form>
	
	</form>
	<div class="barra_colorida"></div>
	<table cellspacing="1" cellpadding="0" border="0" class="listagem_amostra" >		
			<?php include '../inc/list_amostras.php'; ?>
	</table>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>