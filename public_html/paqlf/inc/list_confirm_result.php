<?php 
	
	include_once ('../modal/functions.php');

	require_once ('../modal/conex_bd.php');

	$conexao = conexao();

	$samp = $_GET['samp'];

	$query_samp = "
		SELECT 
		   ep_program_year.pk_program_year
		  ,ep_program_year.number_year
		  ,ep_program_year_steps.number_of_year
		  ,ep_program_year_samp.samp_number
		  ,ep_program_year_samp.pk_program_year_samp
		  ,ep_program_year_steps.send_date
		  ,ep_people_samp.not_send
		  ,ep_program_year_steps.date_initial
		  ,ep_program_year_steps.date_final
		FROM
		  ep_people_samp
		  INNER JOIN ep_program_year_samp ON ( ep_program_year_samp.pk_program_year_samp = ep_people_samp.fk_program_year_samp ) 
		  INNER JOIN ep_program_year_steps ON ( ep_program_year_steps.pk_program_year_steps = ep_program_year_samp.fk_program_year_steps )
		  INNER JOIN ep_program_year      ON ( ep_program_year.pk_program_year = ep_program_year_steps.fk_program_year )
		WHERE
		    ep_people_samp.pk_people_samp = $samp
		  --AND CAST(NOW() as DATE) >= date_initial     
		  --AND CAST(NOW() as DATE) <= date_final
		ORDER BY
		 	ep_program_year_samp.samp_number";

		 	$error_code = fc_test_query( $conexao, $query_samp );

  if( $error_code == '' )
  {

  	$result = pg_query($query_samp);
    $num = pg_num_rows ( $result );
    if( $num < 1 )
    {
      print 'num < 1';
      exit;
    }
	  	while ( $array = pg_fetch_array($result) ) 
	  	{

	        //$query_contract = "SELECT ep_fc_contract_is_ok({$user->getLaboratorio()}, '{$array['date_initial']}', '{$array['date_final']}')";

	        //$error_code_contract = fc_test_query( $conexao, $query_contract );

	        /*if( $error_code_contract == '' )
	        {

	          $result_contract = pg_query( $query_contract );
	          $array_contract = pg_fetch_all($result_contract);
	          if( $array_contract[0]['ep_fc_contract_is_ok'] != 't' && $array_contract[0]['ep_fc_contract_is_ok'] != 'true' )
	          {
	              //header('Location: /resultado');
	          		print 'contrato-fora';
	              exit;
	          }*/
	          $send = $array['not_send'];
	          $v_pk_program_year_samp = $array['pk_program_year_samp'];
	          $v_pk_program_year = $array['pk_program_year'];
	        /*}else
	        {
	          print '<table>';
	          print '<tr class="readonly">';
	            print '<td colspan="9">'. $error_code_contract .'</td>';
	          print '</tr>';
	          print '</table>';
	          exit;
	        }*/

	  }
  }else
  {
    print '<table>';
    print '<tr class="readonly">';
      print '<td colspan="9">'. $error_code .'</td>';
    print '</tr>';
    print '</table>';
  }





	 $query = "SELECT 

			   sub_sel.*

			  ,ep_pa_det_res.report_identif

			  ,ep_pa_det_res.report_abbrev

			  ,ep_pa_det_res.report_technic

			  ,ep_pa_unity.abbrev

			  ,COALESCE(sub_sel.has_valued, false) as has_valued

			FROM

			  (

			    SELECT

			       ep_pa_det_res.pk_pa_det_res 

			      ,case 

			         WHEN COALESCE( ep_people_samp_det.pk_people_samp_det, 0) = 0 THEN ep_pa_det_res.fk_pa_unity_default 

			         ELSE ep_people_samp_det.fk_pa_unity

			       end as fk_pa_unity

			      ,ep_people_samp_det.result

			      ,ep_program_year_det_res.is_mandatory

			      ,ep_pa_det_res.norder

			      ,ep_people_samp_det.has_valued

			      ,ep_people_samp_det.texture_method

			      ,ep_program_year_det_res.decimals_min_max

			    FROM

			    	ep_program_year_det_res

			       INNER JOIN ep_pa_det_res ON ( ep_pa_det_res.pk_pa_det_res = ep_program_year_det_res.fk_pa_det_res )

			       LEFT JOIN ep_people_samp_det ON ( ep_people_samp_det.fk_people_samp = $samp and ep_people_samp_det.fk_pa_det_res = ep_pa_det_res.pk_pa_det_res )

			    WHERE

			    	ep_program_year_det_res.fk_program_year = $v_pk_program_year

       				AND ep_program_year_det_res.is_enabled = true

       				AND ep_people_samp_det.has_valued = true

			    UNION ALL

			    SELECT

			       ep_pa_det_res.pk_pa_det_res 

			      ,case 

			         WHEN COALESCE( ep_people_samp_det.pk_people_samp_det, 0) = 0 THEN ep_pa_det_res.fk_pa_unity_default 

			         ELSE ep_people_samp_det.fk_pa_unity

			       end as fk_pa_unity

			      ,ep_people_samp_det.result

			      ,ep_program_year_det_res.is_mandatory

			      ,ep_pa_det_res.norder

			      ,ep_people_samp_det.has_valued

			      ,ep_people_samp_det.texture_method

			      ,ep_program_year_det_res.decimals_min_max

			    FROM

			       ep_program_year_det_res

			       INNER JOIN ep_pa_det_res ON ( ep_pa_det_res.pk_pa_det_res = ep_program_year_det_res.fk_pa_det_res )

			       INNER JOIN ep_people_samp_det ON ( ep_people_samp_det.fk_people_samp = $samp and ep_people_samp_det.fk_pa_det_res = ep_pa_det_res.pk_pa_det_res )



			    WHERE

			       ep_program_year_det_res.fk_program_year = $v_pk_program_year

       				AND ep_program_year_det_res.is_enabled = false

       				AND ep_people_samp_det.has_valued = true

			   ) as sub_sel

			   INNER JOIN ep_pa_det_res ON ( ep_pa_det_res.pk_pa_det_res = sub_sel.pk_pa_det_res )

			   INNER JOIN ep_pa_unity ON ( ep_pa_unity.pk_pa_unity = sub_sel.fk_pa_unity )

			ORDER BY 

			   norder";




	$error_code = fc_test_query( $conexao, $query );


?>

	<table>
		<tr class="cinza_escuro" height="30">
			<td colspan="4">
				<label><center><b>Conferencia dos Valores Informados</b></center></label>
			</td>
		</tr>

		<tr class="cinza_escuro">
			<td><label><b>Parâmetro</b></label></td>
			<td><label><b>Método</b></label></td>
			<td><label><b>Resultado</b></label></td>
			<td><label><b>Unidade</b></label></td>
		</tr>
<?php 

	if( $error_code == '' )

	{

		$result = pg_query($query);
		$int = 0;
		while ( $array = pg_fetch_array($result) ) 

		{
			$int++;

?>
	

		<tr>
			<td>
				<label><?php print $array['report_abbrev']; ?></label>
			</td>
			<td>
				<?php

					if( $array['pk_pa_det_res'] == 183 || $array['pk_pa_det_res'] == 182 || $array['pk_pa_det_res'] == 180 )

					{
						if( $array['texture_method'] == 0 )
						{
							print '<label>Não definido</label>';
						}else if( $array['texture_method'] == 1 )
						{
							print '<label>Pipeta</label>';
						}else if( $array['texture_method'] == 2 )
						{
							print '<label>Densímetro</label>';
						}
					}else
					{
						print '<label>' . ( $array['report_technic'] ? $array['report_technic'] : '-' ) . '</label>';
					}
				?>
			</td>
			<td>
				<?php print '<label>' . number_format($array['result'],$array['decimals_min_max'], ',', '') . '</label>'; ?>
			</td>
			<td>
				<?php print '<label>' . ( trim($array['abbrev']) != '' ? $array['abbrev'] : ' - ' ) . '</label>';  ?>
			</td>
		</tr>


		


<?php

		}

	}else

	{

		print '<tr class="readonly">';

			print '<td colspan="2">'. $error_code .'</td>';

		print '</tr>';

	}

?>
	<tr >
		<td align="right" colspan="5" style="border:none;" bgcolor="#F2F2F2">


			<button type="button" class="box_ok">OK</button>

		</td>

	</tr>

</table>
