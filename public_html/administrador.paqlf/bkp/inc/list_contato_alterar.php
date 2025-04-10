<?php 

	require ('../modal/functions.php');

	//require ('../modal/acessos.php');

	require ('../modal/conex_bd.php');

	$conexao = conexao();



	$query = "SELECT 

				    ep_people_contacts.pk_person_contacts

				  , ep_people_contacts.fk_person

				  , ep_people_contacts.contact

				  , ep_people_contacts.office

				  , ep_people_contacts.departament

				  , ep_people_contacts.phone

				  , ep_people_contacts.cellular

				  , ep_people_contacts.e_mail

				  , ep_people_contacts.inf_addic 

				FROM 

				  ep_people_contacts 

				  INNER JOIN ep_people ON ( ep_people.pk_person = ep_people_contacts.fk_person) 

				WHERE 

				  pk_person_contacts = " . $_GET['samp'];



	$result = pg_query($conexao, $query);	

	while ( $array = pg_fetch_array($result) ) 

	{ 

?>



	<tr>

		<td width="135"><label class="lab_primeiro">Nome</label></td>

		<td><input type="text" maxlength="90" name="nome" value="<?php print $array['contact']; ?>"></td>

	</tr>

	<tr>

		<td width="135"><label class="lab_primeiro">Escritório</label></td>

		<td><input type="text" maxlength="90" name="escritorio" value="<?php print $array['office']; ?>"></td>

	</tr>

	<tr>

		<td width="135"><label class="lab_primeiro">Departamento</label></td>

		<td><input type="text" maxlength="90" name="departamento" value="<?php print $array['departament']; ?>"></td>

	</tr>

	<tr>

		<td width="135"><label class="lab_primeiro">Telefone</label></td>

		<td><input type="text" maxlength="90" name="telefone" value="<?php print $array['phone']; ?>"></td>

	</tr>

	<tr>

		<td width="135"><label class="lab_primeiro">Celular</label></td>

		<td><input type="text" maxlength="90" name="celular" value="<?php print $array['cellular']; ?>"></td>

	</tr>

	<tr>

		<td width="135"><label class="lab_primeiro">Email</label></td>

		<td><input type="text" maxlength="140" name="email" value="<?php print $array['e_mail']; ?>"></td>

	</tr>

	<tr>

		<td width="135" valign="top"><label class="lab_primeiro">Informações Adicionais</label></td>

		<td><textarea name="informacoes" maxlength="190"> <?php print $array['inf_addic']; ?></textarea></td>

	</tr>

	<tr>

		<td colspan="2">

			<input type="hidden" name="contato" value="<?php print $array['pk_person_contacts']; ?>">

			<input type="hidden" name="lab_on" class="lab_on" value="<?php print $array['fk_person']; ?>">

			<a href="/laboratorio/contato/<?php print $array['fk_person']; ?>" class="cancelar">CANCELAR</a>

			<button type="button">SALVAR</button>

		</td>

	</tr>



<?php } ?>