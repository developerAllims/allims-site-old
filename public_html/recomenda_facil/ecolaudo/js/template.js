jQuery(document).ready(function()
{
	jQuery('.adjoined-bottom').css('width', jQuery('.informacoes').width());

	jQuery('#menu_solo').click(function(event)
	{
		if( jQuery(this).hasClass('selected') )
		{
			return false;
		}

		jQuery(this).addClass('selected');
		jQuery('#menu_recomendacao').removeClass('selected');

		jQuery('.table_folha').css('display','none');
		jQuery('.table_solo').css('display','block');
	});

	jQuery('#menu_recomendacao').click(function(event)
	{
		if( jQuery(this).hasClass('selected') )
		{
			return false;
		}

		jQuery(this).addClass('selected');
		jQuery('#menu_solo').removeClass('selected');

		jQuery('.table_folha').css('display','block');
		jQuery('.table_solo').css('display','none');

	});

	//jQuery('.resultados table tbody').css('height', jQuery('.box_recomendacao').height());

	jQuery('.resultados table.table_solo tbody tr td:nth-child(3)').css({'width':jQuery('.resultados table.table_solo thead tr div:nth-child(3)').width()+6, 'padding' : '3px 1px 0px 1px'} );

	//alert(jQuery('.resultados table tbody tr td:first').width());
	jQuery('.resultados table.table_solo thead tr div:first').css({'width':jQuery('.resultados table tbody tr td:first').width()+5, 'padding' : '3px 1px 0px 1px'});
	jQuery('.resultados table.table_solo thead tr div:nth-child(1)').css({'width':jQuery('.resultados table tbody tr td:first').width()+7, 'padding' : '3px 1px 0px 1px'});
	jQuery('.resultados table.table_solo thead tr div:nth-child(2)').css({'width':jQuery('.resultados table tbody tr td:first').width()+7, 'padding' : '3px 1px 0px 1px'});
	jQuery('.resultados table.table_solo thead tr div:nth-child(3)').css({'padding' : '3px 1px 0px 1px'});


	if( jQuery('#menu_recomendacao').hasClass('selected') )
	{
		jQuery('.table_folha').css('display','block');
		jQuery('.table_solo').css('display','none');
	}

	jQuery('.pre_visualizar').click(function()
	{

		jQuery.ajax({
			dataType:'json',
			url: '/ecolaudo/model/update_template.php',
			data: {
					'id'		 : jQuery('input[name=id]').val(),
					'amostra'	 : jQuery('input[name=amostra]').val(), 
					'tags_html'	 : jQuery('.cke_contents iframe').contents().find('.cke_editable').html()
				},
			type: 'POST',
			beforeSend: function() 
			{
				jQuery('.loading').css('display','block');
			},
			success: function( data )
			{
				if( data.error == 1 )
				{
					alerta( 'Não foi possivel salvar a modificação' );
				}else
				{					
					jQuery('.modal').html('<iframe name="preview_impressao" class="preview_impressao" src="/ecolaudo/resultado_preview.php?pk_samp_service='+jQuery('.pre_visualizar').attr('data-id')+'&rec_id='+jQuery('input[name=id]').val()+'" frameborder="0"></iframe>');
					jQuery('.modal iframe').css('width','220mm');
					jQuery('.modal').fadeIn('slow');
					jQuery('iframe.preview_impressao').load(function()
					{
						jQuery(this).contents().find(".fechar_iframe").on('click', function(event) 
						{ 
							jQuery('.modal').fadeOut('slow',function()
							{
								jQuery('.modal').html('');
								jQuery('.loading').css('display','none');
							}); 
						});	
					})
				}
			}
		});
		
	});

	jQuery('.pre_close').click(function()
	{
		jQuery('.box_alert').html('<span>Deseja realmente excluir essa recomenda&ccedil;&atilde;o?</span> <div id="botao" class="bt_down sim" >Sim</div> <div id="botao" class="bt_down nao">N&atilde;o</div>');
		jQuery('.loading').css({'display':'block','background':'#000','z-index':'9998'});
		jQuery('.box_alert').fadeIn(1000);

				
		jQuery('.box_alert .sim').click(function()
		{
			jQuery('.box_alert').html('<p></p>');
			jQuery('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center #000','z-index':'9999'});
			//pastas('exc', {id : jQuery('.listagem-pastas .enabled').attr('data-id') , title : jQuery('.listagem-pastas .enabled').attr('data-title') })
			jQuery.ajax({
				dataType:'json',
				url: '/ecolaudo/model/delete_recomendacao.php',
				data: {
						'id'		 : jQuery('input[name=id]').val(),
						'amostra'	 : jQuery('input[name=amostra]').val()
					},
				type: 'POST',
				success: function( data )
				{
					if( data.acao == 0 )
					{
						alerta( 'Não foi possivel excluir a recomendação' );
					}else
					{
						//alert('button[data-id='+jQuery('input[name=amostra]'));
						jQuery('.box_alert').css('display','none');
						$('button[data-id='+jQuery('input[name=amostra]').val()+']').parent().load('/ecolaudo/model/verifique_status_error.php?pk_samp_service='+jQuery('input[name=amostra]').val());
						$('.box_recomendacao').removeAttr('style');
						$('.box_recomendacao').html('');
						//location.href = $('.pre_cancelar').attr('href');
					}
				}
			});
		});
		
		
		jQuery('.box_alert .nao').click(function()
		{ 
			jQuery('.box_alert').fadeOut(	
				1000,
				function()
				{
					jQuery('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center #000','z-index':'9999'});
					jQuery('.box_alert').html('<p></p>');
				});
					
		});
	});


	jQuery('.pre_cancelar').click(function()
	{
		
		$('.box_recomendacao').html('');
		$('.box_recomendacao').removeAttr('style');
		
	});


	jQuery('.pre_salvar').click(function()
	{

		jQuery.ajax({
			dataType:'json',
			url: '/ecolaudo/model/update_template.php',
			data: {
					'id'		 : jQuery('input[name=id]').val(),
					'amostra'	 : jQuery('input[name=amostra]').val(), 
					'tags_html'	 : jQuery('.cke_contents iframe').contents().find('.cke_editable').html()
				},
			type: 'POST',
			success: function( data )
			{
				if( data.error == 1 )
				{
					alerta( 'Não foi possivel salvar a modificação' );
				}else
				{
					//alert('oi2');
					$('.box_recomendacao').html('');
					$('.box_recomendacao').removeAttr('style');
					//location.href = $('.pre_cancelar').attr('href');
					//window.location.href = $('.pre_cancelar').attr('href');
				}
			}
		});
		
	});
	

	$('.abrir_texto').click(function()
	{
		if( $('.oculto').css('display') == 'block' )
		{
			$('.oculto').css('display','block');
		}else
		{
			$('.oculto').css('display','none');
		}
	});

	jQuery('.modal').click(function()
	{
		//alert('touch');
		jQuery('.modal').fadeOut('slow',function(){
			jQuery('.modal').html('');
			jQuery('.loading').css('display','none');
			//jQuery('#conteudo_tabela').bind('scroll');
		});
	});
})