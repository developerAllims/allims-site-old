<?php 

	require ('../modal/functions.php');

	//require ('../modal/acessos.php');

	require ('../modal/conex_bd.php');

	$conexao = conexao();

	



	$query = "

		SELECT 

		   ep_request_seals.pk_request_seals

		   , CAST( ep_request_seals.date_request as DATE)

		   , ep_users.user_name

		   , ep_request_seals.description

		   , ep_request_seals.qtty

		   , ep_request_seals.price

		   , ep_request_seals.fk_request_seals_status

		   , ep_request_seals.canceled

		   , ep_request_seals_status.identification

   		   , ep_request_seals.number_initial

   		   , ep_request_seals.number_final

		FROM 

		   ep_request_seals 

		INNER JOIN 

		   ep_users ON ( ep_users.pk_user = ep_request_seals.fk_user_request )

		INNER JOIN

		   ep_seals ON ( ep_seals.pk_seals = ep_request_seals.fk_seals)

		INNER JOIN

		   ep_request_seals_status ON ( ep_request_seals_status.pk_request_seals_status = ep_request_seals.fk_request_seals_status)

		WHERE 

		   ep_request_seals.fk_person = {$user->getLaboratorio()} 

		ORDER BY ep_request_seals.date_request DESC, ep_request_seals.fk_request_seals_status ASC";





	$error_code = fc_test_query( $conexao, $query );



	if( $error_code == '' )

	{



		$result = pg_query($conexao, $query);



		while ( $array = pg_fetch_array($result) ) 

		{

			print '<tr class="cinza_claro">';

				print '<td>' . mostraData($array['date_request']) . '</td>';

				print '<td>' . $array['user_name'] . '</td>';

				print '<td>' . $array['number_initial'] . ' - ' . $array['number_final'] . '</td>';

				print '<td>' . $array['description'] . '</td>';

				print '<td>' . $array['qtty'] . '</td>';

				print '<td> R$ ' . number_format($array['price'],2, ',', '.') . '</td>';

				print '<td> R$ ' . number_format(( $array['qtty'] * $array['price'] ),2, ',', '.') . '</td>';

				print '<td>' . ( ( $array['canceled'] == 'f' || $array['canceled'] == 'false' ) ? $array['identification'] : 'Cancelado') . '</td>';

				if( $array['fk_request_seals_status'] == 1 && ( $array['canceled'] == 'f' || $array['canceled'] == 'false' ) )

				{

					print '<td><a href="/selo/alterar/' . $array['pk_request_seals'] . '" class="edit"></a></td>';

					print '<td><a href="javascript:void(0);" class="excluir" data-rel="' . $array['pk_request_seals'] . '">' . $array[''] . '</a></td>';

				}else

				{

					print '<td><a href="javascript:void(0);" class="edit readonly"></a></td>';

					if( $array['canceled'] == 'f' || $array['canceled'] == 'false' )

					{

						print '<td><a href="javascript:void(0);" class="excluir readonly">' . $array[''] . '</a></td>';

					}else

					{

						print '<td><a href="javascript:void(0);" class="cancelado readonly">' . $array[''] . '</a></td>';

					}

					

				}

			print '</tr>';

		}

	}else

	{

		print '<tr class="readonly">';

			print '<td colspan="2">'. $error_code .'</td>';

		print '</tr>';

	}

?>