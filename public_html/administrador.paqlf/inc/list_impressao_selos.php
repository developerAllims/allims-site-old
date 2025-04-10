<?php 

	include_once ('../modal/functions.php');

	require_once ('../modal/conex_bd.php');

	$conexao = conexao();







	$query_embrapa = "

			SELECT

			    ep_people.pk_person

			   ,ep_people.person

			   ,ep_people.contact_name

			   ,ep_people.address

			   ,ep_people.address_number

			   ,ep_people.post_box

			   ,ep_people.zip_code

			   ,ep_cities.city

			   ,ep_states.abbreviature

			FROM 

			  ep_people

			  LEFT JOIN ep_cities ON ( ep_cities.pk_city = ep_people.fk_city )

			  LEFT JOIN ep_states ON ( ep_states.pk_state = ep_people.fk_state )

			WHERE 

			  pk_person = -10";



	$result_embrapa = pg_query($query_embrapa);

	$array_embrapa = pg_fetch_all($result_embrapa);







	$code = explode(',', $codes);



	for( $i = 0; $i < count( $code ); $i++ )

	{

		$query = "

			SELECT

			    ep_people.pk_person

			   ,ep_people.person

			   ,ep_people.contact_name

			   ,ep_people.address

			   ,ep_people.address_number

			   ,ep_people.post_box

			   ,ep_people.zip_code

			   ,ep_cities.city

			   ,ep_states.abbreviature

			FROM 

			  ep_people

			  LEFT JOIN ep_cities ON ( ep_cities.pk_city = ep_people.fk_city )

			  LEFT JOIN ep_states ON ( ep_states.pk_state = ep_people.fk_state )

			WHERE 

			  pk_person = " . $code[$i];



		$result = pg_query($query);

?>





	<?php print ( ($i % 4 == 0 || $i == 0 ) ? '<div class="etiquetas">' : ''); ?>  

		<div class="etiqueta quebrapagina">

			<?php

				while ( $array = pg_fetch_array($result) ) 

				{

					print '<div class="destinatario">';

						print '<span><b>DESTINATÁRIO:</b></span><br>';

						print $array['person'] . '<br>';

						print ($array['contact_name'] != '' ? $array['contact_name'] . '<br>' : '');

						'<!--A/C JOSÉ PAULO SARMENTO<br>-->';

				 		print $array['address'] . ' ' . $array['address_number'] . '<br>';

						print ($array['post_box'] ? 'Caixa Postal ' . $array['post_box'] . '<br>' : '');

						'<!--SÃO BRAZ<br>-->';

						print $array['zip_code'] . ' ' . (  $array['city'] != '' && $array['abbreviature'] != '' ? $array['city'] . '-' . $array['abbreviature'] : '' ) . '<br>';

				

					print '</div>';

					print '<br><br>';

					print '<br><br><br>';

			



					if( !empty($array['zip_code']) ) 

					{ 

						print '<center><iframe src="/barcode/code.php?code='. replace(array('-','.','/'),'',$array['zip_code']) . '"></iframe></center>';

				 

					} 

				} 

			?>





			<hr>

			<div class="remetente">

				<span>Remetente:</span><br>

				<?php print $array_embrapa[0]['contact_name']; ?><br>

				<!--<?php print $array_embrapa[0]['person']; ?><br>-->

				<?php print $array_embrapa[0]['address'] . $array_embrapa[0]['address_number'] . '<br>'; ?>

				<?php print $array_embrapa[0]['person']; ?><br>

				<!--JARDMIN BOTÂNICO<br>-->

				<?php print $array_embrapa[0]['zip_code'] . ' ' . (  $array_embrapa[0]['city'] != '' && $array_embrapa[0]['abbreviature'] != '' ? $array_embrapa[0]['city'] . '-' . $array_embrapa[0]['abbreviature'] : '' ); ?><br>

			</div>

		</div>

	<?php print ( (($i+1) % 4 == 0 && $i != 0 ) ? '</div>' : ''); ?>  







<?php } ?>

</div><!--<br class="quebrapagina">-->