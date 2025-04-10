<?php 
	date_default_timezone_set('America/Sao_Paulo');
	require('../modal/acessos.php'); 


	
    require_once ('../modal/functions.php');
    require_once ('../modal/conex_bd.php');
    $conexao = conexao();

    $query_ano_verificacao = "
	    SELECT 
		  ep_people_program_year.pk_people_program_year 
		  ,ep_people_program_year.total_annual 
		  ,ep_people_program_year.full_repeat 
		  ,ep_people_program_year.considerate 
		  ,ep_people_program_year.inaccuracy 
		  ,ep_people_program_year.haziness 
		  ,ep_people_program_year.ie 
		  ,ep_people_program_year.final_group 
		  ,ep_people_program_year.derating_reason 
		  ,ep_program_year.number_year 
		FROM 
		  ep_people_program_year 
		  INNER JOIN ep_program_year ON ( ep_program_year.pk_program_year = ep_people_program_year.fk_program_year ) 
		  INNER JOIN ep_people ON ( ep_people.pk_person = ep_people_program_year.fk_person ) 
		WHERE 
		  ep_program_year.number_year = " . $_GET['ano'] . "
		  AND fk_person = " . $user->getLaboratorio() . " 
		  AND need_calcule = false 
		  AND fk_pa_det_res_groups = 1 
		ORDER BY ep_people_program_year.ie ASC";

	$result_ano = pg_query($conexao, $query_ano_verificacao);
	if( pg_num_rows($result_ano) < 1 )
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

	<link rel="stylesheet" type="text/css" href="/css/avaliacao.css">
	<style type="text/css">
		.body table tr td { padding: 0 10px; }
	</style>



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



	<h2 class="titulo">AVALIAÇÃO ANUAL <a href="/avaliacao" class="voltar"></a></h2>


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

			</tr>

		</thead>

		<tbody>

			<?php include '../inc/list_avaliacao_full.php'; ?>

		</tbody>

	</table>

</div>

<?php include '../inc/rodape.php'; ?>

</body>

</html>