jQuery(document).ready(function(){
	//alert(parseInt(jQuery.browser.version, 10));
	//alert(window.location.pathname  );
	var folder = jQuery(location).attr('pathname').split('/');
	jQuery(document).keydown(function(e) {
	    if ( folder[2] == 'amostras' && (( (e.which || e.keyCode) == 116 ) || (( ( e.which || e.keyCode) == 82 ) && e.ctrlKey) )) 
	   { //116 = F5		
			event.preventDefault();			 
	        var interessado = jQuery('[name="web_interessado"]').val() == 'Interessado...' ? '' : jQuery('[name="web_interessado"]').val();
				
			var fazenda = jQuery('[name="web_fazenda"]').val() == 'Propriedade...' ? '' : jQuery('[name="web_fazenda"]').val();
			
			var amostras = jQuery('[name="web_amostras"]').val() == 'Tipo de Amostra...' ? '' : jQuery('[name="web_amostras"]').val();  
			
			var desde = jQuery('[name="data_desde"]').val() == 'Desde...' ? '' : jQuery('[name="data_desde"]').val(); 
			
			var ate = jQuery('[name="data_ate"]').val() == 'Até...' ? '' : jQuery('[name="data_ate"]').val();
			
			var busca = jQuery('[name="busca"]').val() == 'Procure uma amostra ...' ? '' : jQuery('[name="busca"]').val();
			
			busca_ajax(
						interessado,
						fazenda,
						amostras,  
						desde, 
						ate,
						busca,
						jQuery('.current_page').val(),
						'true'
						);
        	return false;
	    }
	});

	//alert(parseInt(jQuery.browser.version, 10))
	if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 9) 
	{		
	  	jQuery('#conteudo').css('height', (jQuery('#main').innerHeight() - 175) + 'px');
		
		jQuery('input[type=text]').each(function(){
			
			if(  jQuery(this).attr('id') != 'data_desde' && jQuery(this).attr('id') != 'data_ate' )
			{ 
				if( jQuery(this).val() == '' )
				{
					jQuery(this).addClass('placeholder');
					valor = jQuery(this).attr('placeholder');
					jQuery(this).val(valor);
				}
			}else
			{
				valor = jQuery(this).attr('placeholder');
				jQuery(this).val(valor);
			}
		});
		
		 jQuery('.placeholder').click(function(event)
		{
			jQuery(this).val('');
			jQuery(this).removeClass('placeholder');
		});
		
		jQuery('.placeholder').blur(function()
		{
			if(jQuery(this).val() == '')
			{
				jQuery(this).addClass('placeholder');
				jQuery(this).val(jQuery(this).attr('placeholder'));
			}
		});
	}
		
	$('body').click(function()
	{
		if( $('.drop ul').css('display') == 'block' )
		{
			$('.drop ul').toggle( "slow" );
		}
	});
	
	$('.drop span').click(function(event) {
	    $('.drop ul').toggle( "slow" );
		event.stopPropagation();
	});

	
	//ABA DE OPINIAO
	
	
	
	
	// PAGINA USUARIOS ----- INICIOO 
	jQuery('.listagem_usuarios tr').click(function()
	{
		if( jQuery('.listagem_usuarios tr').hasClass('selected') && ! jQuery(this).hasClass('selected') )
		{
			jQuery('.selected div').remove();					
			jQuery('.selected .into').html('<span>' + jQuery('.selected input').val() + '</span>');
			jQuery('.selected').find('a').css('display','inline-block');
			jQuery('.listagem_usuarios tr').removeClass('selected');
		}
		
		if( ! jQuery(this).hasClass('selected') && ! jQuery(this).hasClass('disabled') )
		{
			//alert( jQuery(this).attr('class'));
			jQuery(this).find('a').css('display','none');
			
			jQuery(this).children('.into').load('/ecolaudo/includes/formularios_internos.html #formalario-' + jQuery(this).attr('class'),function()
			{
				$('.formulario input').keypress(function(event)
				{
					if(event.keyCode == 13)
					{
						return false;
					}
				});
				
				jQuery('.salvar').click(function(event)
				{
					event.preventDefault();
					
					if( ! jQuery(this).hasClass('disabled') )
					{
						if( jQuery('.into input').val() != '' )
						{
							
							jQuery.ajax({
										dataType:'json',
										url : '/ecolaudo/model/account_config.php',
										type: 'GET',
										data : jQuery(':input').serialize(),
										beforeSend: function() 
										{
											jQuery('.loading').css('display','block');
										// setting a timeout
										// $(placeholder).addClass('loading');
										},
										success: function(data)
										{
											
											if( data.erro == 3 )
											{
												jQuery('.atual').css('border','1px solid #FF0000'); 
												jQuery('.error_a').css('color','#FF0000');
											}else if( data.erro == 2 )
											{
												alerta('Não foi possivel concluir a alteração');
											}else
											{
												alerta('Dado alterado com sucesso!');
												
												jQuery('.selected div').remove();
												jQuery('.selected').find('a').css('display','inline-block');
												jQuery('.listagem_usuarios tr').removeClass('selected');
												
												if( data.user_name != 'null' && data.user_name != null )
												{
													jQuery('.nome .into').html('<span>' + data.user_name + '</span>');
												}//jQuery('.nome input').val(data.user_name);
												if( data.user_phone != 'null' && data.user_phone != null )
												{
													jQuery('.telefone .into').html('<span>' + data.user_phone + '</span>');
												}
												//jQuery('.telefone input').val(data.user_phone);
												if( data.user_city != 'null' && data.user_city != null )
												{
													jQuery('.cidade .into').html('<span>' + data.user_city + '</span>');
												}
												//jQuery('.cidade input').val(data.user_city);
												if( data.user_state != 'null' && data.user_state != null )
												{
													jQuery('.estado .into').html('<span>' + data.user_state + '</span>');
												}
												//jQuery('.estado input').val(data.user_state);
												jQuery('.senha .into').html('<span>********</span>');
												jQuery('.atual').css('border','1px solid #a9a9a9');
												jQuery('.error_a').css('color','#ecefe8');
											}
											jQuery('.loading').css('display','none');
											//alert(data);
										}
									});
						}
					}
				});
				
				
				jQuery('.texto').blur(function()
				{
					if( jQuery(this).val() != '' )
					{
						jQuery('.salvar').removeClass('disabled');
					}else
					{
						jQuery('.salvar').addClass('disabled');
						//console.log('ainda esta errado');
					}
				});
				jQuery('.texto').keydown(function()
				{
					if( jQuery(this).val() != '' )
					{
						jQuery('.salvar').removeClass('disabled');
					}else
					{
						jQuery('.salvar').addClass('disabled');
						//console.log('ainda esta errado');
					}
				});
				
				jQuery('.atual').blur(function()
				{
					if( jQuery(this).val() == jQuery('.repetir').val() && jQuery(this).val() != '' && jQuery('.nova').val() != ''  && jQuery('.repetir').val() != '' )
					{
						jQuery('.salvar').removeClass('disabled');
					}else if( jQuery(this).val() != '' && jQuery('.nova').val() != '' )
					{
						jQuery('.salvar').addClass('disabled');
						//console.log('ainda esta errado');
					}
				});
				
				jQuery('.repetir').blur(function()
				{
					if( jQuery('.repetir').val() != jQuery('.nova').val()  && jQuery('.nova').val() != '' )
					{
						jQuery('.salvar').addClass('disabled');
						
						jQuery('.repetir').css('border','1px solid #FF0000'); 
						jQuery('.nova').css('border','1px solid #FF0000');
						jQuery('.error_b').css('color','#FF0000');
						
						console.log('ainda esta errado');
					}else if( jQuery('.repetir').val() != '' && jQuery('.nova').val() != '' && jQuery('.nova').val() != '' )
					{
						jQuery('.repetir').css('border','1px solid #a9a9a9'); 
						jQuery('.nova').css('border','1px solid #a9a9a9');
						jQuery('.salvar').removeClass('disabled');
						jQuery('.error_b').css('color','#ecefe8');
						
					}
				});
				
				jQuery('.nova').blur(function()
				{
					if( jQuery('.nova').val() != jQuery('.repetir').val() && jQuery('.repetir').val() != '' )
					{
						jQuery('.salvar').addClass('disabled');
						jQuery('.nova').css('border','1px solid #FF0000'); 
						jQuery('.repetir').css('border','1px solid #FF0000');
						jQuery('.error_b').css('color','#FF0000');
						console.log('ainda esta errado');
					}else if(jQuery('.nova').val() != '' && jQuery('.repetir').val() != '' && jQuery('.nova').val() != '')
					{
						jQuery('.nova').css('border','1px solid #a9a9a9'); 
						jQuery('.repetir').css('border','1px solid #a9a9a9');
						jQuery('.salvar').removeClass('disabled');
						jQuery('.error_b').css('color','#ecefe8');
					}
				});
				
				//Botão Cancelar
				jQuery('.cancelar').click(function()
				{
					//alert('cancelando...');
					jQuery('.selected div').remove();
					
					jQuery('.selected .into').html('<span>' + jQuery('.selected input').val() + '</span>');
					jQuery('.selected').find('a').css('display','inline-block');
					jQuery('.listagem_usuarios tr').removeClass('selected');
					event.stopImmediatePropagation();
				});
				//Fim LOAD 
			});
			jQuery(this).addClass('selected');
			//alert('clicked');
		}
	});
	
	
	
	

	
	
	
	// PAGINA AMOSTRAS ---- INICIOO 
	
	
	jQuery('#select_all').click(function()
	{
		if( jQuery(this).attr('checked') == 'checked' )
		{
			jQuery('input[type=checkbox]').each(function(index, element) 
			{
				jQuery(this).attr('checked',true);   
			});
		}else
		{
			jQuery('input[type=checkbox]').each(function(index, element) 
			{
				jQuery(this).attr('checked',false);   
			});
		}
	});
	
	
	//PASTAS ------
	jQuery('.pastas').click(function()
	{
		//alert('oi');	
		if( $(this).hasClass('btn_selected') )
		{
			$('#header_oculta').css('height','0px');
			$('.menu_nivel02 .btn_selected').removeClass('btn_selected');
			$(this).removeAttr('style');
		}else
		{
			$('.menu_nivel02 .btn_selected').removeClass('btn_selected');
			$(this).addClass('btn_selected');
			if( $('#aplica-filtro').attr('src') == '/ecolaudo/imagens/bt_atualizar_clicked.png' || $('.filtro').attr('data-desde') != '' || $('.filtro').attr('data-ate') != '' || $('.filtro').attr('data-interessado') != '' || $('.filtro').attr('data-amostras') != '' || $('.filtro').attr('data-fazenda') != '' )
			{
				$('.filtro').attr({
								'data-desde':$('.box_filtros #data_desde').val(),
								'data-ate':$('.box_filtros #data_ate').val(),
								'data-interessado':$('.box_filtros #interessado').val(),
								'data-amostras':$('.box_filtros #amostras').val(),
								'data-fazenda':$('.box_filtros #fazenda').val()
						});
			}else
			{
				$('.filtro').attr({
								'data-desde':'',
								'data-ate':'',
								'data-interessado':'',
								'data-amostras':'',
								'data-fazenda':''
						});
				
			}

			jQuery('.amostra-email').removeAttr('style');
			jQuery('.filtro').removeAttr('style');
			jQuery('.importar').removeAttr('style');
			jQuery('.exportar').removeAttr('style');
			jQuery(this).css({'background':' url(/ecolaudo/imagens/icon_pastas_over.png) no-repeat #F7941E' , 'color':'#fff'});
			jQuery('.loading').css('display','block');
			var folder = jQuery(location).attr('pathname').split('/');
			jQuery('.menu_nivel03 .content').load('/ecolaudo/includes/pastas_amostras.php?folders='+folder[2],function()
				{
					jQuery('.loading').css('display','none');
					jQuery('.box_pastas .listagem-pastas').css('width', (jQuery('#main').innerWidth() - 40) );
	
					jQuery('.novo').click(function()
					{
						jQuery('.mover').removeAttr('style');
						jQuery('.lista_pasta').css('display','none');
						jQuery(this).css({'background':'#F7941E' , 'color':'#fff'});
						jQuery('.conteudo_novo').css('display','inline-block');
						//jQuery('.mover').css('margin-left','50px');
					});
					jQuery('.cancelar').click(function()
					{
						jQuery('.mover').removeAttr('style');
						jQuery('.lista_pasta').css('display','none');
						jQuery('.novo').removeAttr('style');
						jQuery('.conteudo_novo input').val('');
						jQuery('.conteudo_novo').css('display','none');
						jQuery('.mover').css('margin-left','0');
					});
					
					jQuery('.conteudo_novo .ok').click(function()
					{
						if( jQuery('input[name=novo]').val() != '' )
						{
							pastas('inc', jQuery('input[name=novo]').val() );
						}
					});
					
					jQuery('.excluir').click(function()
					{
						var folder = jQuery(location).attr('pathname').split('/');
						
						if( folder[2] == 'caixadeentrada' || folder[2] == '' || folder[2] == null )
						{
							alerta( 'Caixa de entrada não pode ser excluida.'  );
						}else
						{
							
							
							
				
							
				jQuery('.box_alert').html( 	'<span>Deseja exluir essa pasta?</span>							<div id="botao" class="bt_down sim" >Sim</div>							<div id="botao" class="bt_down nao">Não</div>');
				jQuery('.loading').css({'display':'block','background':'rgba(0,0,0,0.05)','z-index':'0'});
				jQuery('.box_alert').fadeIn(1000);
				
				
				jQuery('.box_alert .sim').click(function()
				{
					jQuery('.box_alert').html('<p></p>');
					jQuery('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center rgba(0,0,0,0.05)','z-index':'9999'});
					pastas('exc', {id : jQuery('.listagem-pastas .enabled').attr('data-id') , title : jQuery('.listagem-pastas .enabled').attr('data-title') })
				
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
				
							
							
							
							
						}
					});
					
					jQuery('.mover').click(function()
					{
						if( jQuery('.lista_pasta').css('display') == 'none' )
						{
							jQuery(this).css({'background':'#F7941E' , 'color':'#fff'});
							jQuery('.lista_pasta').css('display','block');
						}else
						{
							jQuery(this).removeAttr('style');
							jQuery('.lista_pasta').css('display','none');
						}
					});
					jQuery('.mover').mouseenter(function()
					{
						jQuery(this).css({'background':'#F7941E' , 'color':'#fff'});
						jQuery('.lista_pasta').css('display','block');
					});
					
					jQuery('.lista-mover').mouseleave(function()
					{
						jQuery('.mover').removeAttr('style');
						jQuery('.lista_pasta').css('display','none');
					});
					
					
					jQuery('.lista_pasta .bt_down').click(function()
					{
						var i = 0;
						var comparativo = jQuery(this).attr('data-id');
						var checks = new Array();
						 checks[0] = jQuery(this).attr('data-id');
						 
						jQuery('.check_').each(function(index, element) 
						{
							i++;
							if( jQuery(this).attr("checked") == "checked" )
							{
								checks.push(jQuery(this).attr('data-ajax'));
							}
							
							if( i == jQuery( ".check_" ).length)
							{
								if( checks != comparativo )
								{
									pastas('mov', checks );
								}else
								{
									alerta( 'Selecione pelo menos 1 amostra.'  );
								}
							}
						});
					});
					
					if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 9) 
					{
						jQuery('.listagem-pastas .bt_down').click(function()
						{
							window.location.href ='http://'+window.location.hostname+'/amostras/'+retira_acentos(jQuery(this).attr('data-title'));
						});

					}else
					{
						jQuery('.listagem-pastas .bt_down').click(function()
						{
							//alert(retira_acentos(jQuery(this).attr('data-title')));
							jQuery('.listagem-pastas .bt_down').removeClass('enabled');
							jQuery(this).addClass('enabled');
							window.history.pushState('obj', 'newtitle', '/amostras/' + retira_acentos(jQuery(this).attr('data-title')));
							event.stopPropagation();
							busca_ajax();
						});
					}
					
					//$('.listagem_amostra .topo_listagem th div').animate({'top':'300px'},400);
					//jQuery('#header_oculta').css('height','120px');
					var curHeight = $('#header_oculta').height();
					$('#header_oculta').css('height','auto');
					var autoHeight = $('#header_oculta').height();
					$('#header_oculta').height(curHeight).animate({height: autoHeight}, 500);
				});
			
			//jQuery('.menu_nivel03 .content').load(
		}
	});
	
	
	jQuery('.amostra-email').click(function()
	{
		
		if( $(this).hasClass('btn_selected') )
		{
			$('#header_oculta').css('height','0px');
			$('.menu_nivel02 .btn_selected').removeClass('btn_selected');
			$(this).removeAttr('style');
		}else
		{
			$('.menu_nivel02 .btn_selected').removeClass('btn_selected');
			$(this).addClass('btn_selected');
			if( $('#aplica-filtro').attr('src') == '/ecolaudo/imagens/bt_atualizar_clicked.png' || $('.filtro').attr('data-desde') != '' || $('.filtro').attr('data-ate') != '' || $('.filtro').attr('data-interessado') != '' || $('.filtro').attr('data-amostras') != '' || $('.filtro').attr('data-fazenda') != '' )
			{
				$('.filtro').attr({
								'data-desde':$('.box_filtros #data_desde').val(),
								'data-ate':$('.box_filtros #data_ate').val(),
								'data-interessado':$('.box_filtros #interessado').val(),
								'data-amostras':$('.box_filtros #amostras').val(),
								'data-fazenda':$('.box_filtros #fazenda').val()
						});
			}else
			{
				$('.filtro').attr({
								'data-desde':'',
								'data-ate':'',
								'data-interessado':'',
								'data-amostras':'',
								'data-fazenda':''
						});
				
			}
			
			jQuery('.filtro').removeAttr('style');
			jQuery('.exportar').removeAttr('style');
			jQuery('.importar').removeAttr('style');
			jQuery('.pastas').removeAttr('style');
			jQuery(this).css({'background':'url(/ecolaudo/imagens/ico-copy-branco.png) no-repeat #F7941E' , 'color':'#fff'});
			
			jQuery('.loading').css('display','block');
			jQuery('.menu_nivel03 .content').load('/ecolaudo/includes/amostra_email.php',
					function()
					{
						jQuery('.loading').css('display','none');
						jQuery('.cad-amostra-email .ok').click(function()
						{
							var i = 0;
							var checks = new Array();							 
							jQuery('.check_').each(function(index, element) 
							{
								i++;
								if( jQuery(this).attr("checked") == "checked" )
								{
									checks.push(jQuery(this).attr('data-id'));
								}
								
								if( i == jQuery( ".check_" ).length && i != 1 )
								{
									if( checks != '' )
									{
										amostras_email( jQuery('.new-email').val(), checks );
									}else
									{
										alerta( 'Selecione pelo menos 1 amostra.'  );
									}
								}
							});
						});
						//$('.listagem_amostra .topo_listagem th div').animate({'top':'255px'},400);
						var curHeight = $('#header_oculta').height();
						$('#header_oculta').css('height','auto');
						var autoHeight = $('#header_oculta').height();
						$('#header_oculta').height(curHeight).animate({height: autoHeight}, 500);
					});
		}
	});
	
	
	
	
	
	//BOTAO FILTRO ------------
	jQuery('.filtro').click(function()
	{
		
		if( $(this).hasClass('btn_selected') )
		{
			$('#header_oculta').css('height','0px');
			$('.menu_nivel02 .btn_selected').removeClass('btn_selected');
			$(this).removeAttr('style');
			
			if( $('#aplica-filtro').attr('src') == '/ecolaudo/imagens/bt_atualizar_clicked.png' )
			{
				$('.filtro').attr({
								'data-desde':$('.box_filtros #data_desde').val(),
								'data-ate':$('.box_filtros #data_ate').val(),
								'data-interessado':$('.box_filtros #interessado').val(),
								'data-amostras':$('.box_filtros #amostras').val(),
								'data-fazenda':$('.box_filtros #fazenda').val()
						});
			}else
			{
				$('.filtro').attr({
								'data-desde':'',
								'data-ate':'',
								'data-interessado':'',
								'data-amostras':'',
								'data-fazenda':''
						});
				busca_ajax();
			}
			//$('.listagem_amostra .topo_listagem th div').animate({'top':'180px'},400);
			
			//alert('hei');
		}else
		{			
			$('.menu_nivel02 .btn_selected').removeClass('btn_selected');
			$(this).addClass('btn_selected');
			jQuery('.amostra-email').removeAttr('style');
			jQuery('.exportar').removeAttr('style');
			jQuery('.importar').removeAttr('style');
			jQuery('.pastas').removeAttr('style');
			jQuery(this).css({'background':' url(/ecolaudo/imagens/icon_filtro_over.png) no-repeat #F7941E' , 'color':'#fff'});
			
			jQuery('.loading').css('display','block');
			jQuery('.menu_nivel03 .content').load('/ecolaudo/includes/filtros_amostras.php',
						function()
						{
								jQuery('.loading').css('display','none');
								/*jQuery('input[type=text]').each(function(){
								if(  jQuery(this).attr('id') != 'data_desde' && jQuery(this).attr('id') != 'data_ate' )
								{ 
									if( jQuery(this).val() == '' )
									{
										jQuery(this).addClass('placeholder');
										valor = jQuery(this).attr('placeholder');
										jQuery(this).val(valor);
									}
								}else
								{
									valor = jQuery(this).attr('placeholder');
									jQuery(this).val(valor);
								}
							});*/
							
							 jQuery('.placeholder').click(function(event)
							{
								jQuery(this).val('');
								jQuery(this).removeClass('placeholder');
							});
							
							jQuery('.placeholder').blur(function()
							{
								if(jQuery(this).val() == '')
								{
									jQuery(this).addClass('placeholder');
									jQuery(this).val(jQuery(this).attr('placeholder'));
								}
							});
						
							if( $('.filtro').attr('data-desde') != '' || $('.filtro').attr('data-ate') != '' || $('.filtro').attr('data-interessado') != '' || $('.filtro').attr('data-amostras') != '' || $('.filtro').attr('data-fazenda') != '')
							{
								//var teste = $('.filtro').attr('data-desde')
								$('.box_filtros #data_desde').val($('.filtro').attr('data-desde'));
								$('.box_filtros #data_ate').val($('.filtro').attr('data-ate'));
								$('.box_filtros #interessado').val($('.filtro').attr('data-interessado'));
								$('.box_filtros #amostras').val($('.filtro').attr('data-amostras'));
								$('.box_filtros #fazenda').val($('.filtro').attr('data-fazenda'));
								$('#aplica-filtro').attr('src','/ecolaudo/imagens/bt_atualizar_clicked.png');
							}

							$('.data_completa').keypress(function(event)
							{

								var qnt = $(this).val().length;
								var tecla = event.keyCode || event.charCode;
								if(  tecla == 8 )
									return true;

								if ( tecla < 48 || tecla > 57)
						        	return false;


						    	if( qnt == 2 || qnt == 5)
						    		$(this).val( $(this).val() + '/' );

							});

							
							 jQuery('.box_filtros input[type=text]').keypress(function(event)
							 {
			
								 if( event.keyCode == 13 )
								 {
									  
									 jQuery('#aplica-filtro').attr('src','/ecolaudo/imagens/bt_atualizar_clicked.png');
										
										var interessado = jQuery('[name="web_interessado"]').val() == 'Interessado...' ? '' : jQuery('[name="web_interessado"]').val();
										
										var fazenda = jQuery('[name="web_fazenda"]').val() == 'Propriedade...' ? '' : jQuery('[name="web_fazenda"]').val();
										
										var amostras = jQuery('[name="web_amostras"]').val() == 'Tipo de Amostra...' ? '' : jQuery('[name="web_amostras"]').val();  
										
										var desde = jQuery('[name="data_desde"]').val() == 'Desde...' ? '' : jQuery('[name="data_desde"]').val(); 
										
										var ate = jQuery('[name="data_ate"]').val() == 'Até...' ? '' : jQuery('[name="data_ate"]').val();
										
										var busca = jQuery('[name="busca"]').val() == 'Procure uma amostra ...' ? '' : jQuery('[name="busca"]').val();
									 
									 
									 busca_ajax(
													interessado,
													fazenda,
													amostras,  
													desde, 
													ate
													);
									event.preventDefault();
									//alert('enter');
									jQuery('#aplica-filtro').attr('src','/ecolaudo/imagens/bt_atualizar_clicked.png');
									 //event.stopImmediatePropagation();
								 }else if ( jQuery('#aplica-filtro').attr('src') != '/ecolaudo/imagens/bt_atualizar_up.png' ) 
								 {
									 jQuery('#aplica-filtro').attr('src','/ecolaudo/imagens/bt_atualizar_up.png');
									
								 }
								
							 });
							 
							 jQuery('#aplica-filtro').click(function(event)
							  {
								  //alert(event.keyCode);
								 event.preventDefault();
								 if( jQuery(this).attr('src') == '/ecolaudo/imagens/bt_atualizar_up.png' )
								 {
									 jQuery('#aplica-filtro').attr('src','/ecolaudo/imagens/bt_atualizar_clicked.png');
										
										var interessado = jQuery('[name="web_interessado"]').val() == 'Interessado...' ? '' : jQuery('[name="web_interessado"]').val();
										
										var fazenda = jQuery('[name="web_fazenda"]').val() == 'Propriedade...' ? '' : jQuery('[name="web_fazenda"]').val();
										
										var amostras = jQuery('[name="web_amostras"]').val() == 'Tipo de Amostra...' ? '' : jQuery('[name="web_amostras"]').val();  
										
										var desde = jQuery('[name="data_desde"]').val() == 'Desde...' ? '' : jQuery('[name="data_desde"]').val(); 
										
										var ate = jQuery('[name="data_ate"]').val() == 'Até...' ? '' : jQuery('[name="data_ate"]').val();
										
										var busca = jQuery('[name="busca"]').val() == 'Procure uma amostra ...' ? '' : jQuery('[name="busca"]').val();
									 
									 
									 busca_ajax(
													interessado,
													fazenda,
													amostras,  
													desde, 
													ate
													);
								 }else
								 {
									 busca_ajax();
									 jQuery(this).attr('src','/ecolaudo/imagens/bt_atualizar_up.png');
									 jQuery('.box_filtros input').val('');
									 //jQuery('#header_oculta').css('height',0);
								 }
							  });
							  
							  jQuery('#data_desde').datepicker({  
									inline: true,
									dateFormat:"dd/mm/yy",  
									showOtherMonths: true,  
									dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],  
									monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'], 
									//Aqui esta a ação apos a seleção da data
									onSelect: function(textoData, objDatepicker)
									{
										 if ( jQuery('#aplica-filtro').attr('src') != '/ecolaudo/imagens/bt_atualizar_up.png' ) 
										 {
											 jQuery('#aplica-filtro').attr('src','/ecolaudo/imagens/bt_atualizar_up.png');
										 }
								   }
								}); 
									 
								jQuery('#data_ate').datepicker({
									  
									inline: true,
									dateFormat:"dd/mm/yy",  
									showOtherMonths: true,  
									dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'], 
									monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'], 
									//Aqui esta a ação apos a seleção da data
									onSelect: function(textoData, objDatepicker)
									{
										 if ( jQuery('#aplica-filtro').attr('src') != '/ecolaudo/imagens/bt_atualizar_up.png' ) 
										 {
											 jQuery('#aplica-filtro').attr('src','/ecolaudo/imagens/bt_atualizar_up.png');
										 }
								   }
								});  
							
							//$('.listagem_amostra .topo_listagem th div').animate({'top':'290px'},400);
							
							var curHeight = $('#header_oculta').height();
							$('#header_oculta').css('height','auto');
							var autoHeight = $('#header_oculta').height();
							$('#header_oculta').height(curHeight).animate({height: autoHeight}, 500);
							//$('.listagem_amostra .topo_listagem th div').animate({'top':($('.fundo').offset().top)+autoHeight+20},500);
						});			
		}


		//$('.listagem_amostra .topo_listagem th div').animate({'top':'290px'},400);
	});
	

	//PASTAS ------
	jQuery('.importar').click(function()
	{
		//alert('oi');	
		if( $(this).hasClass('btn_selected') )
		{
			$('#header_oculta').css('height','0px');
			$('.menu_nivel02 .btn_selected').removeClass('btn_selected');
			$(this).removeAttr('style');
		}else
		{
			jQuery('.amostra-email').removeAttr('style');
			jQuery('.exportar').removeAttr('style');
			jQuery('.filtro').removeAttr('style');
			jQuery('.pastas').removeAttr('style');
			jQuery(this).css({'background':' url(/ecolaudo/imagens/icon_upload_hover.png) no-repeat #F7941E' , 'color':'#fff'});

			$('.menu_nivel02 .btn_selected').removeClass('btn_selected');
			$(this).addClass('btn_selected');
			

			jQuery('.menu_nivel03 .content').load('/ecolaudo/includes/import_amostra.php',function()
			{
				
				$('.form_file').submit(function(event)
		        {
		            event.preventDefault();
		            var formData = new FormData(this);

		            $.ajax({
		                dataType:'json',
		                url: '/ecolaudo/model/model_import_file.php',
		                type: 'POST',
		                data: formData,
		                beforeSend: function() 
		                {
		                    $('.loading').css('display','block');
		                },
		                success: function (data) {
		                    if( data.rows == 1)
		                    {
		                        alerta_ok( data.message );     
		                        busca_ajax('','','','','','','', 'true');
		                    	$('.form_file input[type=file]').val('');
		                    }else
		                    {
		                        alerta_ok( data.error );     
		                    }
		                    //alert(data)
		                },
		                cache: false,
		                contentType: false,
		                processData: false
		                /*,
		                xhr: function() {  // Custom XMLHttpRequest
		                    var myXhr = $.ajaxSettings.xhr();
		                    if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
		                        myXhr.upload.addEventListener('progress', function () {
		                            /* faz alguma coisa durante o progresso do upload 
		                        }, false);
		                    }
		                return myXhr;
		                }*/
		            });
		        });
				
				var curHeight = $('#header_oculta').height();
				$('#header_oculta').css('height','auto');
				var autoHeight = $('#header_oculta').height();
				$('#header_oculta').height(curHeight).animate({height: autoHeight}, 500);
			});
			
			//jQuery('.menu_nivel03 .content').load(
		}
	});


	
	 //Ajax - Busca 
		//Busca Generica
		jQuery('.busca').keypress(function(event)
		{
			if( event.keyCode == 13 )
			{
				busca_ajax('','','', '', '', jQuery('[name="busca"]').val());
			}
		});
		jQuery('.btn-busca').click(function(event)
		{
			event.preventDefault();
			busca_ajax('','','', '', '', jQuery('[name="busca"]').val());
		});
		
		
		//Busca Inicial
		var folder = jQuery(location).attr('pathname').split('/');
		if( folder[1] == 'amostras' )
		{
			if( folder[2] != '' && folder[2] != undefined )
			{
				var url3 = folder[3];
				if( folder[3] == '' || folder[3] == undefined)
				{
					url3 = '1';
				}
				busca_ajax('','','','','','',url3, 'true');
			}else
			{
				busca_ajax('','','','','','','', 'true');
			}
		}

	setInterval(
			function()
			{
					jQuery('.calc_aguardando').each(function()
					{
						if( jQuery('.form_culturas').length > 0 )
						{
							return false;
						}
						var v_this = jQuery(this);

						v_this.parent('td').load('/ecolaudo/model/verifique_status_error.php?pk_samp_service='+v_this.attr('data-id'));
						return false;
					});
			},1500);
	


	/* Cadastro Amostra */
	/*$('.table_cadastro .salvar').click(function()
	{
		if( ($('input[name=data]').val()).length != 10 )
		{
			alerta_ok('O campo data precisa conter 10 digítos');
			return false;
		}

		$.ajax({
			dataType : 'json',
			url: '/ecolaudo/model/cadastro_amostra.php',
			data: $('.fundo_cadastro').serializeArray(),
			type:'post',
			beforeSend: function()
			{
				jQuery('.loading').css('display','block');
			},
			success: function(data)
			{
				if( data.error == 0 )
				{
					window.location.href ='http://'+window.location.hostname+'/amostras';
				}else
				{
					alerta('Algo deu errado. Erro '+ data.error )
				}
			}
		})
	});*/
	$('.fundo_cadastro .img .remove').click(function()
	{
		$('.fundo_cadastro .img img').attr('src','');	
		$('.fundo_cadastro .img input[name=remove_img]').val('1');
		$('.fundo_cadastro .img').css('display','none');

		$('.fundo_cadastro input[name=img_file]').get(0).value = '';
        $('.fundo_cadastro input[name=img_file]').get(0).type = '';
        $('.fundo_cadastro input[name=img_file]').get(0).type = 'file';
		

	});

	$('.fundo_cadastro input[type=file]').change(function(){
		readURL(this, '.img_preview');
		$('.fundo_cadastro .img input[name=remove_img]').val('0');
		$('.fundo_cadastro .img').css('display','inline-block');

		if( $(this).get(0).value == '' )
		{
			$(this).get(0).value = '';
	        $(this).get(0).type = '';
	        $(this).get(0).type = 'file';
	        $('.fundo_cadastro .img input[name=remove_img]').val('1');
	        $('.fundo_cadastro .img').css('display','none');
		}		
	});


	$('.table_cadastro .salvar').click(function()
	{
		if( ($('input[name=data]').val()).length != 10 )
		{
			alerta_ok('O campo data precisa conter 10 digítos');
			return false;
		}

		$('.fundo_cadastro').submit();		
	});

	$('.fundo_cadastro').submit(function(){

	    var formData = new FormData($(this)[0]);

	    $.ajax({
	    	dataType : 'json',
	        url: '/ecolaudo/model/cadastro_amostra.php',
	        type: 'POST',
	        data: formData,
	        async: false,
	        cache: false,
	        contentType: false,
	        processData: false,
	        beforeSend: function()
			{
				jQuery('.loading').css('display','block');
			},
			success: function(data)
			{
				if( data.error == 0 )
				{
					window.location.href ='http://'+window.location.hostname+'/amostras';
				}else
				{
					alerta('Erro ' + data.error + data.message )
				}
			}
	    });

	    return false;
	});



	$('.data_completa').keypress(function(event)
	{

		var qnt = $(this).val().length;
		var tecla = event.keyCode || event.charCode;
		if(  tecla == 8 )
			return true;

		if ( tecla < 48 || tecla > 57)
        	return false;


    	if( qnt == 2 || qnt == 5)
    		$(this).val( $(this).val() + '/' );

	});
	
	$('.table_cadastro .excluir').click(function()
	{
		var v_this = $(this);
		jQuery('.box_alert').html('<span>Deseja exluir essa amostra?</span> <div id="botao" class="bt_down sim" >Sim</div> <div id="botao" class="bt_down nao">Não</div>');
				jQuery('.loading').css({'display':'block','background':'rgba(0,0,0,0.05)','z-index':'0'});
				jQuery('.box_alert').fadeIn(1000);

						
				jQuery('.box_alert .sim').click(function()
				{
					jQuery('.box_alert').html('<p></p>');
					jQuery('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center rgba(0,0,0,0.05)','z-index':'9999'});
					//pastas('exc', {id : jQuery('.listagem-pastas .enabled').attr('data-id') , title : jQuery('.listagem-pastas .enabled').attr('data-title') })
					$.ajax({
						dataType : 'json',
						url: '/ecolaudo/model/delete_amostra.php',
						data: { samp_service : v_this.attr('data-id') },
						type:'post',
						beforeSend: function()
						{
							jQuery('.loading').css('display','block');
						},
						success: function(data)
						{
							if( data.error == 0 )
							{
								window.location.href ='http://'+window.location.hostname+'/amostras';
							}else
							{
								alerta('Algo deu errado. Erro '+ data.error )
							}
						}
					})
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

	$('.fundo_cadastro .campo_result').keypress(function(e)
	{
		var v_this = $(this);
		var tecla = ( window.event ) ? e.keyCode : e.which;
	    if ( tecla == 8 || tecla == 0 )
	        return true;
	    if ( tecla != 44 && tecla < 48 || tecla > 57 )
	        return false;	
	   	//console.log(v_this.val().indexOf(','));
	   	if((tecla == 44 || tecla == 110 || tecla == 188) && (v_this.val().indexOf(',') >= 0 ) )
	   	{
			return false;
	   	}
	});

	$('.fundo_cadastro .unity_textura').change(function()
	{
		var val = $(this).val();

		$('.fundo_cadastro .unity_textura').attr('checked','');
		$('.fundo_cadastro .unity_textura option[value='+val+']').attr('selected','selected');
	});

	$('.fundo_cadastro input').blur(function()
	{

		//alert($('.campo_result[data-rel=Argila]').val());
		//return false;
		jQuery.ajax({
			dataType:'json',
			url: '/ecolaudo/model/getRelations.php',
			data: {
					k_id   		: $('.campo_extrator[data-rel=K]').val(),
					k_unity 	: $('.campo_unity[data-rel=K]').val(),
					k_result 	: $('.campo_result[data-rel=K]').val(),
					ca_id  		: $('.campo_extrator[data-rel=Ca]').val(),
					ca_unity 	: $('.campo_unity[data-rel=Ca]').val(),
					ca_result 	: $('.campo_result[data-rel=Ca]').val(),
					mg_id		: $('.campo_extrator[data-rel=Mg]').val(),
				    mg_unity 	: $('.campo_unity[data-rel=Mg]').val(),
				    mg_value 	: $('.campo_result[data-rel=Mg]').val(),
				    hal_id 		: $('.campo_extrator[data-rel=HAl]').val(),
				    hal_unity 	: $('.campo_unity[data-rel=HAl]').val(),
				    hal_value 	: $('.campo_result[data-rel=HAl]').val(),
				    al_id 		: $('.campo_extrator[data-rel=Al]').val(),
				    al_unity 	: $('.campo_unity[data-rel=Al]').val(),
				    al_value 	: $('.campo_result[data-rel=Al]').val(),				    
				    na_id 		: $('.campo_extrator[data-rel=Na]').val(),
				    na_unity 	: $('.campo_unity[data-rel=Na]').val(),
				    na_value 	: $('.campo_result[data-rel=Na]').val(),
				    argila_id 	: $('.campo_extrator[data-rel=Argila]').val(),
				    argila_unity: $('.campo_unity[data-rel=Argila]').val(),
				    argila_value: $('.campo_result[data-rel=Argila]').val(),
				    silte_value : $('.campo_result[data-rel=Silte]').val()
				},
			type: 'POST',
			beforeSend: function() 
			{
				//jQuery('.loading').css('display','block');
				// setting a timeout
		       	// $(placeholder).addClass('loading');
	    	},
			success: function(data)
			{
				//parseFloat(conta.toFixed(1))
 				
				if( $('.campo_result[data-rel=Argila]').val() == '' && $('.campo_result[data-rel=Silte]').val() == '' )
				{
					data.areia_value = '';
				}else
				{
					if( data.areia_value == null || data.areia_value == undefined)
					{
						data.areia_value = 0;
					}else
					{
						$('.unity_textura option[value='+$('.campo_unity[data-rel=Argila]').val()+']').attr('selected','selected');
						data.areia_value = parseFloat(data.areia_value).toFixed(1);
					}
				}

				$('.campo_unity[data-rel=SB]').val(parseFloat(data.sb_unity).toFixed(0));
				$('.campo_result[data-rel=SB]').val(parseFloat((( data.sb_value == null || data.sb_value == undefined) ? 0 : data.sb_value)).toFixed(1));
				$('.campo_unity[data-rel=CTC]').val(parseFloat(data.ctc_unity).toFixed(0));
				$('.campo_result[data-rel=CTC]').val(parseFloat((( data.ctc_value == null || data.ctc_value == undefined) ? 0 : data.ctc_value)).toFixed(1));
				$('.campo_unity[data-rel=V]').val(parseFloat(data.v_unity).toFixed(0));
				$('.campo_result[data-rel=V]').val(parseFloat((( data.v_value == null || data.v_value == undefined) ? 0 : data.v_value)).toFixed(1));
				$('.campo_unity[data-rel=m]').val(parseFloat(data.m_unity).toFixed(0));
				$('.campo_result[data-rel=m]').val(parseFloat((( data.m_value == null || data.m_value == undefined) ? 0 : data.m_value)).toFixed(1));
				$('.campo_unity[data-rel=KnaCTC]').val(parseFloat(data.kctc_unity).toFixed(0));
				$('.campo_result[data-rel=KnaCTC]').val(parseFloat((( data.kctc_value == null || data.kctc_value == undefined) ? 0 : data.kctc_value)).toFixed(1));
				$('.campo_unity[data-rel=CanaCTC]').val(parseFloat(data.cactc_unity).toFixed(0));
				$('.campo_result[data-rel=CanaCTC]').val(parseFloat((( data.cactc_value == null || data.cactc_value == undefined) ? 0 : data.cactc_value)).toFixed(1));
				$('.campo_unity[data-rel=MgnaCTC]').val(parseFloat(data.mgctc_unity).toFixed(0));
				$('.campo_result[data-rel=MgnaCTC]').val(parseFloat((( data.mgctc_value == null || data.mgctc_value == undefined) ? 0 : data.mgctc_value)).toFixed(1));
				
				$('.campo_result[data-rel=AreiaTotal]').val(data.areia_value);
			}
		});
	});

	$('.fundo_cadastro select').change(function()
	{
		//alert($('.campo_result[data-rel=K]').val());
		//return false;
		jQuery.ajax({
			dataType:'json',
			url: '/ecolaudo/model/getRelations.php',
			data: {
					k_id   		: $('.campo_extrator[data-rel=K]').val(),
					k_unity 	: $('.campo_unity[data-rel=K]').val(),
					k_result 	: $('.campo_result[data-rel=K]').val(),
					ca_id  		: $('.campo_extrator[data-rel=Ca]').val(),
					ca_unity 	: $('.campo_unity[data-rel=Ca]').val(),
					ca_result 	: $('.campo_result[data-rel=Ca]').val(),
					mg_id		: $('.campo_extrator[data-rel=Mg]').val(),
				    mg_unity 	: $('.campo_unity[data-rel=Mg]').val(),
				    mg_value 	: $('.campo_result[data-rel=Mg]').val(),
				    hal_id 		: $('.campo_extrator[data-rel=HAl]').val(),
				    hal_unity 	: $('.campo_unity[data-rel=HAl]').val(),
				    hal_value 	: $('.campo_result[data-rel=HAl]').val(),
				    al_id 		: $('.campo_extrator[data-rel=Al]').val(),
				    al_unity 	: $('.campo_unity[data-rel=Al]').val(),
				    al_value 	: $('.campo_result[data-rel=Al]').val(),				    
				    na_id 		: $('.campo_extrator[data-rel=Na]').val(),
				    na_unity 	: $('.campo_unity[data-rel=Na]').val(),
				    na_value 	: $('.campo_result[data-rel=Na]').val(),
				    argila_id 	: $('.campo_extrator[data-rel=Argila]').val(),
				    argila_unity: $('.campo_unity[data-rel=Argila]').val(),
				    argila_value: $('.campo_result[data-rel=Argila]').val(),
				    silte_value : $('.campo_result[data-rel=Silte]').val()
				},
			type: 'POST',
			beforeSend: function() 
			{
				//jQuery('.loading').css('display','block');
				// setting a timeout
		       	// $(placeholder).addClass('loading');
	    	},
			success: function(data)
			{
				if( $('.campo_result[data-rel=Argila]').val() == '' && $('.campo_result[data-rel=Silte]').val() == '' )
				{
					data.areia_value = '';
				}else
				{
					if( data.areia_value == null || data.areia_value == undefined)
					{
						data.areia_value = 0;
					}else
					{
						$('.unity_textura option[value='+$('.campo_unity[data-rel=Argila]').val()+']').attr('selected','selected');
						data.areia_value = parseFloat(data.areia_value).toFixed(1);
					}
				}
				
				$('.campo_unity[data-rel=SB]').val(parseFloat(data.sb_unity).toFixed(0));
				$('.campo_result[data-rel=SB]').val(parseFloat((( data.sb_value == null || data.sb_value == undefined) ? 0 : data.sb_value)).toFixed(1));
				$('.campo_unity[data-rel=CTC]').val(parseFloat(data.ctc_unity).toFixed(0));
				$('.campo_result[data-rel=CTC]').val(parseFloat((( data.ctc_value == null || data.ctc_value == undefined) ? 0 : data.ctc_value)).toFixed(1));
				$('.campo_unity[data-rel=V]').val(parseFloat(data.v_unity).toFixed(0));
				$('.campo_result[data-rel=V]').val(parseFloat((( data.v_value == null || data.v_value == undefined) ? 0 : data.v_value)).toFixed(1));
				$('.campo_unity[data-rel=m]').val(parseFloat(data.m_unity).toFixed(0));
				$('.campo_result[data-rel=m]').val(parseFloat((( data.m_value == null || data.m_value == undefined) ? 0 : data.m_value)).toFixed(1));
				$('.campo_unity[data-rel=KnaCTC]').val(parseFloat(data.kctc_unity).toFixed(0));
				$('.campo_result[data-rel=KnaCTC]').val(parseFloat((( data.kctc_value == null || data.kctc_value == undefined) ? 0 : data.kctc_value)).toFixed(1));
				$('.campo_unity[data-rel=CanaCTC]').val(parseFloat(data.cactc_unity).toFixed(0));
				$('.campo_result[data-rel=CanaCTC]').val(parseFloat((( data.cactc_value == null || data.cactc_value == undefined) ? 0 : data.cactc_value)).toFixed(1));
				$('.campo_unity[data-rel=MgnaCTC]').val(parseFloat(data.mgctc_unity).toFixed(0));
				$('.campo_result[data-rel=MgnaCTC]').val(parseFloat((( data.mgctc_value == null || data.mgctc_value == undefined) ? 0 : data.mgctc_value)).toFixed(1));
				$('.campo_result[data-rel=AreiaTotal]').val(data.areia_value);
			}
		});
	});




});

//FUNÇÃO DE BUSCA DO AJAX
function busca_ajax(interessado, fazenda, tipo_amostras, data_desde, data_ate, generico,  pagina, atupagina )
{
	var folder = jQuery(location).attr('pathname').split('/');
	//alert( folder );
	
	jQuery.ajax({
		dataType:'json',
		url: '/ecolaudo/includes/index_amostras_ajax.php',
		data: {
				web_interessado	: interessado,
				web_fazenda 	: fazenda,
				web_amostras	: tipo_amostras,
				data_desde		: data_desde,
				data_ate		: data_ate,
				pagina			: pagina,
				generico		: generico,
				folder			: folder[2],
				atupagina		: atupagina
			},
		type: 'POST',
		//context: jQuery('#resultado'),
		beforeSend: function() 
		{
			jQuery('.loading').css('display','block');
		// setting a timeout
       	// $(placeholder).addClass('loading');
    	},
		success: function(data)
		{
			if( jQuery('.box_alert').css('display') == 'none' )
			{
				jQuery('.loading').css('display','none');
			}
			//data.html = utf8_decode(data.html);
			//alert(data.html);
			if(pagina)
			{
				var maior = parseInt(pagina) + 1;
				var menor = parseInt(pagina) - 1;
				jQuery('.current_page').val(pagina);
				jQuery('.previous_pag').attr('data-value',menor);
				jQuery('.next_pag').attr('data-value',maior);
			}else
			{
				jQuery('.current_page').val(1);
				jQuery('.previous_pag').attr('data-value',0);
				jQuery('.next_pag').attr('data-value',2);
			}
			

			//Paginas
			var pag_atual = jQuery('.current_page').val();
			
			if( data.qnt_total == null || data.qnt_total == undefined )
			{
				var total_pags = $('.all').html();
			}else
			{
				var total_pags = Math.ceil((data.qnt_total/50));
			}


			if(total_pags == 0)
			{
				total_pags = 1;
			}


			//Testa botão previous
			if( pag_atual > 1 )
			{
				jQuery('.previous_pag').removeClass('disabled');
				jQuery('.previous_pag').addClass('enabled');
			}else
			{
				jQuery('.previous_pag').addClass('disabled');
				jQuery('.previous_pag').removeClass('enabled');
			}

			//Testa botão next
			if( parseInt(pag_atual) < parseInt(total_pags) )
			{
				jQuery('.next_pag').removeClass('disabled');
				jQuery('.next_pag').addClass('enabled');
			}else
			{
				jQuery('.next_pag').addClass('disabled');
				jQuery('.next_pag').removeClass('enabled');
			}
			
			
			//$('.current').html(pag_atual);	
			$('.all').html(total_pags);
			$('.pagina').val('');
			$('.pagina').attr('placeholder',pag_atual);
			$('.pagina').blur();
			//$('.all').attr('data-id',total_pags);
			$('#conteudo_tabela').html(data.html);
			//alert(data);
		},
		complete: function(data)
		{
			$('.topo_listagem tr th').each(function( index )
            {
                //alert($(this).css('width') + '---' + index);
                $('.fundo table thead tr th:nth-child('+(index+1)+')').css('width', $(this).css('width'));   
            });

			var url2 = folder[2];
			if( folder[2] == '' || folder[2] == undefined)
			{
				url2 = 'caixadeentrada';
			}
			/*var url3 = folder[3];
			if( folder[3] == '' || folder[3] == undefined)
			{
				url3 = '1';
			}

			alert(url3);*/

			window.history.pushState('obj', 'newtitle', '/amostras/' + url2 + '/' + jQuery('.current_page').val());


			jQuery('.editar_amostra').click(function()
			{
				var data_rel = jQuery(this).attr('data-rel');
				jQuery.ajax({
					dataType:'json',
					url: '/ecolaudo/model/count_amostras.php',
					data: {
							'samp_service' : data_rel
						},
					type: 'GET',
					beforeSend: function() 
					{
						jQuery('.loading').css('display','block');
			    	},
					success: function( data )
					{
						if( data.error == 0 )
						{
							window.location.href ='http://'+window.location.hostname+'/cadastro/'+ data_rel;
						}else
						{
							alerta_ok(data.message);
						}
					}
				});
				
			});

			jQuery('#conteudo_tabela tr td a').click(function(event)
			{
				event.preventDefault();
				var url_var = '/ecolaudo/relatorio.php?web_id_relatorio=';
				
				if( ! jQuery(this).hasClass('blocked') )
				{
					var userAgent = navigator.userAgent.toLowerCase();
						if( userAgent.search(/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i)!= -1 )
						{
							window.open(url_var+jQuery(this).attr('data-ajax') + '&save=D',"_blank");	
						}else
						{
							jQuery('.modal').html('<iframe src="' + url_var + jQuery(this).attr('data-ajax') +'" allow="fullscreen" frameborder="0"></iframe>');
							jQuery('.modal').fadeIn('slow');
						}
				}
				 //jQuery(".conteudo").unbind("touchmove");
				//jQuery('#conteudo').css('overflow','hidden');
				//jQuery('iframe').css('height','auto');
				//jQuery('.modal').css('overflow-y','scroll');
				//jQuery('#conteudo').unbind('scroll');
			});

			/*jQuery('#conteudo_tabela tr td').click(function(event)
			{
				event.preventDefault();
				var url_var = '/ecolaudo/relatorio.php?web_id_relatorio=';
				

				if( jQuery(this).has('a').length == 1 )
				{
					if( ! jQuery(this).children('a').hasClass('blocked') )
					{
						var userAgent = navigator.userAgent.toLowerCase();
							if( userAgent.search(/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i)!= -1 )
							{
								window.open(url_var+jQuery(this).children('a').attr('data-ajax') + '&save=D',"_blank");	
							}else
							{
								jQuery('.modal').html('<iframe src="' + url_var + jQuery(this).children('a').attr('data-ajax') +'" allow="fullscreen" frameborder="0"></iframe>');
								jQuery('.modal').fadeIn('slow');
							}
					}
				}else
				{
					return true;
				}

				 //jQuery(".conteudo").unbind("touchmove");
				//jQuery('#conteudo').css('overflow','hidden');
				//jQuery('iframe').css('height','auto');
				//jQuery('.modal').css('overflow-y','scroll');
				//jQuery('#conteudo').unbind('scroll');
			});*/


			jQuery('.modal').click(function()
			{
				//alert('touch');
				jQuery('.modal').fadeOut('slow',function(){
					jQuery('.modal').html('');
					//jQuery('#conteudo_tabela').bind('scroll');
				});
			});



			jQuery('.recomendar').click(function(event)
			{
				//alert('oi');
				event.preventDefault();
				
				var btn_clicado = jQuery(this);
				//alert(jQuery(this).attr('data-id'));
				jQuery('.box_alert').load('/ecolaudo/formulario.php?data-id=' + jQuery(this).attr('data-id'), function()
				{
					//alert(btn_clicado.attr('class'));

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

																//console.log(arredondamento[0]);
																jQuery('input[name=plantas-ha]').val(
																	arredondamento[0]
										     			    	  );
															}
														}
													});

													jQuery('.btn_enviar').click(function(event)
													{
														//alert('aqui');
														//alerta( jQuery('.form_culturas').serializeArray() );
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
																	jQuery('.btn_enviar').css('display','inline-block');																	if( data.result == 1 ) 
																	{
																		//alert('Recomendação gravada com sucesso, aguarde a mesma ser gerada.');
																		jQuery('.loading').fadeOut('slow',function(){
																			jQuery('.loading').html('');
																			jQuery('.box_alert').fadeOut('slow');
																			jQuery('.box_alert').html('');
																			//jQuery('#conteudo_tabela').bind('scroll');
																		});
																		/*btn_clicado.parent('td').children('.rec_editar').remove();
																		btn_clicado.parent('td').children('.calc_aguardando').remove();
																		btn_clicado.parent('td').children('.calc_erro').remove();
																		btn_clicado.parent('td').append('<div class="calc_aguardando"></div>');
																		btn_clicado.parent('td').addClass('status-on');*/
																		btn_clicado.parent('td').load('/ecolaudo/model/verifique_status_error.php?pk_samp_service='+jQuery('.form_culturas input[name=hidden_classe_data_id]').val());
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
			
					jQuery('.btn_cancel').click(function()
					{
						//alert('touch');
						jQuery('.loading').fadeOut('slow',function(){
							jQuery('.loading').html('');
							jQuery('.box_alert').fadeOut('slow', function()
							{
								jQuery('.box_alert').html('');
							});

							//jQuery('#conteudo_tabela').bind('scroll');
						});
					});


					jQuery('.box_alert').css({'height': 'auto', 'width' : 'auto'});
					jQuery('.box_alert').fadeIn(1000);
				} );
				
				//jQuery('.box_alert').css('top','calc( 40% - ' + jQuery('.box_alert').height() + ')');
				jQuery('.loading').css({'display':'block','background-image':'rgba(0,0,0,0.05)','z-index':'0'});
				
				
				
				event.stopImmediatePropagation();
			});

			jQuery('.calc_erro').click(function(event)
			{
				//event.stopPropagation();
				//alerta(jQuery(this).attr('data-id'));
				var v_this = jQuery(this);
				jQuery('.box_alert').html(v_this.attr('data-rel') + '<br><br><span>Deseja exluir essa recomendação?</span> <div id="botao" class="bt_down sim" >Sim</div> <div id="botao" class="bt_down nao">Não</div>');
				jQuery('.loading').css({'display':'block','background':'rgba(0,0,0,0.05)','z-index':'0'});
				
				
				//alert($('.box_alert').css('margin-top'));

				jQuery('.box_alert').fadeIn(1000);

				//jQuery('.box_alert').css('left','calc(50% - ' + $('.box_alert').width()/2 + ' )')				

						
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


									/*if( data == null )
									{
										v_this.parent('td').load('/ecolaudo/model/verifique_status_error.php?pk_samp_service='+v_this.attr('data-id'));
										return false;
									}else if( data.result == null )
									{
										v_this.parent('td').load('/ecolaudo/model/verifique_status_error.php?pk_samp_service='+v_this.attr('data-id'));
										return false;
									}else
									{
										v_this.parent('td').html(data.result);
									}*/
									//v_this.parent('td').html(data.result);
									//v_this.parent('td').append('<span class="calc_aguardando" data-id="'+ v_this.attr('data-id') + '" style="width:0px; height:0px;>&nbsp;</span>');
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

				//alert(url3);
				
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
						jQuery('.loading').css('display','none');
						//alert('oi');
						jQuery('.box_recomendacao').html(data);
						jQuery('.box_recomendacao').css('height',($(window).height()-105)+'px');


					}
				});


				event.stopImmediatePropagation();
				//jQuery('body').append('<form class="form_action_envio" method="post" action="/template"><input type="hidden" name="last_url" value="/amostras/'+ url2 +'/'+url3+'"><input type="hidden" name="pk_samp_service" value="'+ jQuery(this).attr('data-id') +'"><input type="hidden" name="rec_id" value="'+ jQuery(this).attr('data-value') +'"></form>');
				//jQuery('.form_action_envio').submit();
			});


			//Paginação
			jQuery('.disabled').click(function(event)
			{
				event.preventDefault();
			});
			
			jQuery('.pagination .enabled').click(function(event)
			{
				if( ( jQuery(this).attr('data-value') >= 1 ) && ( jQuery(this).attr('data-value') <= parseInt(jQuery('.all').text()) ) ){
					var interessado = jQuery('[name="web_interessado"]').val() == 'Interessado...' ? '' : jQuery('[name="web_interessado"]').val();
					
					var fazenda = jQuery('[name="web_fazenda"]').val() == 'Propriedade...' ? '' : jQuery('[name="web_fazenda"]').val();
					
					var amostras = jQuery('[name="web_amostras"]').val() == 'Tipo de Amostra...' ? '' : jQuery('[name="web_amostras"]').val();  
					
					var desde = jQuery('[name="data_desde"]').val() == 'Desde...' ? '' : jQuery('[name="data_desde"]').val(); 
					
					var ate = jQuery('[name="data_ate"]').val() == 'Até...' ? '' : jQuery('[name="data_ate"]').val();
					
					var busca = jQuery('[name="busca"]').val() == 'Procure uma amostra ...' ? '' : jQuery('[name="busca"]').val();
					
					busca_ajax(
								interessado,
								fazenda,
								amostras,  
								desde, 
								ate,
								busca,
								jQuery(this).attr('data-value')
								);
				}
				event.stopImmediatePropagation();
			});
			

			$('.pagina').keypress(function(event)
			{
				//alert(event.keyCode);
				if( event.keyCode == 13 )
				{
					if( ( $(this).val() >= 1 ) && ( $(this).val() <= parseInt($('.all').text()) ) ){
						var interessado = $('[name="web_interessado"]').val() == 'Interessado...' ? '' : $('[name="web_interessado"]').val();
						
						var fazenda = $('[name="web_fazenda"]').val() == 'Propriedade...' ? '' : $('[name="web_fazenda"]').val();
						
						var amostras = $('[name="web_amostras"]').val() == 'Tipo de Amostra...' ? '' : $('[name="web_amostras"]').val();  
						
						var desde = $('[name="data_desde"]').val() == 'Desde...' ? '' : $('[name="data_desde"]').val(); 
						
						var ate = $('[name="data_ate"]').val() == 'At?..' ? '' : $('[name="data_ate"]').val();
						
						var busca = $('[name="busca"]').val() == 'Procure uma amostra ...' ? '' : $('[name="busca"]').val();
						
						busca_ajax(
									interessado,
									fazenda,
									amostras,  
									desde, 
									ate,
									busca,
									$(this).val()
									);
					}else{
						alerta('Página não encontrada.');
					}
				}
				event.stopImmediatePropagation();
			});

			$('#conteudo').animate({scrollTop:0}, 100);				
		}
	}); 
}

//FUNÇOES PARA PASTAS 
function pastas( acao, parametros )
{	
	jQuery.ajax({
		dataType:'json',
		url: '/ecolaudo/model/model_pastas.php',
		data: {
				acao		: acao,
				parametro 	: parametros
			},
		type: 'POST',
		//context: jQuery('#resultado'),
		beforeSend: function() 
		{
        	jQuery('.loading').css('display','block');
		// setting a timeout
       	// $(placeholder).addClass('loading');
    	},
		success: function(data)
		{
			//jQuery('.loading').css('display','none');
			if( data.rows )
			{
				if( data.acao == 1 )
				{
					if( data.error )
					{
						alerta_ok( data.message );
						return false;
					}

					jQuery('.lista_pasta').append(
										'<li><div id="botao" class="bt_down fonte_padrao" data-id="'+ data.parametros.pk_web_users_folders + '">'+ data.parametros.folder_name +'</div></li>'
										);
					
					jQuery('.listagem-pastas ul').append(
							'<li><div id="botao" class="bt_down fonte_padrao" data-id="'+ data.parametros.pk_web_users_folders +
								'" data-title="' + data.parametros.folder_name.replace(' ', '').toLowerCase() +
								'">' + data.parametros.folder_name + '</div></li>');
								
								alerta( 'Cadastrado com sucesso' );		
					
								jQuery('input[name=novo]').val('');
				
				}else if( data.acao == 2 )
				{
					alerta( 'As amostras selecionadas foram movidas com sucesso !' );
					busca_ajax();
					
				}else if( data.acao == 3 )
				{
					jQuery('[data-id="' + jQuery('.listagem-pastas .enabled').attr('data-id') + '"]').remove();
					jQuery('.listagem-pastas .bt_down').remove('.enabled');
					
					jQuery('.listagem-pastas div[data-title="caixadeentrada"]').addClass('enabled');
					window.history.pushState('obj', 'newtitle', '/amostras/');
					busca_ajax();
					
					alerta( 'Excluido com sucesso !' );
				}
			
			}else
			{
				if( data.error )
				{
					alerta('Não pode ser feita a exclusão da pastas com amostras.');
				}else
				{
					alerta( 'Erro !' );
				}
			}
			
		}, complete:function(data)
		{
			jQuery('.listagem-pastas .bt_down').click(function()
				{
					//alert('po');
					jQuery('.listagem-pastas .bt_down').removeClass('enabled');
					
					jQuery(this).addClass('enabled');
					window.history.pushState('obj', 'newtitle', '/amostras/' + retira_acentos(jQuery(this).attr('data-title')));
					busca_ajax();
					//alert('oi');
				});
				
			jQuery('.lista_pasta .bt_down').click(function()
				{
					var i = 0;
					var comparativo = jQuery(this).attr('data-id');
					var checks = new Array();
					 checks[0] = jQuery(this).attr('data-id');
					 
					jQuery('.check_').each(function(index, element) 
					{
						i++;
						if( jQuery(this).attr("checked") == "checked" )
						{
							checks.push(jQuery(this).attr('data-ajax'));
						}
						
						if( i == jQuery( ".check_" ).length && i != 1 )
						{
							if( checks != comparativo )
							{
								pastas('mov', checks );
							}else
							{
								alerta( 'Selecione pelo menos 1 amostra.'  );
							}
						}
					});
				});
		}
	});
	
}

function amostras_email( email, parametros )
{
	jQuery.ajax({
		dataType:'json',
		url: '/ecolaudo/model/model_amostra_email.php',
		data: {
				email		: email,
				parametro 	: parametros
			},
		type: 'POST',
		//context: jQuery('#resultado'),
		success: function( data )
		{
			if( data.error )
			{
				alerta( data.error );
			}else
			{
				alerta( 'Amostras copiadas com sucesso.' );
			}
		}
	});
}

function alerta( mensagem )
{
	jQuery('.box_alert').html( '<p>' + mensagem + '</p>' );
	jQuery('.loading').css({'display':'block','background':'rgba(0,0,0,0.05)','z-index':'0'});
	jQuery('.box_alert').fadeIn(1000);
	setTimeout(function(){
	jQuery('.box_alert').fadeOut(	
						1000,
						function()
						{
							jQuery('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center rgba(0,0,0,0.05)','z-index':'9999'});
							jQuery('.box_alert').html('');
						})
				},2500);

}

function utf8_decode(str_data) {
  //  discuss at: http://phpjs.org/functions/utf8_decode/
  // original by: Webtoolkit.info (http://www.webtoolkit.info/)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Norman "zEh" Fuchs
  // bugfixed by: hitwork
  // bugfixed by: Onno Marsman
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: kirilloid
  // bugfixed by: w35l3y (http://www.wesley.eti.br)
  //   example 1: utf8_decode('Kevin van Zonneveld');
  //   returns 1: 'Kevin van Zonneveld'

  var tmp_arr = [],
    i = 0,
    c1 = 0,
    seqlen = 0;

  str_data += '';

  while (i < str_data.length) {
    c1 = str_data.charCodeAt(i) & 0xFF;
    seqlen = 0;

    // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
    if (c1 <= 0xBF) {
      c1 = (c1 & 0x7F);
      seqlen = 1;
    } else if (c1 <= 0xDF) {
      c1 = (c1 & 0x1F);
      seqlen = 2;
    } else if (c1 <= 0xEF) {
      c1 = (c1 & 0x0F);
      seqlen = 3;
    } else {
      c1 = (c1 & 0x07);
      seqlen = 4;
    }

    for (var ai = 1; ai < seqlen; ++ai) {
      c1 = ((c1 << 0x06) | (str_data.charCodeAt(ai + i) & 0x3F));
    }

    if (seqlen == 4) {
      c1 -= 0x10000;
      tmp_arr.push(String.fromCharCode(0xD800 | ((c1 >> 10) & 0x3FF)), String.fromCharCode(0xDC00 | (c1 & 0x3FF)));
    } else {
      tmp_arr.push(String.fromCharCode(c1));
    }

    i += seqlen;
  }

  return tmp_arr.join("");
}


function retira_acentos(newStringComAcento ){
  var string = newStringComAcento;
	var mapaAcentosHex 	= {
		a : /[\xE0-\xE6]/g,
A : /[\xC0-\xC6]/g,
e : /[\xE8-\xEB]/g,
E : /[\xC8-\xCB]/g,
i : /[\xEC-\xEF]/g,
I : /[\xCC-\xCF]/g,
o : /[\xF2-\xF6]/g,
O : /[\xD2-\xD6]/g,
u : /[\xF9-\xFC]/g,
U : /[\xD9-\xDC]/g,
c : /\xE7/g,
C : /\xC7/g,
n : /\xF1/g,
N : /\xD1/g,
	};

	for ( var letra in mapaAcentosHex ) {
		var expressaoRegular = mapaAcentosHex[letra];
		string = string.replace( expressaoRegular, letra );
	}

	return string;
}


function alerta_ok( mensagem )
{
	jQuery('.box_alert').html( '<p>' + mensagem + '</p> <br> <div id="botao" class="bt_down ok">Ok</div>' );
	jQuery('.loading').css({'display':'block','background':'rgba(0,0,0,0.05)','z-index':'0'});
	jQuery('.box_alert').fadeIn(1000);
	jQuery('.box_alert .ok').click(function()
				{ 
					jQuery('.box_alert').fadeOut(	
						1000,
						function()
						{
							jQuery('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center rgba(0,0,0,0.05)','z-index':'9999'});
							jQuery('.box_alert').html('<p></p>');
						});
							
				});

}

function readURL(input, v_class) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(v_class).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }else{
    	$(v_class).attr('src', '');
    }
    
}