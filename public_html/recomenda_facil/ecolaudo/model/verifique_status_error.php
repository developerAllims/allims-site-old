<?php
	header ('Content-type: text/html; charset=iso-8859-1');
	require_once '../controller/login_autenticador.php';
	require_once '../controller/login_sessao.php';
	require_once '../controller/login_usuario.php';
    session_start();
	 
	$aut = Autenticador::instanciar(); 
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}
	else {
		$aut->expulsar();
	}

	include 'conexao_bd.php';
	$conexao = conexao();



	/*$query = "SELECT
		sf_fc_get_recomendation_status
		  (
		    sf_amostras_recomendacoes.id
		    , sf_amostras_recomendacoes.calculado
		    , sf_amostras_recomendacoes.have_error
		  ) 
		  , sf_amostras_recomendacoes.message_error
		FROM 
		  sf_amostras_recomendacoes 
		WHERE
		  sf_amostras_recomendacoes.laboratorio = 1 
		  AND sf_amostras_recomendacoes.amostra = " . $_REQUEST['pk_samp_service'] . " /*pk_samp_service
		  AND sf_amostras_recomendacoes.ano = ".$usuario->getId()." /*pk_web_user";*/

     $query = "
		SELECT    
             COALESCE(sf_recomendacoes_controle.qtty_rec, 0) as qtty_fert
            ,sf_recomendacoes_controle.id[1] as rec_id_1
            ,sf_recomendacoes_controle.id[2] as rec_id_2
            ,sf_recomendacoes_controle.id[3] as rec_id_3
            ,sf_recomendacoes_controle.id[4] as rec_id_4
            ,sf_recomendacoes_controle.id[5] as rec_id_5

            ,sf_recomendacoes_controle.cultura[1] as rec_cultura_1
            ,sf_recomendacoes_controle.cultura[2] as rec_cultura_2
            ,sf_recomendacoes_controle.cultura[3] as rec_cultura_3
            ,sf_recomendacoes_controle.cultura[4] as rec_cultura_4
            ,sf_recomendacoes_controle.cultura[5] as rec_cultura_5

            ,sf_recomendacoes_controle.status[1] as rec_status_1
            ,sf_recomendacoes_controle.status[2] as rec_status_2
            ,sf_recomendacoes_controle.status[3] as rec_status_3
            ,sf_recomendacoes_controle.status[4] as rec_status_4
            ,sf_recomendacoes_controle.status[5] as rec_status_5

            ,sf_recomendacoes_controle.message_error[1] as rec_message_1
            ,sf_recomendacoes_controle.message_error[2] as rec_message_2
            ,sf_recomendacoes_controle.message_error[3] as rec_message_3
            ,sf_recomendacoes_controle.message_error[4] as rec_message_4
            ,sf_recomendacoes_controle.message_error[5] as rec_message_5

		FROM
		 	sf_recomendacoes_controle 
		 WHERE    
			sf_recomendacoes_controle.Laboratorio = 1
             AND sf_recomendacoes_controle.Amostra = " . $_REQUEST['pk_samp_service'] . "
             AND sf_recomendacoes_controle.Ano = ".$usuario->getId()."

    ";



 	$result = pg_query( $conexao, $query );
	$array = pg_fetch_assoc( $result );
	//$sf_fc_request_recomendation = $array_recomendation['sf_fc_request_recomendation'];


	$html = '';
	
	if( $array['qtty_fert'] < 5 )
	{
		$html .= '<button class="recomendar" data-id="'.$_REQUEST['pk_samp_service'].'" type="button"></button>';
	}

	for( $int_rec = 1; $int_rec <= $array['qtty_fert']; $int_rec++ )
	{
		if( $array["rec_status_".$int_rec] == 0 ) 
		{
			
		}else if( $array["rec_status_".$int_rec] == 1 ) 
		{
			$html .= '<button class="rec_editar" title="'. utf8_decode($array["rec_cultura_".$int_rec]) .'" data-id="'.$_REQUEST['pk_samp_service'].'" data-value="'.$array["rec_id_".$int_rec].'"></button>';

		}else if( $array["rec_status_".$int_rec] == 2 ) 
		{
			$html .= '<div class="calc_aguardando" title="'. utf8_decode($array["rec_cultura_".$int_rec]) .'" data-id="'.$_REQUEST['pk_samp_service'].'"></div>';
		}else if( $array["rec_status_".$int_rec] == 3 ) 
		{
			$html .= '<div class="calc_erro" title="'. utf8_decode($array["rec_cultura_".$int_rec]) .'" data-rel="'.utf8_decode($array["rec_message_".$int_rec]).'" data-id="'.$_REQUEST['pk_samp_service'].'" data-value="'.$array["rec_id_".$int_rec].'"></div>';
		}
	}

	echo $html;
?>

<script type="text/javascript">
	
jQuery(document).ready(function()
{
	jQuery('.recomendar').click(function(event)
	{
		event.preventDefault();
		//event.stopImmediatePropagation();
		var btn_clicado = jQuery(this);
		//alert(jQuery(this).attr('data-id'));
		jQuery('.box_alert').load('/ecolaudo/formulario.php?data-id=' + jQuery(this).attr('data-id'), function()
		{
			//alert(btn_clicado.attr('class'));


			jQuery('.btn_cancel').click(function()
			{
				//alert('touch');
				jQuery('.loading').fadeOut('slow',function(){
					jQuery('.loading').html('');
					jQuery('.box_alert').fadeOut('slow',function()
					{
						jQuery('.box_alert').html('');
					});

					//jQuery('#conteudo_tabela').bind('scroll');
				});
			});

			

			jQuery('.technology').change(function()
			{
				if( jQuery(this).val() != '' )
				{
					jQuery.ajax({
						dataType:'json',
						url: '/ecolaudo/includes/select_cultures.php',
						data: {
								'fk_technology' : jQuery(this).val()
							},
						type: 'GET',
						//context: jQuery('#resultado'),
						success: function( data )
						{
							jQuery('.cultures').html(data.html);
						

							jQuery('.cultures select').change(function()
							{
								if( jQuery(this).val() != '' )
								{
									jQuery.ajax({
										dataType:'json',
										url: '/ecolaudo/includes/select_pa_cultures.php',
										data: {
												'fk_cultures' : jQuery(this).val()
												, 'fk_technology' : jQuery('.technology').val()
											},
										type: 'POST',
										success: function( data )
										{
											jQuery('#info_conteudo').html(data.html);
											//alert(jQuery('.box_alert').height());
											
											jQuery('#info_conteudo input').keypress(function(e)
											{
												var v_this = $(this);
												var tecla = ( window.event ) ? e.keyCode : e.which;
											    if ( tecla == 8 || tecla == 0 )
											        return true;
											    if ( tecla != 44 && tecla < 48 || tecla > 57 )
											        return false;	

											    console.log(v_this.val().indexOf(','));
											   	if((tecla == 44 || tecla == 110 || tecla == 188) && (v_this.val().indexOf(',') >= 0 ) )
											   	{
													return false;
											   	}
											});

											jQuery('.espacamento input').blur(function()
											{
												if( jQuery('input[name=esprua]').val() != '' && jQuery('input[name=espcova]').val() != '' )
												{
													if( ((jQuery('input[name=esprua]').val().replace(',', '.'))  * (jQuery('input[name=espcova]').val()).replace(',', '.')) > 0 )
													{
														var string = (10000 / ( (jQuery('input[name=esprua]').val().replace(',', '.'))  * (jQuery('input[name=espcova]').val().replace(',', '.')))).toString();
														var arredondamento = string.split('.');

														jQuery('input[name=plantas-ha]').val(
															arredondamento[0]
								     			    	  );
													}
												}
											});

											jQuery('.btn_enviar').click(function()
											{
												if( $("input[name=p-esperada]").length )
												{
													var fesperada = parseFloat(jQuery('input[name=p-esperada]').val().replace(',','.'));
													var fminima = parseFloat(jQuery('input[name=hidden_pd_minima]').val().replace(',','.'));
													var fmaxima = parseFloat(jQuery('input[name=hidden_pd_maxima]').val().replace(',','.'));

													if( (fesperada < fminima) || (fesperada > fmaxima))
													{
														alert('Produção esperada deve ser maior que ' + $('input[name=hidden_pd_minima]').val() + ' e menor que ' + $('input[name=hidden_pd_maxima]').val() );
														return false;
													}
												}

												//alert('aqui');
												//alerta( jQuery('.form_culturas').serializeArray() );
												event.preventDefault();
												jQuery.ajax({
														dataType:'json',
														url: '/ecolaudo/model/sf_request.php',
														data: jQuery('.form_culturas').serializeArray(),
														type: 'GET',
														beforeSend: function() 
														{
															jQuery('.btn_enviar').css('display','none');
														// setting a timeout
												       	// $(placeholder).addClass('loading');
												    	},
														success: function( data )
														{
															jQuery('.btn_enviar').css('display','inline-block');																	
															if( data.result == 1 ) 
															{
																//alert('Recomendação gravada com sucesso, aguarde a mesma ser gerada.');
																jQuery('.loading').fadeOut('slow',function(){
																	jQuery('.loading').html('');
																	jQuery('.box_alert').fadeOut('slow');
																	jQuery('.box_alert').html('');
																	//jQuery('#conteudo_tabela').bind('scroll');
																});

																$('.recomendar[data-id='+jQuery('.form_culturas input[name=hidden_classe_data_id]').val()+']').parent('td').load('/ecolaudo/model/verifique_status_error.php?pk_samp_service='+jQuery('.form_culturas input[name=hidden_classe_data_id]').val());
																return false;
																																
															}else if( data.result == 2 ) 
															{ 
																alert('Não foi possivel inserir a amostra de solo');
															}else if( data.result == 3 )
															{
																alert('Não foi possivel inserir a amostra de folha');
															}else if( data.result == 3 )
															{
																alert('Cultura não encontrada');
															}else if( data.error == 9 || data.result == null)
															{
																alert('Recomendação não pode ser requisitada.');
															}
															
															jQuery('.modal').css('display', 'none');
															jQuery('.modal').html('');

														}													
													});
											});
										}
									});
								}

							});

						}
					});
				}
			});
			
			jQuery('.box_alert').css({'height': 'auto', 'width' : 'auto'});
			jQuery('.box_alert').fadeIn(1000);
		} );

		//jQuery('.box_alert').css('top','calc( 40% - ' + jQuery('.box_alert').height() + ')');
		jQuery('.loading').css({'display':'block','background-image':'rgba(0,0,0,0.05)','z-index':'0'});
		
		
		
		jQuery('.loading').click(function()
		{
			//alert('touch');
			jQuery('.loading').fadeOut('slow',function(){
				jQuery('.loading').html('');
				jQuery('.box_alert').fadeOut('slow');
				jQuery('.box_alert').html('');
				//jQuery('#conteudo_tabela').bind('scroll');
			});
		});
		event.stopImmediatePropagation();
	});

	jQuery('.calc_erro').click(function(event)
	{
		//event.stopPropagation();
		//alerta(jQuery(this).attr('data-id'));
		var v_this = jQuery(this);
		jQuery('.box_alert').html(v_this.attr('data-rel') + '<br><br><span>Deseja excluir essa recomenda&ccedil;&atilde;o?</span> <div id="botao" class="bt_down sim" >Sim</div> <div id="botao" class="bt_down nao">N&atilde;o</div>');
		jQuery('.loading').css({'display':'block','background':'rgba(0,0,0,0.05)','z-index':'0'});

		

		jQuery('.box_alert').fadeIn(1000);

				
		jQuery('.box_alert .sim').click(function()
		{
			jQuery('.box_alert').html('<p></p>');
			jQuery('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center rgba(0,0,0,0.05)','z-index':'9999'});
			//pastas('exc', {id : jQuery('.listagem-pastas .enabled').attr('data-id') , title : jQuery('.listagem-pastas .enabled').attr('data-title') })
			jQuery.ajax({
				dataType:'json',
				url: '/ecolaudo/model/delete_recomendacao.php',
				data: {
						'id'		 : v_this.attr('data-value'),
						'amostra'	 : v_this.attr('data-id')
					},
				type: 'POST',
				success: function( data )
				{
					jQuery('.box_alert').fadeOut(1000);

					jQuery.ajax({
						dataType:'json',
						url: '/ecolaudo/model/verifique_status.php',
						data: {
								'pk_samp_service' : v_this.attr('data-id')
							},
						type: 'POST',
						//context: jQuery('#resultado'),
						success: function( data )
						{
							v_this.parent('td').load('/ecolaudo/model/verifique_status_error.php?pk_samp_service='+v_this.attr('data-id'));
							return false;
						}
					});
				}
			});
		});
		
		
		jQuery('.box_alert .nao').click(function()
		{ 
			jQuery('.box_alert').fadeOut(	
				1000,
				function()
				{
					jQuery('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center rgba(0,0,0,0.05)','z-index':'9999'});
					jQuery('.box_alert').html('<p></p>');
				});
					
		});



	});

	var folder = jQuery(location).attr('pathname').split('/');
	jQuery('.rec_editar').click(function(event)
	{
		event.preventDefault();
		//event.stopPropagation();
		var url2 = folder[2];
		if( folder[2] == '' || folder[2] == undefined)
		{
			url2 = 'caixadeentrada';
		}
		var url3 = folder[3];
		if( folder[3] == '' || folder[3] == undefined)
		{
			url3 = '1';
		}


		jQuery.ajax({
			dataType:'html',
			url: '/ecolaudo/template.php',
			data: {
					'last_url'		 	: '/amostras/'+ url2 +'/'+url3,
					'pk_samp_service'	: jQuery(this).attr('data-id'),
					'rec_id'			: jQuery(this).attr('data-value')
				},
			type: 'POST',
			beforeSend: function()
			{
				jQuery('.loading').css('display','block');
			},
			success: function( data )
			{
				//alert('oi');
				jQuery('.loading').css('display','none');
				jQuery('.box_recomendacao').html(data);
				jQuery('.box_recomendacao').css('height',($(window).height()-105)+'px');


			}
		});

		event.stopImmediatePropagation();
	});
})
</script>