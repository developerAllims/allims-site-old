<?php 
	
	require_once ('../modal/functions.php');

	//require_once ('../modal/acessos.php');

	require_once ('../modal/conex_bd.php');

	$conexao = conexao();

	

	$where = "";

	if( ! isset($_GET['where']) || $_GET['where'] == 'aberto' )

	{

		$where = "WHERE ep_request_seals_status.finish = false AND ep_request_seals.canceled = false";

	}else if( $_GET['where'] == 'todos' )

	{

		

	}else if( $_GET['where'] == 'cancelados' )

	{

		$where = "WHERE ep_request_seals.canceled = true ";

	}else

	{

		$where = "WHERE ep_request_seals_status.pk_request_seals_status = " . $_GET['where'] . " AND ep_request_seals.canceled = false";

	}


	if( (!empty($samp) || !empty($_GET['samp'])) )
	{
		$samp = $_GET['samp'];

		$where .= ( $_GET['where'] != 'todos' ? ' AND ' : ' WHERE ' );
		$where .= " ep_request_seals.fk_person = " . $samp;
	}
	//print 'estou aqui';



	$query = "

		SELECT 

		   ep_request_seals.pk_request_seals

		   , CAST( ep_request_seals.date_request as DATE)

			, ep_people.lab_number
   
   			, ep_people.person   

		   , ep_users.user_name

		   , ep_request_seals.description

		   , ep_request_seals.qtty

		   , ep_request_seals.price

		   , ep_request_seals.fk_request_seals_status

		   , ep_request_seals.canceled

		   , ep_request_seals_status.identification

		   ,ep_request_seals.obs

   		   ,ep_request_seals.internal_obs

   		   ,ep_request_seals.number_initial

   		   ,ep_request_seals.number_final

		FROM 

		   ep_request_seals 

		INNER JOIN ep_users ON ( ep_users.pk_user = ep_request_seals.fk_user_request )

		INNER JOIN ep_people ON ( ep_people.pk_person = ep_request_seals.fk_person )

		INNER JOIN ep_seals ON ( ep_seals.pk_seals = ep_request_seals.fk_seals)

		INNER JOIN ep_request_seals_status ON ( ep_request_seals_status.pk_request_seals_status = ep_request_seals.fk_request_seals_status)

		{$where} 

		ORDER BY ep_request_seals.date_request DESC , ep_request_seals.fk_request_seals_status";



	$result = pg_query($conexao, $query);



	while ( $array = pg_fetch_array($result) ) 

	{

		print '<tr class="cinza_claro">';

			print '<td>' . mostraData($array['date_request']) . '</td>';

			print '<td>' . $array['lab_number'] . '</td>';

			print '<td>' . $array['person'] . '</td>';
			
			print '<td>' . $array['user_name'] . '</td>';

			print '<td>' . $array['number_initial'] . ' - ' . $array['number_final'] . '</td>';

			print '<td>' . $array['description'] . '</td>';

			print '<td>' . $array['qtty'] . '</td>';

			print '<td> R$ ' . number_format($array['price'],2, ',', '') . '</td>';

			print '<td> R$ ' . number_format(( $array['qtty'] * $array['price'] ),2, ',', '') . '</td>';

			print '<td>' . ( ( $array['canceled'] == 'f' || $array['canceled'] == 'false' ) ? $array['identification'] : 'Cancelado') . '</td>';

			

			print '<td>' . $array['obs'] . '</td>';



			print '<td>' . $array['internal_obs'] . '</td>';



			if( ( $array['canceled'] == 'f' || $array['canceled'] == 'false' ) )

			{

				print '<td><a href="'.(!empty($samp) ? '/laboratorio' : '').'/selo/alterar/' . $array['pk_request_seals'] . '" class="edit"></a></td>';

			}else

			{

				print '<td><a href="javascript:void(0);" class="edit readonly"></a></td>';			

			}

		print '</tr>';

	}



?>