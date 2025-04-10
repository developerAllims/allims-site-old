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

	function mostraData ($data) {
        if ($data!='') {
           return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4));
        }
        else { return ''; }
    }


	$query = "
			select 
				  sf_cultures.identification as cultura
				  , sf_amostras_recomendacoes.producaodesejada::text || ' ' || sf_amostras_recomendacoes.unidadeproducao as producao
				  , sf_amostras_recomendacoes.esprua::text || ' x ' || sf_amostras_recomendacoes.espcova::text || ' ' || sf_amostras_recomendacoes.unidadeespacamento as espacamento
				  , case 
				      when sf_amostras_recomendacoes.cr_classeresposta1 = 0 then
					'Alta'
				      when sf_amostras_recomendacoes.cr_classeresposta1 = 1 then
				        'Media'
				      when sf_amostras_recomendacoes.cr_classeresposta1 = 2 then
					'Baixa'
				      else
					'-'
				    end as classeresposta
				  ,sf_fc_get_recomendation(". $_GET['rec_id'] . " ) as html
				  , sf_amostras_recomendacoes.cu_tecnologia
				  , sf_amostras_recomendacoes.cu_cultura
				  , sf_amostras_recomendacoes.cu_versao
				  , sf_amostras_recomendacoes.af_amostra
				  , sf_amostras_recomendacoes.info_add 
				  , sf_amostras_recomendacoes.producaoanterior::text || ' ' || sf_amostras_recomendacoes.unidadeproducao as producao_anterior
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
				  and sf_amostras_recomendacoes.id = ". $_GET['rec_id'] . "
				  and sf_amostras_recomendacoes.amostra = ". $_GET['pk_samp_service'] . "
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
	<title>Laudo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="/ecolaudo/css/fonts.css">
	<style type="text/css">
		.table_modal{ width: 197mm; height: auto; margin: 0 auto; font-family: 'helvetica_condensedregular';  display: block; background: #FFF; padding: 10pt 20pt;}
		/*{/* border: 1px solid #000; padding: 20mm 20mm 25mm 25mm; background: #FFF }*/

		.bloco{ width: 100%; display: table; font-family: 'helvetica_condensedregular'; }
		
		.table_laudo{ width: 100%; /*border: 1px solid #F00;*/ color:#404041; }
		.table_laudo tr{ height: 15pt; }
		.table_laudo tr td{ font-size:8pt; color:#404041; border-bottom: 1px solid #404041; }
		.logo tr td{ border-bottom: none !important; }
		.logo .codigo_barras{ width: 158pt; height: 25pt; line-height: 35pt; margin: 5pt; }
		.logo .codigo_barras iframe{ width: 158pt; height: 30pt; display: inline-block; border: 0px solid #000; overflow: hidden; }

		.subtitle{ font-size:13pt !important; font-weight: 500; border-bottom: 2px solid #323639 !important; }

		.codigo{ width: 128pt; /*height: 250pt;*/ display: inline-block; margin: 1pt 0 0 0;  /*vertical-align: top; border: 1px solid #F00;*/ }
		.codigo img{ width: auto; max-width: 128pt; height: auto; max-height: 100pt; }
		.codigo td{ border: none !important; }
		
		.cabecalho{ width: 100%; /*height: 250px;*/ float: left; }
		.cabecalho span{ color: #a0a0a0; }
		.cabecalho img{ height: 100px; }


		.grafico{ width: auto; margin: 5pt auto 0 auto;  display: table; }
		.grafico .coluna{ width: 20pt; float: left;  }
		.grafico .coluna.medidas{ width: 55pt; margin-right: 5pt; font-size: 10pt; }
		.grafico .medidas .celula{ height: 20px; text-align: right !important; }
		.grafico .celula{ text-align: center; }
		.grafico .celula.border{ border-left: 1px solid #D1D2D4; display:block; }
		.grafico .celula.border p{ margin:0; padding: 2px 0 0 0; }
		.grafico .celula .valor{ font-size: 9pt;  border-top: 1px solid #D1D2D4; color: #323639; font-weight: bold; }
		.grafico .celula .elemento{ font-size: 7pt; height: auto; vertical-align: middle; color: #a0a0a0; }
		.grafico .celula .unidade{ font-size: 6pt; height: auto; vertical-align: middle; color: #a0a0a0; }
		.grafico .celula.square{ height:100px; background: url(/ecolaudo/imagens/fundo_nivel.png) top center repeat-x; }

		

		.recomendacao_culturas{ width: 100%;  font-size: 8pt; background: url('/ecolaudo/imagens/rodape_terra_estagios.png') center bottom repeat-x; border: none !important;}
		.recomendacao_culturas td{ padding: 10px 0; text-align: center; vertical-align: middle; } 
		.recomendacao_culturas .rodape td{ border: none !important; }
		.recomendacao_culturas .estagios{ font-size: 10pt; color: #FFF; font-weight: 500; }
		.recomendacao_culturas .cultura{ font-size: 10pt; color: #FFF; font-weight: 600; }
		.recomendacao_culturas p{ font-size: 12pt; font-weight: bold; margin: 5px 0; padding: 0; display: block; color: #212C5A; }
		.recomendacao_culturas p.mila span{ color: #8C7865; }
		.recomendacao_culturas p.vita span{ color: #3194C9;  }
		.recomendacao_culturas p.bela span{ color: #F2B35D;  }


		.recomendacao_culturas{ background-color: <?php print $array['color_soil']; ?>; }
		.recomendacao_culturas td{ border: 1px solid #f7f4fd !important;  }
		.recomendacao_culturas .solo{ background: <?php print $array['color_soil']; ?>; }
		.recomendacao_culturas .folha{ background: <?php print $array['color_leave']; ?>; }
		.recomendacao_culturas .estagios{ background: <?php print $array['color_step']; ?>; }
		.recomendacoa_culturas .estagios td{ padding: 0 5px; }
		.recomendacao_culturas .cultura{ background: <?php print $array['color_culture']; ?>; }

		.aplicacoes .color_solo{ background: <?php print $array['color_soil']; ?>; }
		.aplicacoes .color_folha{ background: <?php print $array['color_leave']; ?>; }
	

		.aplicacoes{ margin-top: 5px;  }
		.aplicacoes p{ margin: 3px 5px 0 0; padding: 0; font-size: 7pt; line-height: 15px; display: inline-block; }
		.aplicacoes img{ margin-right: 3px; }
		.aplicacoes .color_solo{ width: 15px; height: 7px; display: inline-block; }
		.aplicacoes .color_folha{ width: 15px; height: 7px; display: inline-block; }


		.impressao{ width: 100%; height: 30px; background: #323639; text-align: right; }
		.impressao .imprimir_iframe{ width: 20px; height: 20px; margin: 5px; display: inline-block; background: url('/ecolaudo/imagens/ico_print.png'); }
		.impressao .fechar_iframe{ width: 20px; height: 20px; margin: 5px; display: inline-block; background: url('/ecolaudo/imagens/ico_close_branco.png'); }
		/*.copy .close{ display: none !important; }*/
		.parecer{ margin: 20px 0 0 0; float: left; }

		@media print {
			.impressao{ display: none; }

			thead	{ display: table-header-group;	}
			tfoot	{ display: table-footer-group;	}
			thead th, thead td	{ position: static; } 
			 
			thead tr	{ position: static; } /*prevent problem if print after scrolling table*/ 
			table tfoot tr { position: static; }
			
		}
	</style>

	<link rel="stylesheet" type="text/css" href="/ecolaudo/css/editor_template.css">

	<script type="text/javascript" src="/ecolaudo/js/jquery-1.7.1/jquery-1.7.1.min.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function()
		{
			jQuery('.imprimir_iframe').click(function()
			{
				window.print();
			});

			var m_element = 0;
			jQuery('.elemento').each(function()
			{
				if( jQuery(this).height() > m_element )
				{
					m_element = jQuery(this).height();
				}
			});

			var m_unity = 0;
			jQuery('.unidade').each(function()
			{
				if( jQuery(this).height() > m_unity )
				{
					m_unity = jQuery(this).height();
				}
			});
			jQuery('.elemento').css('height', m_element+'px');
			jQuery('.unidade').css('height', m_unity+'px');;
		})
	</script>
</head>
<body>
<div class="modal-content">
	<div class="copy">
		<div class="bloco">
				<div class="impressao">
					<a href="javascript:void(0)" class="imprimir_iframe"></a>
					<a href="javascript:void(0)" class="fechar_iframe"></a>
				</div>
			</div>

		
		<div class="table_modal">
		

			<?php 

					$query_cabecalho = "
						SELECT 
						   sf_samp_service.snumber AS amostra 
						  ,sf_samp_service.identif AS identificacao 
						  ,sf_samp_service.cr_receive_date AS data_analise 
						  ,sf_samp_service.bag_id	
						  ,sf_samp_service.farm_lot
						  ,sf_samp_service.farm_owner as interessado 
						  ,sf_samp_service.farm as propriedade 
						FROM 
						  sf_samp_service 
						WHERE 
						  sf_samp_service.pk_samp_service = " . $_GET['pk_samp_service'];
					$result_cabecalho = pg_query($conexao, $query_cabecalho);
					$array_cabecalho = pg_fetch_assoc($result_cabecalho);

				?>
		
			
		<table style="width: 100%;">
			<thead>
				<tr>
					<td>
						<div class="bloco">
							<table class="table_laudo logo">
								<tr>
									<td align="left"><img src="/ecolaudo/imagens/logo_stoller_home.png" width="70"></td>
									<td align="right" valign="top">
										<div class="codigo_barras">
											<iframe src="/ecolaudo/barcode/code.php?code=<?php print $array_cabecalho['amostra']; ?>"></iframe>
										</div>
									</td>
								</tr>
							</table>
						</div>
							
						<div class="bloco">

							<table cellpadding="0" cellspacing="0" class="table_laudo cabecalho">
								<tr style="height: 20pt;">
									<td colspan="3" style="border-bottom:none"><h2 class="subtitle" style="margin: 0; padding: 0;">Identifica&ccedil;&atilde;o da Propriedade</h2></td>
									
								</tr>	
								<tr>
									<td><span>N&#186; Amostra</span>: <?php print $array_cabecalho['amostra']; ?></td>
									<td><?php print ($array_cabecalho['bag_id'] != '' ? '<span>BagID</span>: ' . $array_cabecalho['bag_id'] : ''); ?></td>

									<?php 

										$root = $_SERVER["DOCUMENT_ROOT"];
										$uploadfile = '/ecolaudo/upload/00img_' . $_GET['pk_samp_service'] . '_' .$usuario->getId();
										//print $root . $uploadfile.'.png';
										
										if( file_exists( $root . $uploadfile.'.png' ) )
										{
											print '<td align="right" rowspan="8"><img src="' . $uploadfile . '.png"></td>';
										}else if( file_exists( $root . $uploadfile.'.jpg' ) )
										{
											print '<td align="right" rowspan="8"><img src="' . $uploadfile . '.jpg"></td>';
										}else if( file_exists( $root . $uploadfile.'.jpeg' ) )
										{
											print '<td align="right" rowspan="8"><img src="' . $uploadfile . '.jpeg"></td>';
										}/*else
										{
											print '<td align="right" rowspan="8"><img src="' . $root . $uploadfile. '.png"></td>';
										}*/
									?>

									
									<!-- <td align="right" rowspan="8"><img src="/ecolaudo/imagens/talhao_10.jpg"></td> -->
									
								</tr>
								<tr>
									<td colspan="2"><span>Data An&aacute;lise</span>: <?php print mostraData($array_cabecalho['data_analise']); ?></td>
								</tr>
								<?php print ($array_cabecalho['interessado'] != '' ? '<tr> <td colspan="2"><span>Propriet&aacute;rio</span>: ' . $array_cabecalho['interessado'] . '</td></tr>' : ''); ?>
								<?php print ($array_cabecalho['propriedade'] != '' ? '<tr> <td colspan="2"><span>Propriedade</span>: ' . $array_cabecalho['propriedade'] . '</td></tr>' : ''); ?>		
								<tr>
									<td colspan="2"><span>Gleba</span>: <?php print $array_cabecalho['farm_lot']; ?></td>
								</tr>
								<tr>
									<td colspan="2"><span>Identifica&ccedil;&atilde;o</span>: <?php print $array_cabecalho['identificacao']; ?></td>
								</tr>

								<tr>
									<td><?php print ($array['cultura'] != '' ? '<span>Cultura</span>: ' . $array['cultura'] : ''); ?></td>
									<td><?php print ($array['classeresposta'] != '-' ? '<span>Classe Resposta de N</span>: ' . $array['classeresposta'] : ''); ?></td>

									<!-- <td></td> -->
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td style="border: none;"><?php print ($array['espacamento'] != '' ? '<span>Espa&ccedil;amento</span>: ' . str_replace('.', ',', $array['espacamento']) : ''); ?></td>
												<td style="border: none;">
													<?php print ($array['producao'] != '' ? '<span>Produ&ccedil;&atilde;o Esperada</span>: ' . str_replace('.', ',', $array['producao']) : ''); ?>
												</td>
												<td style="border: none;">
													<?php print ($array['producao_anterior'] != '' ? '<span>Produ&ccedil;&atilde;o Anterior</span>: ' . str_replace('.', ',', $array['producao_anterior']) : ''); ?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
									
							</table>
						</div>
					</td>
				</tr>
			</thead>
			<tfoot></tfoot>
			<tbody>
				<tr>
					<td>
			<?php 


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
				        ,(coalesce(sf_pa_det_res.fk_lab_type, 1) -1 )--p_solofolha integer 
				        ,sf_amostras_recomendacoes.cu_tecnologia --p_tecnologia integer 
				        ,sf_amostras_recomendacoes.cu_cultura --p_cultura integer 
				        ,sf_amostras_recomendacoes.cu_versao --p_versao integer 
				            ,false --only_in_step boolean 
				           ) 
				      ) as sub_sel_faixa 
				      ,( select 
				           avaliacao 
				         from 
				           sf_fc_get_evaluation_det_res ( 
				             sf_samp_service_det.pk_samp_service_det 
				        ,(coalesce(sf_pa_det_res.fk_lab_type, 1) -1 )--p_solofolha integer 
				        ,sf_amostras_recomendacoes.cu_tecnologia --p_tecnologia integer 
				        ,sf_amostras_recomendacoes.cu_cultura --p_cultura integer 
				        ,sf_amostras_recomendacoes.cu_versao --p_versao integer 
				             ,false --only_in_step boolean 
				           ) 
				       ) as sub_sel_avaliacao 
				    FROM 
				      sf_amostras_recomendacoes
				      INNER JOIN sf_samp_service_det       ON ( sf_samp_service_det.fk_samp_service     = sf_amostras_recomendacoes.amostra )
				      INNER JOIN sf_pa_det_res             ON ( sf_pa_det_res.pk_pa_det_res             = sf_samp_service_det.fk_pa_det_res ) 
				      INNER JOIN sf_pa_unity ON ( sf_pa_unity.pk_pa_unity = sf_samp_service_det.ro_fk_pa_unity ) 
				    WHERE 
				      sf_amostras_recomendacoes.id = ". $_GET['rec_id'] . "
				    LIMIT 24
				  ) as sub_sel
				--WHERE
				  --sub_sel.sub_sel_avaliacao >= 0
				ORDER BY 
				   sub_sel.norder 
				  ,pk_samp_service_det";
				$result_solo = pg_query($conexao, $query_solo);


			?>

			<div class="bloco">
				
				<h2 class="subtitle">Indicadores de Fertilidade do Solo</h2>
				<div class="grafico">
					<div class="coluna medidas">
						<div class="celula">
							Muito Alto
						</div>
						<div class="celula">
							Alto
						</div>
						<div class="celula">
							M&eacute;dio
						</div>
						<div class="celula">
							Baixo
						</div>
						<div class="celula">
							Muito Baixo
						</div>
					</div>

					<?php 
						$num_rows = pg_num_rows($result_solo);
						$var = 0;
						while ( $array_solo = pg_fetch_array($result_solo) ) 
						{
							$var++;
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
							


							print '<div class="coluna">';
								print '<div class="celula square">';
								if( $array_solo['sub_sel_avaliacao'] >= 0 )
								{
									print '<div class="col_grafico" style="height: ' . $array_solo['sub_sel_avaliacao'] . 'px; width: 8pt; background:' . $color . '; display: inline-block;  margin:' . (100 - $array_solo['sub_sel_avaliacao']) . 'px auto 0 auto;"></div>';
								}
								print '</div>';
								print '<div class="celula border" ' . ( $var == $num_rows ? ' style="border-right: 1px solid #D1D2D4"' : '' ) . '>';
									print '<p class="valor">' . $array_solo['value'] . '</p>';
									print '<p class="elemento">' . $array_solo['report_abbrev'] . '</p>';
									print '<p class="unidade">' . str_replace('/', ' ', $array_solo['abbrev']) . '</p>';
								print '</div>';
							print '</div>';
						}

					?>
				</div>
			</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="bloco">
						<h2 class="subtitle">Recomenda&ccedil;&atilde;o Agron&ocirc;mica</h2>
					</div>
				</td>
			</tr>

			<tr>
				<td>
					<div class="bloco">
						<?php print str_replace('<h3', '</td></tr><tr><td><h3',str_replace('<H3', '</td></tr><tr><td><H3', $array['html'])) ; ?>
					</div>
				</td>
			</tr>
		</tbody>
		</div>


	</div>
</div>
<div class="overlay"></div>
	<!-- <table class="parecer">
		<tr>
			<td class="subtitle">Parecer Técnico</td>
		</tr>
	</table> -->
</body>
</html>