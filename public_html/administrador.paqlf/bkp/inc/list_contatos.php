<?php 
	include_once ('../modal/functions.php');
	require_once ('../modal/conex_bd.php');
	$conexao = conexao();

	$query = "SELECT 
				  ep_people_contacts.pk_person_contacts
				  , ep_people_contacts.contact
				  , ep_people_contacts.office
				  , ep_people_contacts.departament
				  , ep_people_contacts.phone
				  , ep_people_contacts.cellular
				  , ep_people_contacts.e_mail
				  , ep_people.person  
				FROM 
				  ep_people_contacts 
				  INNER JOIN ep_people ON ( ep_people.pk_person = ep_people_contacts.fk_person) 
				WHERE 
				  fk_person = " . $_GET['samp'];

	$result = pg_query($query);
	$int = 0;
	while ( $array = pg_fetch_array($result) ) 
	{
		$int++;
		print '<tr '.( $int%2 != 0 ? 'class="cinza_claro"' : '') .'>';
			print '<td>' . $array['person'] . '</td>';
			print '<td>' . $array['contact'] . '</td>';
			print '<td>' . $array['office'] . '</td>';
			print '<td>' . $array['departament'] . '</td>';
			print '<td>' . $array['phone'] . '</td>';
			print '<td>' . $array['cellular'] . '</td>';
			print '<td>' . $array['e_mail'] . '</td>';
			print '<td width="50"><a href="/laboratorio/contato/alterar/' . $array['pk_person_contacts'] . '" class="edit"></a></td>';
			print '<td width="50"><a href="javascript:void(0);" data-id="' . $array['pk_person_contacts'] . '" data-rel="' . $_GET['samp'] . '" class="excluir"></a></td>';
		print '</tr>';
	}
?>