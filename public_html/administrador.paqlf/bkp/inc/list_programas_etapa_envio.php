<?php 

    require ('../modal/functions.php');

    require ('../modal/conex_bd.php');

    $conexao = conexao();





    $query_titulo = "

    		SELECT 

			   number_year 

			   ,number_of_year

			   ,fk_program_year

			FROM ep_program_year 

			INNER JOIN ep_program_year_steps ON ep_program_year_steps.fk_program_year = ep_program_year.pk_program_year 

			WHERE pk_program_year_steps = " . $pk_program_year_steps;



	$result_titulo = pg_query( $conexao, $query_titulo );

	$array_titulo = pg_fetch_all($result_titulo);



    $query = "

    	SELECT

		   ep_people.pk_person
		  , ep_people.lab_number

		  ,ep_people.person

		  ,ep_people.phone

		FROM

		  ep_people

		WHERE

		  ep_people.pk_person > 0

		  AND ep_people.pk_person not in 

		(



		SELECT DISTINCT

		  ep_people.pk_person

		FROM

		    ep_program_year

		    inner join ep_program_year_steps on ep_program_year_steps.fk_program_year = ep_program_year.pk_program_year

		    inner join ep_program_year_samp  on ep_program_year_samp.fk_program_year_steps = ep_program_year_steps.pk_program_year_steps

		    inner join ep_people_samp        on ep_people_samp.fk_program_year_samp = ep_program_year_samp.pk_program_year_samp

		    inner join ep_people             on ep_people.pk_person = ep_people_samp.fk_person

		WHERE

		  ep_program_year_steps.pk_program_year_steps = {$pk_program_year_steps}

		   and exists( select true from ep_people_samp_det where fk_people_samp = pk_people_samp and result > 0 )

		)

		order by person";



	$result = pg_query( $conexao, $query );

?>

	

	<h2 class="titulo">

		LABORATÓRIOS SEM ENVIO



		<a href="/programa/etapa/<?php print $array_titulo[0]['fk_program_year']; ?>" class="voltar"></a>

	</h2>



	<h2 class="sub_titulo">

		<?php print $array_titulo[0]['number_year'] . ' - Etapa ' . $array_titulo[0]['number_of_year']; ?>

	</h2>



	<table cellspacing="1" cellpadding="0" border="0" class="list_programas_etapa">	

		<tr class="cabecalho">

			<td><span><b>Número</b></span></td>

			<td><span><b>Laboratório</b></span></td>

			<td><span><b>Telefone</b></span></td>

		</tr>



<?php 

	$int = 0;

	while( $array = pg_fetch_array($result) )

	{

		$int++;

		print '<tr ' . ( $int%2 == 1 ? 'class="cinza_claro"' : '') . '>';

			print '<td>' . $array['lab_number'] . '</td>';

			print '<td>' . $array['person'] . '</td>';

			print '<td>' . $array['phone'] . '</td>';

		print '</tr>';

	}

?>

	<tr>

		<td style="background: #FFF;" colspan="3" align="right"> 

			<span style="font-size: 13px;"><?php print $int; ?> Labóratorios não enviaram resultados.</span>

		</td>

	</tr>

	</table>