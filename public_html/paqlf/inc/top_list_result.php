<?php 
	include ('../modal/functions.php');
	require ('../modal/conex_bd.php');
	$conexao = conexao();

	$query = "SELECT 
   ep_program_year.pk_program_year
  ,ep_program_year.number_year
  ,ep_program_year_steps.number_of_year
  ,ep_program_year_samp.samp_number
  ,ep_program_year_samp.pk_program_year_samp
  ,ep_program_year_steps.send_date
  ,ep_people_samp.not_send
  ,ep_program_year_steps.date_initial
  ,ep_program_year_steps.date_final
  ,ep_people_samp.serial_number
FROM
  ep_people_samp
  INNER JOIN ep_program_year_samp ON ( ep_program_year_samp.pk_program_year_samp = ep_people_samp.fk_program_year_samp ) 
  INNER JOIN ep_program_year_steps ON ( ep_program_year_steps.pk_program_year_steps = ep_program_year_samp.fk_program_year_steps )
  INNER JOIN ep_program_year      ON ( ep_program_year.pk_program_year = ep_program_year_steps.fk_program_year )
WHERE
    ep_people_samp.pk_people_samp = $samp
  AND CAST(NOW() as DATE) >= date_initial     
  AND CAST(NOW() as DATE) <= date_final
ORDER BY
  ep_program_year_samp.samp_number";


  $error_code = fc_test_query( $conexao, $query );

  if( $error_code == '' )
  {

  	$result = pg_query($query);
    $num = pg_num_rows ( $result );
    if( $num < 1 )
    {
      header('Location: /resultado');
      exit;
    }
  	while ( $array = pg_fetch_array($result) ) 
  	{

        $query_contract = "SELECT ep_fc_contract_is_ok({$user->getLaboratorio()}, '{$array['date_initial']}', '{$array['date_final']}')";

        $error_code_contract = fc_test_query( $conexao, $query_contract );

        if( $error_code_contract == '' )
        {

          $result_contract = pg_query( $query_contract );
          $array_contract = pg_fetch_all($result_contract);
          if( $array_contract[0]['ep_fc_contract_is_ok'] != 't' && $array_contract[0]['ep_fc_contract_is_ok'] != 'true' )
          {
              header('Location: /resultado');
              exit;
          }
          $send = $array['not_send'];
          $v_pk_program_year_samp = $array['pk_program_year_samp'];
          $v_pk_program_year = $array['pk_program_year'];
        }else
        {
          print '<table>';
          print '<tr class="readonly">';
            print '<td colspan="9">'. $error_code_contract .'</td>';
          print '</tr>';
          print '</table>';
          exit;
        }
?>
    <table>
    	<tr class="cinza_escuro">
    		<td><b>Ano:</b> <?php print $array['number_year']; ?></td>
        <td><b>Remessa:</b> <?php print $array['number_of_year']; ?></td>
    		<td><b>Número da Amostra:</b> <?php print $array['samp_number'].'/'.$array['number_year']; ?></td>
        <td><b>Prazo de Envio: <span class="prazo"><?php print mostraData($array['date_final']); ?></span></b></td>
    	</tr>

      <!--
	  <tr>
        <td><label>Série*</label></td>
        <td>
          <input type="text" class="masked" data-id="0" data-thousands="" data-decimal="," maxlength="5" onpaste="return false;" name="serial_number" tabindex="<?php print $int; ?>" value="<?php print $array['serial_number']; ?>">
        </td>
      </tr>
	  -->

    </table>
<?php
	 }
  }else
  {
    print '<table>';
    print '<tr class="readonly">';
      print '<td colspan="9">'. $error_code .'</td>';
    print '</tr>';
    print '</table>';
  }
?>