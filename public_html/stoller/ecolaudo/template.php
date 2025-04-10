<?php 
	include_once 'model/conexao_bd.php';
	$conexao = conexao();
	require_once 'controller/login_autenticador.php';
	require_once 'controller/login_sessao.php';
	require_once 'controller/login_usuario.php';
	session_start();
	
	$aut = Autenticador::instanciar();
	// Verificando login do usuÃ¡rio //
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}else 
	{
		$aut->expulsar();
	}


	$query = "
				select 
				  sf_amostras_recomendacoes.id
				  , sf_cultures.identification as cultura
				  , sf_amostras_recomendacoes.producaodesejada::text || ' ' || sf_amostras_recomendacoes.unidadeproducao as producao
				  , sf_amostras_recomendacoes.esprua::text || ' x ' || sf_amostras_recomendacoes.espcova::text || ' ' || sf_amostras_recomendacoes.unidadeespacamento as espacamento
				  , case 
				      when sf_amostras_recomendacoes.cr_classeresposta1 = 0 then
						'Alta'
				      when sf_amostras_recomendacoes.cr_classeresposta1 = 1 then
				        'Média'
				      when sf_amostras_recomendacoes.cr_classeresposta1 = 2 then
						'Baixa'
				      else
						''
				    end as classeresposta
				  ,sf_fc_get_recomendation(". $_POST['rec_id'] . " ) as html
				  , sf_amostras_recomendacoes.cu_tecnologia
				  , sf_amostras_recomendacoes.cu_cultura
				  , sf_amostras_recomendacoes.cu_versao
				  , sf_amostras_recomendacoes.af_amostra
				  , sf_amostras_recomendacoes.info_add 
				  ,sf_amostras_recomendacoes.laboratorio
				  ,sf_amostras_recomendacoes.amostra
				  ,sf_amostras_recomendacoes.ano
				  ,sf_amostras_recomendacoes.recomendacao
				  , sf_cultures.color_step
				  , sf_cultures.color_culture
				  , sf_cultures.color_soil
				  , sf_cultures.color_leave
				  , sf_cultures.prefix_pic
				from 
				  sf_amostras_recomendacoes
				  inner join sf_cultures on ( sf_cultures.id_sf_tecnologia = sf_amostras_recomendacoes.cu_tecnologia and sf_cultures.id_sf_cultura = sf_amostras_recomendacoes.cu_cultura and sf_cultures.id_sf_versao = sf_amostras_recomendacoes.cu_versao )
				where 
				      sf_amostras_recomendacoes.laboratorio = 1
				  and sf_amostras_recomendacoes.id = ". $_POST['rec_id'] . "
				  and sf_amostras_recomendacoes.amostra = ". $_POST['pk_samp_service'] . "
				  and sf_amostras_recomendacoes.ano = " . $usuario->getId();

		$result = pg_query($conexao, $query);
		$array = pg_fetch_assoc($result);












		function hex2rgb($hex) {
		   $hex = str_replace("#", "", $hex);

		   if(strlen($hex) == 3) {
		      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		   } else {
		      $r = hexdec(substr($hex,0,2));
		      $g = hexdec(substr($hex,2,2));
		      $b = hexdec(substr($hex,4,2));
		   }
		   $rgb = array($r, $g, $b);
		   //return implode(",", $rgb); // returns the rgb values separated by commas
		   return $rgb; // returns an array with the rgb values
		}

		function rgb2hex($rgb) {
		   $hex = "#";
		   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
		   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
		   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

		   return $hex; // returns the hex value including the number sign (#)
		}


		//print_r( hex2rgb($array['color_soil']));
		$hex = hex2rgb($array['color_leave']);

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Lab.Online - Amostras</title>
	<meta http-equiv="content-language" content="PT-br"/>
	<meta http-equiv="X-UA-Compatible" content="IE=9;IE=10;IE=11;IE=Edge;" />
	<link rel="stylesheet" type="text/css" href="/ecolaudo/plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	<link rel="stylesheet" type="text/css" href="/ecolaudo/css/template.css">
	
	
	<style type="text/css">
		.recomendacao_culturas{ background-color: <?php print $array['color_soil']; ?>; }
		.recomendacao_culturas td{ border: 1px solid #f7f4fd !important;  }
		.recomendacao_culturas .solo{ background: <?php print $array['color_soil']; ?>; }
		.recomendacao_culturas .folha{ background: <?php print $array['color_leave']; ?>; }
		.recomendacao_culturas .estagios{ background: <?php print $array['color_step']; ?>; }
		.recomendacao_culturas .cultura{ background: <?php print $array['color_culture']; ?>; }

		.aplicacoes .color_solo{ background: <?php print $array['color_soil']; ?>; }
		.aplicacoes .color_folha{ background: <?php print $array['color_leave']; ?>; }
	</style>

	<script type="text/javascript" src="/ecolaudo/js/template.js"></script>
</head>
<body>
	<div class="modal"></div>

	<div class="box_alert fonte_padrao">
     	<p>&nbsp;</p>
    </div> 
    

    <div id="conteudo">
    	<div class="informacoes">
    		<input type="hidden" name="amostra" value="<?php print $_POST['pk_samp_service']; ?>">
    		<input type="hidden" name="id" value="<?php print $array['id']; ?>">
    		<input type="hidden" name="recall" value="<?php print $_POST['last_url']; ?>">
			<table>
				<tr>
					<td><label>Cultura: </label><?php print $array['cultura']; ?></td>			
					<td><label> </label><?php print ( $array['classeresposta'] ? 'Classe Resposta de N: ' . $array['classeresposta'] : ''); ?></td>
					<td>

						
					</td>
				</tr>
				<tr>
					<td><label>Espaçamento: </label><?php print str_replace('.', ',', $array['espacamento']); ?></td>
					<td><label>Produção Esperada: </label><?php print str_replace('.', ',', $array['producao']); ?></td>
					<td align="right">
						<a href="javascript:void(0)" title="Retornar" class="links pre_cancelar"></a>

						<span></span>
						<a href="javascript:void(0)" data-id="<?php print $_POST['pk_samp_service']; ?>" class="links pre_visualizar" title="Salvar e Visualizar"></a>
						<span></span>

						<a href="javascript:void(0)" data-id="<?php print $_POST['pk_samp_service']; ?>" class="links pre_close" title="Excluir"></a>

						
						<a href="javascript:void(0)" data-id="<?php print $_POST['pk_samp_service']; ?>" title="Salvar" class="links pre_salvar"></a>

						<?php
							if( $usuario->getId() == 1 )
							{
								print '<a href="javascript:void(0)" title="Texto" class="links abrir_texto"></a>';		
							}
						 ?>						
					</td>
				</tr>
			</table>
		</div>
		

		<?php 

			//-- 0 muito baixo --
			//-- 1 baixo --
			//-- 2 adequado --
			//-- 3 alto  --
			//-- 4 muito alto --




			$query_solo = "
			SELECT
			   sub_sel.value
			  ,sub_sel.sub_sel_faixa
			  ,sub_sel.sub_sel_avaliacao
			  ,sub_sel.report_abbrev 
			  ,sub_sel.abbrev
			  
			FROM
			  (
			    SELECT 
			      sf_samp_service_det.fk_pa_det_res
			     ,sf_samp_service_det.ro_result_report as value 
			     ,sf_samp_service_det.norder
			     ,sf_samp_service_det.pk_samp_service_det
			     ,sf_pa_det_res.report_abbrev 
			     ,sf_pa_unity.abbrev
			     ,( select 
			          faixa 
			        from 
			          sf_fc_get_evaluation_det_res ( 
			            sf_samp_service_det.pk_samp_service_det 
			        ,(coalesce(sf_pa_det_res.fk_lab_type, 1) -1 )
			        ,sf_amostras_recomendacoes.cu_tecnologia 
			        ,sf_amostras_recomendacoes.cu_cultura 
			        ,sf_amostras_recomendacoes.cu_versao 
			            ,false 
			           ) 
			      ) as sub_sel_faixa 
			      ,( select 
			           avaliacao 
			         from 
			           sf_fc_get_evaluation_det_res ( 
			             sf_samp_service_det.pk_samp_service_det 
			        ,(coalesce(sf_pa_det_res.fk_lab_type, 1) -1 )
			        ,sf_amostras_recomendacoes.cu_tecnologia 
			        ,sf_amostras_recomendacoes.cu_cultura 
			        ,sf_amostras_recomendacoes.cu_versao 
			        ,false 
			           ) 
			       ) as sub_sel_avaliacao 
			    FROM 
			      sf_amostras_recomendacoes
			      INNER JOIN sf_samp_service_det       ON ( sf_samp_service_det.fk_samp_service     = sf_amostras_recomendacoes.amostra )
			      INNER JOIN sf_pa_det_res             ON ( sf_pa_det_res.pk_pa_det_res             = sf_samp_service_det.fk_pa_det_res ) 
			      INNER JOIN sf_pa_unity               ON ( sf_pa_unity.pk_pa_unity                 = sf_samp_service_det.ro_fk_pa_unity )
			    WHERE 
			      sf_amostras_recomendacoes.id = ". $_POST['rec_id'] . "
			  ) as sub_sel
			ORDER BY 
			   sub_sel.norder 
			  ,pk_samp_service_det";

			$result_solo = pg_query($conexao, $query_solo);

			/*$query_resumo = "
				SELECT
				    sf_recomendacoes.determinacao
				   ,sf_fc_arround_qtty(
				      COALESCE(sf_Recomendacoes.QtdeRecomendada         , 0) -
				      COALESCE(sf_Recomendacoes.QtdeTransferida         , 0) +
				      COALESCE(sf_Recomendacoes.QtdeVeioTransferencia   , 0) 
				    ) as qtde
				   ,pratica
				   ,sub_pratica
				   ,sf_tecnologias_praticas.titulo
				   ,sf_recomendacoes.unidadeapresentacao 
				FROM
				    sf_amostras_recomendacoes
				    INNER JOIN sf_recomendacoes ON (     sf_recomendacoes.Laboratorio   = sf_amostras_recomendacoes.Laboratorio 
				                                     AND sf_recomendacoes.Amostra       = sf_amostras_recomendacoes.Amostra     
				                                     AND sf_recomendacoes.Ano           = sf_amostras_recomendacoes.Ano         
				                                     AND sf_recomendacoes.Recomendacao  = sf_amostras_recomendacoes.Recomendacao )
				    LEFT JOIN sf_tecnologias_praticas ON ( sf_tecnologias_praticas.codigo = sf_recomendacoes.pratica )
				WHERE
				        ( sf_amostras_recomendacoes.id     = ". $_POST['rec_id'] . "         )
				    AND ( sf_Recomendacoes.Cancelar        = false     )
				    AND ( sf_recomendacoes.cancelar_user   = false     )
				    AND NOT ( EXISTS( SELECT true FROM sf_det_ocultar WHERE sf_det_ocultar.determinacao = sf_Recomendacoes.determinacao ) )  
				    AND ( COALESCE(sf_Recomendacoes.QtdeRecomendada         , 0) -
				          COALESCE(sf_Recomendacoes.QtdeTransferida         , 0) +
				          COALESCE(sf_Recomendacoes.QtdeVeioTransferencia   , 0) > 0 )

				ORDER BY
				    sf_recomendacoes.OrdemPratica
				   ,sf_recomendacoes.Sub_Pratica
				   ,sf_recomendacoes.OrdemDeterminacao";*/

				   	// ,sf_amostras_recomendacoes.laboratorio
				  //,sf_amostras_recomendacoes.amostra
				  //,sf_amostras_recomendacoes.ano
				  //,sf_amostras_recomendacoes.recomendacao

			$query_resumo = "
				SELECT
				  o_aplicacao
				  ,o_determinacao_nome
				  ,sf_fc_arround_qtty(qtty_elementos) as qtty_elementos
				  ,sf_fc_arround_qtty(qttt_from_insumos) as qtty_from_insumos
				  ,o_unidade
				FROM
				(

				SELECT
				     o_aplicacao
				    ,o_determinacao_nome
				    ,SUM(o_qtty_from_elementos) as qtty_elementos
				    ,sum(o_qtty_from_insumos ) as qttt_from_insumos
				    ,o_unidade
				FROM
				   (
					SELECT 
					    *
				        FROM
					    sf_fc_get_nutrientes_from_rec (" . $array['laboratorio'] . "," . $array['amostra'] . "," . $array['ano'] . "," . $array['recomendacao'] . ")
				  ) as sub_sel
				GROUP BY
				  o_ordem_aplicacao
				  ,o_ordem_determinacao
				  ,o_aplicacao
				  ,o_determinacao_nome
				  ,o_unidade
				ORDER BY
				   o_ordem_aplicacao
				  ,o_ordem_determinacao
				  ,o_determinacao_nome ) as sel_arround			   
			";

			$result_resumo = @pg_query( $conexao, $query_resumo);
			$num_rows_resumo = @pg_num_rows($result_resumo);
		?>			

		<div class="resultados">  
			<p>Informações Adicionais</p>
			<div class="listagem">
				<?php 

					if( $num_rows_resumo > 0 )
					{
						print '<a href="javascript:void(0);" id="menu_recomendacao" class="selected">Recomendação</a>';
						print '<a href="javascript:void(0);" id="menu_solo">Solo</a>';
					}else
					{
						//print '<a href="javascript:void(0);" id="menu_recomendacao">Recomendação</a>';
						print '<a href="javascript:void(0);" id="menu_solo" class="selected">Solo</a>';
					}
				?>
				<!-- <a href="javascript:void(0);" id="menu_recomendacao" class="selected">Recomendação</a>
				<a href="javascript:void(0);" id="menu_solo">Solo</a>				 -->
			</div>


			
			<table class="table_solo">
				<thead>				
					<tr>	
						<td colspan="3">
							<div>Parâmetro</div>
							<div>Resultado</div>
							<div>Avaliação</div>
						</td>
					</tr>
				</thead>
				<tbody>
					<?php 
						while ( $array_solo = pg_fetch_array($result_solo) ) 
						{
							print '<tr>';
								print '<td>' . $array_solo['report_abbrev'] . '</td>';
								print '<td>' . $array_solo['value'] . ' ' . ($array_solo['abbrev'] != '-' ? $array_solo['abbrev'] : '') . '</td>';
								print '<td>';
									if( $array_solo['sub_sel_faixa'] == 0 )
									{
										//-- 0 muito baixo -- 
										$color = '#a41623';
									}else if( $array_solo['sub_sel_faixa'] == 1 )
									{
										//-- 1 baixo -- 
										$color = '#ee1d23';
									}else if( $array_solo['sub_sel_faixa'] == 2 )
									{
										//-- 2 adequado -- 	
										$color = '#8bc63e';
									}else if( $array_solo['sub_sel_faixa'] == 3 )
									{
										//-- 3 alto  -- 
										$color = '#0080ff';
									}else
									{
										//-- 4 muito alto -- 
										$color = '#010197';
									}
									if( $array_solo['sub_sel_avaliacao'] >= 0 )
									{
										print '<div style="width: ' . $array_solo['sub_sel_avaliacao'] . '%; height:10px; background:' . $color . '; display:inline-block; "></div>';
									}
								print '</td>';
							print '</tr>';
						}

					?>
				</tbody>
			</table>

			<?php 
				if( $num_rows_resumo > 0 )
				{
				
			?>
			<table class="table_folha">
				<thead>				
					<tr>	
						<td>
							<div>Aplicação</div>
						</td>
						<td>
							<div>Nutriente</div>
						</td>
						<td>
							<div>N. Planta</div>
						</td>
						<td>
							<div>F. Insumo</div>
						</td>
						<td>
							<div>Unidade</div>
						</td>
					</tr>
				</thead>
				<tbody>
					<?php 
						$pratica = '';
						while ( $array_resumo = pg_fetch_array($result_resumo) ) 
						{ 
							if( $pratica != $array_resumo['pratica'] )
							{
								$pratica = $array_resumo['pratica'];
								
									/*print '<tr class="sub_title">';
										print '<td colspan="2">';
											print $array_resumo['titulo'];
											print 'oiiii ';
										print '</td>';
									print '</tr>';*/
							}
			
							print '<tr>';
								print '<td>' . $array_resumo['o_aplicacao'] . '</td>';
								print '<td>' . $array_resumo['o_determinacao_nome'] . '</td>';
								print '<td>' . $array_resumo['qtty_elementos']  . '</td>';
								print '<td>' . $array_resumo['qtty_from_insumos'] . '</td>';
								print '<td>' . $array_resumo['o_unidade'] . '</td>';
							print '</tr>';
						 } 
					?>
					
				</tbody>
			</table>
			<?php } ?>
		</div>
		
		<!-- <div class="oculto">
			<?php //print $array['html'] ; ?>
		</div> -->

		<div class="adjoined-bottom">
			<div class="grid-container">
				<div class="grid-width-100">
					<div id="editor">
						<?php print $array['html']; ?>
					</div>
				</div>
			</div>
		</div>			
		
		<script>
			initSample();
		</script>		
	</div>



	
</body>
</html>

