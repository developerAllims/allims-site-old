<?php 
	require('../modal/acessos.php'); 

	if( ( ! $user->getResultado() == 'true' && ! $user->getResultado() == 't' ) || ( ! $user->getLaboratorioAtivo() == 't' && ! $user->getLaboratorioAtivo() == 'true' ) )

	{

		header('Location: /avaliacao');

	}

	$samp = pg_escape_string($_GET['samp']);


	
	//print_r($result_samp);
	$send = '';

?>

<!DOCTYPE html>

<html lang="pt">

<head>

	<meta charset="utf-8">

	

	<?php include('../inc/head.php'); ?>



	<link rel="stylesheet" type="text/css" href="/css/listagem.css">

	<link rel="stylesheet" type="text/css" href="/css/resultado.css">



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



	<h2 class="titulo">RESULTADO</h2>



	<form class="alt_resultado">

		<?php include '../inc/top_list_result.php'; ?>

		

		<table cellspacing="2">

			


			<tr class="cinza_escuro">

				<td><span><b>Parâmetro</b></span></td>

				<td><span><b>Método</b></span></td>

				<td><span><b>Resultado</b></span></td>

				<td><span><b>Unidade</b></span></td>

				<td><span><b>Enviar</b></span></td>

			</tr>
			
			
	


			<?php include '../inc/list_param_result.php';   ?>




			

			<!--

			<tr class="comandos">

				<td colspan="5" align="left" >

					<input type="checkbox" id="send" name="padrao[send]" <?php print ( ( $send == 't' || $send == 'true' ) ? 'checked="checked' : '' ); ?> value="true"> 

					<label for="send" class="<?php print ( ( $send == 't' || $send == 'true' ) ? 'checked' : 'check' ); ?>">Não Participar</label>

				</td>

			</tr>-->
			<tr>
				<td colspan="5" align="left">
					<span>*Número presente na etiqueta enviada pelo programa</span>
				</td>
			</tr>

			<tr>
				<td align="right" colspan="5" style="border:none;">
					<input type="hidden" value="<?php print $samp; //people_samp ?>" name="pk_people_samp"> 

					<a href="/resultado" class="cancelar">CANCELAR</a>

					<button type="button" class="salvar">ENVIAR</button>

				</td>

			</tr>

		</table>

		
	</form>

</div>

	<?php include '../inc/rodape.php'; ?>

</body>

</html>