<?php 
	require_once ('../modal/acessos.php'); 
	include_once ('../modal/functions.php');

	require_once ('../modal/conex_bd.php');

	$conexao = conexao();



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

			   ) as sub_sel

			   INNER JOIN ep_pa_det_res ON ( ep_pa_det_res.pk_pa_det_res = sub_sel.pk_pa_det_res )

			   INNER JOIN ep_pa_unity ON ( ep_pa_unity.pk_pa_unity = sub_sel.fk_pa_unity )

			ORDER BY 

			   norder";




	$error_code = fc_test_query( $conexao, $query );



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

				<input type="hidden" value="<?php print $samp; //people_samp ?>" name="<?php print $array['pk_pa_det_res']; ?>[samp]"> 

				<input type="hidden" value="<?php print $array['pk_pa_det_res']; ?>" name="<?php print $array['pk_pa_det_res']; ?>[report]"> 

				

				<label><?php print $array['report_abbrev']; ?></label>

			</td>

			<td>

				<?php

					if( $array['pk_pa_det_res'] == 183 || $array['pk_pa_det_res'] == 182 || $array['pk_pa_det_res'] == 180 )

					{

						print '<select name="' . $array['pk_pa_det_res'] .'[technic]" class="technic">';

							print '<option value="0" '.( $array['texture_method'] == 0 ? 'selected' : '' ).'>Não definido</option>';

							print '<option value="1" '.( $array['texture_method'] == 1 ? 'selected' : '' ).'>Pipeta</option>';

							print '<option value="2" '.( $array['texture_method'] == 2 ? 'selected' : '' ).'>Densímetro</option>';

						print '</select>';

					}else

					{

						print '<label>' . ( $array['report_technic'] ? $array['report_technic'] : '-' ) . '</label>';

					}

				?>

				



			</td>

			<td><input type="text" class="masked" data-id="<?php print $array['decimals_min_max']; ?>" data-thousands="" data-decimal="," maxlength="9" onpaste="return false;" name="<?php print $array['pk_pa_det_res']; ?>[resultado]" tabindex="<?php print $int; ?>" value="<?php print number_format($array['result'],$array['decimals_min_max'], ',', ''); ?>"></td>

			<td>

				<input type="hidden" value="<?php print $array['fk_pa_unity']; ?>" name="<?php print $array['pk_pa_det_res']; ?>[unidade]">

				<input type="text" readonly class="readonly" value="<?php print ( trim($array['abbrev']) != '' ? $array['abbrev'] : ' - ' ) ; ?>">

			</td>

			<td class="border">

				<input type="checkbox" id="<?php print $array['pk_pa_det_res']; ?>[mandatory]" name="<?php print $array['pk_pa_det_res']; ?>[mandatory]" <?php print $array['has_valued'] == 't' || $array['is_mandatory'] == 't' || $array['is_mandatory'] == 'true' ? 'checked' : '';  print $array['is_mandatory'] == 'f' ? '' : 'readonly'; ?> value="true"> 



				<label for="<?php print $array['pk_pa_det_res']; ?>[mandatory]" class="<?php print $array['is_mandatory'] == 'f' ? '' : 'readonly'; print $array['has_valued'] == 't' || $array['is_mandatory'] == 't' || $array['is_mandatory'] == 'true' ? ' checked' : ' check'; ?>"></label>

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