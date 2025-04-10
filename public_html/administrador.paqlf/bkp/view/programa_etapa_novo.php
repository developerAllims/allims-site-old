<?php 
	require('../modal/acessos.php'); 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	
	<?php include('../inc/head.php'); ?>

	<link rel="stylesheet" type="text/css" href="/css/programa_ano_novo.css">

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
		CADASTRO ETAPA
	</h2>

	<?php include '../modal/vefic_quant_etapas.php'; ?>

	<form class="nova_etapa_programa">
		<table cellspacing="1" cellpadding="0" border="0" width="500">	
			<tr height="40">
				<td width="135"><label class="lab_primeiro">Data de Envio da Amostra</label></td>
				<td><input type="text" maxlength="10" name="data_envio" class="data_completa"></td>
			</tr>
			<tr height="40">
				<td width="135"><label class="lab_primeiro">Data Inicial de Envio dos Resultados</label></td>
				<td><input type="text" maxlength="10" name="data_inicial" class="data_completa"></td>
			</tr>
			<tr height="40">
				<td width="135"><label class="lab_primeiro">Data Final de Envio dos Resultados</label></td>
				<td><input type="text" maxlength="10" name="data_final" class="data_completa"></td>
			</tr>			
			<tr>
				<td colspan="2">
					<input type="hidden" name="programa" class="programa" value="<?php print $_GET['samp']; ?>">
					<a href="/programa/etapa/<?php print $_GET['samp']; ?>" class="cancelar">CANCELAR</a>
					<button type="button">SALVAR</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>