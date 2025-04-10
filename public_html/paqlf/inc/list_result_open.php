<?php 
	include ('../modal/functions.php');
	require ('../modal/conex_bd.php');
	$conexao = conexao();

	$query = "SELECT 
		   ep_program_year.number_year
		  ,ep_program_year_steps.number_of_year
		  ,ep_program_year_samp.samp_number
		  ,ep_program_year_samp.pk_program_year_samp
		  ,ep_program_year_steps.send_date
		  ,ep_people_samp.not_send
		  ,ep_people_samp.serial_number
		  ,ep_program_year_steps.date_initial
		  ,ep_program_year_steps.date_final
		FROM
		  ep_program_year_steps
		  INNER JOIN ep_program_year      ON ( ep_program_year.pk_program_year = ep_program_year_steps.fk_program_year )
		  INNER JOIN ep_program_year_samp ON ( ep_program_year_samp.fk_program_year_steps = ep_program_year_steps.pk_program_year_steps )
		  LEFT  JOIN ep_people_samp       ON ( ep_people_samp.fk_program_year_samp = ep_program_year_samp.pk_program_year_samp AND fk_person = {$user->getLaboratorio()}  )
		WHERE
		      CAST(NOW() as DATE) >= date_initial     
		  AND CAST(NOW() as DATE) <= date_final 
		ORDER BY
		  ep_program_year_samp.samp_number";


	$error_code = fc_test_query( $conexao, $query );

	if( $error_code == '' )
	{
		$result = pg_query($query);


		if( @pg_num_rows($result) < 1 )
		{
			print '<tr class="readonly">';
				print '<td><label>Nenhuma amostra disponível para ser preenchida.</label></td>';
			print '</tr>';					
		}else
		{
			print '<thead>
				<tr class="cinza_escuro">
					<th>Ano</th>
					<th>Número da Amostra</th>
					<th>Número de Série</th>
					<th>Remessa</th>
					<th>Data da Remessa</th>
					
					<th>Status</th>
					
					<th>Prazo Envio</th>
					<th>Editar</th>
				</tr>
			</thead>
			<tbody>';
		}

		while ( $array = pg_fetch_array($result) ) 
		{
?>
		<tr class="cinza_claro">
			<td><?php print $array['number_year']; ?></td>
			<td><?php print $array['samp_number']; ?></td>
			<td><?php print ( $array['serial_number'] ? $array['serial_number'] : '-' ); ?></td>
			<td><?php print $array['number_of_year']; ?></td>
			<td><?php print ( $array['send_date'] ? mostraData($array['send_date']) : '-' ); ?></td>
			<td>
				<?php 
					if( $array['not_send'] == 'f' || $array['not_send'] == 'false' )
					{
						print 'Participante';
					}else if( $array['not_send'] == 't' || $array['not_send'] == 'true' )
					{
						print 'Não Participante';
					}else
					{
						print 'Não Preenchido';
					}
				?>
			</td>
			<td><?php print mostraData($array['date_final']); ?></td>
			<td>
				<!--<input type="hidden" class="inicial" value="<?php print $array['date_initial']; ?>">
				<input type="hidden" class="final" value="<?php print $array['date_final']; ?>">
				<input type="hidden" class="year" value="<?php print $array['pk_program_year_samp']; ?>">
				<input type="hidden" class="number" value="<?php print $array['samp_number']; ?>">-->

				<a href="javascript:void(0)" data-inicial="<?php print $array['date_initial']; ?>" data-final="<?php print $array['date_final']; ?>" data-year="<?php print $array['pk_program_year_samp']; ?>" data-number="<?php print $array['samp_number']; ?>" class="edit edit_resultado"></a>
			</td>
		</tr>
<?php
		print '</tbody>';
		}
	}else
	{
		print '<tr class="readonly">';
			print '<td><label>'. $error_code .'</label></td>';
		print '</tr>';			
	}
?>