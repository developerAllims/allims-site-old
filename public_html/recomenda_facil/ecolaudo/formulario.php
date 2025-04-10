<?php 
	include 'model/conexao_bd.php';
	$conexao = conexao();
?>
<!DOCTYPE html>
<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Lab.Online</title>
	<meta http-equiv="content-language" content="PT-br"/>
	<meta http-equiv="X-UA-Compatible" content="IE=9;IE=10;IE=11;IE=Edge;" />

	<link rel="stylesheet" type="text/css" href="/ecolaudo/css/fonts.css">
	<link rel="stylesheet" type="text/css" href="/ecolaudo/css/formulario.css">
	<!--<script type="text/javascript" src="/ecolaudo/js/jquery-1.7.1/jquery-1.7.1.min.js"></script>-->
</head>
<body>
<form class="form_culturas">
	<div class="combo">
		<div class="inline">
			<p>Tecnologia</p>
			<select name="technology" class="technology">
				<option hidden="">Selecione uma Tecnologia</option>
				<?php 
					//Buscar tecnologias -- sf_tecnology
					$query_tecnology = "SELECT * FROM sf_technology ORDER BY identification";
					$result_tecnology = pg_query($conexao, $query_tecnology);

					while ( $array = pg_fetch_array($result_tecnology) ) 
					{
						print '<option value="' . $array['id'] . '">' . $array['identification'] . '</option>';
					}
				?>
			</select>
		</div>
		
		<div class="cultures"></div>
		
	</div>

	<div id="info_conteudo"></div>
	<a href="javascript:void(0)" class="bt_down btn_cancel">Cancelar</a>

	<input type="hidden" name="hidden_classe_data_id" value="<?php print $_GET['data-id']; ?>">

</form>
</body>
</html>