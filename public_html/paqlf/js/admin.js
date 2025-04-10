$(document).ready(function()

{	

	$('body').click(function(event)

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

	

	$('.readonly').click(function(event)

	{

		return false;

	});

	

	$('input:checkbox').change(function()

	{

		if( $(this).attr('checked') == 'checked' )

		{

			$(this).attr('checked',true);

			$(this).parent('td').find('label').css({'background-image':"url('/images/ico_check_on.png')"});

		}else

		{

			$(this).attr('checked',false);

			$(this).parent('td').find('label').css({'background-image':"url('/images/ico_check_off.png')"});

		}

	});



	$('.logout').click(function(event)

	{

		location.href="/";

	});





	$('.abas a').click(function(event)

	{

		if( $(this).hasClass('selected') )

		{

			return false;

		}

		$('.abas a').removeClass('selected');

		$(this).addClass('selected');

			$.ajax({

			dataType:'html',

			url:'/inc/list_avaliacao.php',

			type:'GET',

			data: { 'id' : $(this).attr('data-id') },

			beforeSend: function()

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			},

			success: function( data )

			{				

				$('.modal').remove();

				$('.avaliacao tbody').html(data);

			}

		});		



	});



	$('.usuarios .excluir').click(function(event)

	{

		var div = $(this);



		if(confirm('Deseja Excluir Este Usuário?') )

		{

			$.ajax({

				dataType:'json',

				url:'/modal/user_excluir.php',

				type:'GET',

				data: {'data' : $(this).attr('data-rel'), 'id' : $(this).attr('data-id')},

				beforeSend: function() 

				{

					$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				},

				success: function( data )

				{

					if( data.error == 1 )

					{

						alerta(data.frase);

					}else

					{

						alerta('Exclusão Efetuada com Sucesso');

						div.parent().parent().animate({ "height" : "0px", "display" : "none"},1000,function()

						{

							$(this).remove();

						});

					}

				}

			});		

		}

	});



	$('.novo_usuario .salvar').click(function(event)

	{

		var usuario = $('.input_email').val().substring(0, $('.input_email').val().indexOf("@"));

		var dominio = $('.input_email').val().substring($('.input_email').val().indexOf("@")+ 1, $('.input_email').val().length);

		if ((usuario.length >=1) &&

		    (dominio.length >=3) && 

		    (usuario.search("@")==-1) && 

		    (dominio.search("@")==-1) &&

		    (usuario.search(" ")==-1) && 

		    (dominio.search(" ")==-1) &&

		    (dominio.search(".")!=-1) &&      

		    (dominio.indexOf(".") >=1)&& 

		    (dominio.lastIndexOf(".") < dominio.length - 1))

		{

			

			$(this).blur();

			$.ajax({

				dataType:'json',

				url:'/modal/user_cad.php',

				type:'POST',

				data: $('.novo_usuario').serializeArray(),

				beforeSend: function()

				{

					$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				},

				success: function( data )

				{

					if( data.error )

					{

						alerta('Erro de cadastro');

					}else

					{

						location.href="/usuario";

					}

				}

			});	

		

		}else

		{

			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			alerta('Email Inválido');

			$(this).on('click');

			$('.input_email').focus();			

		}



	});



	$('.alt_lab button').click(function(event)

	{

		$(this).blur();

		$.ajax({

			dataType:'json',

			url:'/modal/lab_alt.php',

			type:'POST',

			data: $('.alt_lab').serializeArray(),

			beforeSend: function() 

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				//$('.modal').focus();

			},

			success: function( data )

			{

				alerta(data.frase);

				/*if( data.rows )

				{

					alerta('Alteração Realizada com Sucesso');

				}else

				{

					alerta('Alteração não Realizada');

				}*/

				

			}

		});		

	});



	$('.alterar_usuario #troca_senha').change(function()

	{

		if( $(this).attr('checked') == 'checked' )

		{

			$('input[name=senha]').attr('readonly',false);

			$('input[name=re-senha]').attr('readonly',false);

			$('input[name=senha]').focus();

		}else

		{

			$('input[name=senha]').val('');

			$('input[name=re-senha]').val('');

			$('input[name=senha]').attr('readonly',true);

			$('input[name=re-senha]').attr('readonly',true);

		}

	});



	$('.alterar_usuario button').click(function(event)

	{

		if( $('#troca_senha').attr('checked') == 'checked' )

		{

			if( ($('input[name=senha]').val().length > 5) )

			{

				if( $('input[name=senha]').val() == $('input[name=re-senha]').val() ) 

				{

					$(this).blur();

					$.ajax({

						dataType:'json',

						url:'/modal/user_alt.php',

						type:'POST',

						data: $('.alterar_usuario').serializeArray(),

						beforeSend: function() 

						{

							$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

							

						},

						success: function( data )

						{

							if( data.rows )

							{

								alerta('Alteração Realizada com Sucesso');

								setTimeout(function(){location.href='http://www.embrapa.off.br/usuario/alterar';},2500);

							}else

							{

								alerta('Alteração não Realizada');

							}

						}

					});

				}else

				{

					$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

					alerta('As senhas não coincidem');

				}

			}else

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				alerta('A senha deve conter pelo menos 6 dígitos');

			}

		}else

		{

			$(this).blur();

			$.ajax({

						dataType:'json',

						url:'/modal/user_alt.php',

						type:'POST',

						data: $('.alterar_usuario').serializeArray(),

						beforeSend: function() 

						{

							$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

							

						},

						success: function( data )

						{

							if( data.rows )

							{

								alerta('Alteração Realizada com Sucesso');

								setTimeout(function(){location.href='http://www.embrapa.off.br/usuario/alterar';},2500);

							}else

							{

								alerta('Alteração não Realizada');

							}

						}

					});

		}

	});





	$('.alterar_usuario_cadastrado button').click(function(event)

	{

		$(this).blur();

		$.ajax({

				dataType:'json',

				url:'/modal/user_alt_cadastrado.php',

				type:'POST',

				data: $('.alterar_usuario_cadastrado').serializeArray(),

				beforeSend: function() 

				{

					$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

					

				},

				success: function( data )

				{

					if( data.rows )

					{

						alerta('Alteração Realizada com Sucesso');

						location.href="/usuario";

					}else

					{

						alerta('Alteração não Realizada');

					}

				}

			});

	});





	$('input[name=cidade]').blur(function()

	{

		if( $(this).val() == '' )

		{

			$('.modal').remove();

			$('.nome_cidades').css('display','none');	

		}

		

	});



	var xhr;

	$('input[name=cidade]').keyup(function()

	{

		if( $(this).val() != '' )

		{



			if(xhr != null) xhr.abort(); //cancel previous request

	  		$('.modal').remove();

	  		xhr = $.ajax({

				dataType:'json',

				url:'/modal/list_cities.php',

				type:'GET',

				data: { cidade: $(this).val()},

				beforeSend: function()

				{

					$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

					

				},

				success: function( data )

				{

					$('.modal').remove();

					$('.nome_cidades').css('display','block');

					$('.nome_cidades').html(data.dados);



					$('.nome_cidades a').click(function(event)

					{

						$('input[name=cidade]').val($(this).attr('data-city'));

						$('input[name=estado]').val($(this).attr('data-state'));



						$('input[name=city]').val($(this).attr('data-id-city'));

						$('input[name=state]').val($(this).attr('data-id-state'));

						$('.nome_cidades').css('display','none');

					});

				}

			});	

		}else

		{

			$('input[name=estado]').val('');

		}	

	});





	$('.data').keypress(function(event)

	{

		var tecla = event.keyCode || event.charCode;



	    if ( tecla == 13 )

	    	$('.pesquisar').trigger('click');

		
		if(  tecla == 8 )
			return true;

		if ( tecla < 48 || tecla > 57 )

	        return false;

	});



	$('.pesquisar').click(function(event)

	{

		if( ( $('.filtro input[name=data_inicial]').val() != '' && $('.filtro input[name=data_final]').val() != '' ) && ( $('.filtro input[name=data_inicial]').val().length == 4 && $('.filtro input[name=data_final]').val().length == 4 ) )

		{

			$.ajax({

					dataType:'json',

					url:'/inc/list_amostras_ajax.php',

					type:'GET',

					data: $('.filtro').serializeArray(),

					beforeSend: function()

					{

						$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

						

					},

					success: function( data )

					{

						$('.modal').remove();

						$('.listagem_amostra tbody').html(data.html);

	

						$('.listagem_amostra tbody .abrir').click(function(event)

						{

							if( $(this).hasClass('not_calculed') )

							{

								$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

								alerta('As Médias desta Amostra ainda não foram calculadas.');

								return false;

							}

	

							if( $(this).hasClass('fechar') )

							{

								$('.sub_item').children('td').css('color','#fbfbfb');

								if( $('.listagem_amostra tbody tr').hasClass('sub_item') )

								{

									$('.sub_item').animate({ "height" : "0px", "display" : "none"},500,function()

									{

										$(this).remove();

									});

								}

								$('.listagem_amostra tbody tr').removeClass('fechar');

							}else

							{

								var div = $(this);

								$.ajax({

										dataType:'json',

										url:'/modal/amostras_subtable.php',

										type:'GET',

										data: { 'samp' : $(this).attr('data-id')},

										beforeSend: function() 

										{

											$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

										},

										success: function( data )

										{

											if( data.error != null )

											{

												alerta(data.frase);

											}else

											{

												$('.modal').remove();

												if( $('.listagem_amostra tbody tr').hasClass('sub_item') )

												{

													$('.sub_item').animate({ "height" : "0px", "display" : "none"},500,function()

													{

														$(this).remove();

													});

												}

		

												if( ! $(this).hasClass('readonly') )

												{

													$(data.html).insertAfter(div);

													$('.sub_item').animate({ "height" : "25px !important", "line-height" : "25px !important", "display" : "block"},500);

												}

											}

											$('.listagem_amostra tbody tr').removeClass('fechar');

											$(div).addClass('fechar');

										}

									});

							}

						});

					}

				});	

		}else

		{

			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			alerta('Digite as duas datas corretamente');

		}

	});



	$('.listagem_amostra tbody .abrir').click(function(event)

	{

		if( $(this).hasClass('not_calculed') )

		{

			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			alerta('As Médias desta Amostra ainda não foram calculadas.');

			return false;

		}



		if( $(this).hasClass('fechar') )

		{

			$('.sub_item').children('td').css('color','#fbfbfb');

			if( $('.listagem_amostra tbody tr').hasClass('sub_item') )

			{

				$('.sub_item').animate({ "height" : "0px", "display" : "none"},500,function()

				{

					$(this).remove();

				});

			}

			$('.listagem_amostra tbody tr').removeClass('fechar');

		}else

		{

			var div = $(this);

			$.ajax({

					dataType:'json',

					url:'/modal/amostras_subtable.php',

					type:'GET',

					data: { 'samp' : $(this).attr('data-id')},

					beforeSend: function() 

					{

						$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

					},

					success: function( data )

					{

						if( data.error != null )

						{

							alerta(data.frase);

						}else

						{

							$('.modal').remove();

							if( $('.listagem_amostra tbody tr').hasClass('sub_item') )

							{

								$('.sub_item').animate({ "height" : "0px", "display" : "none"},500,function()

								{

									$(this).remove();

								});

							}



							if( ! $(this).hasClass('readonly') )

							{

								$(data.html).insertAfter(div);

								//$('.sub_item').animate({ "height" : "25px", "display" : "block"},500);
								$('.sub_item').animate({ "height" : "25px !important", "line-height" : "25px !important", "display" : "block"},500);


							}

						}

						$('.listagem_amostra tbody tr').removeClass('fechar');

						$(div).addClass('fechar');

					}

				});

		}

	});



	$('.alt_resultado .masked').focus(function()

	{

		$(this).select();

	});



	$('.alt_resultado input:text').keypress(function(event)

	{

		var tecla = event.keyCode || event.charCode;

		if(  tecla == 8 )
			return true;

		if ( tecla != 44 && tecla < 48 || tecla > 57 )

	        return false;



		if( tecla == 44 && $(this).val().length <= 0 )

			return false;



		if( $(this)[0].selectionStart == 0 && $(this)[0].selectionEnd == $(this).val().length && tecla != 44 )

		{

			$(this).parent().parent().find('input[type="checkbox"]').attr('checked','checked');

			$(this).parent().parent().find('.check').addClass('checked');

			$(this).parent().parent().find('.checked').removeClass('check');

			return true;

		}



		if( tecla == 44 && $(this).attr('data-id') < 1 )

		   return false;



		if ( tecla == 8 || tecla == 0 )

        	return true;



		if( tecla == 44 && $(this).val().length == 0 )

			return false;



        if( tecla == 44 && $(this).val().indexOf(",") > 0 )

        	return false;



	    if ( tecla != 44 && tecla < 48 || tecla > 57 )

	        return false;



	    if( $(this).val().indexOf(",") > 0 )

	    {

	    	var count = $(this).val().split(',');

	    

	        if( count[1].length >= $(this).attr('data-id') && tecla != 44 )

	        	return false;



	    	if( count[0].length >= 5 && tecla != 44 && count[1].length >= $(this).attr('data-id') )

	        	return false;



	    }else

	    {

	    	if(  $(this).val().length >= 5 && tecla != 44 )

	    		return false;

	    }



		$(this).parent().parent().find('input[type="checkbox"]').attr('checked','checked');

		$(this).parent().parent().find('.check').addClass('checked');

		$(this).parent().parent().find('.checked').removeClass('check');

	    //alert(tecla);

	});



	$('.alt_resultado .technic').change(function()

	{

		var val = $(this).val();

		$('.alt_resultado .technic').each(function()

		{

			$(this).val(val);

		});

	});



	$('.alt_resultado button').click(function(event)

	{
		if( $('select[name="180[technic]"]').val() == 0 &&  $('input[name="180[mandatory]"]').attr('checked') == 'checked' )

		{

			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			alerta('Selecione um Método para Argila');

			return false;

		}else if( $('select[name="182[technic]"]').val() == 0 &&  $('input[name="182[mandatory]"]').attr('checked') == 'checked' )

		{

			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			alerta('Selecione um Método para Areia Total');

			return false;

		}else if( $('select[name="183[technic]"]').val() == 0 &&  $('input[name="183[mandatory]"]').attr('checked') == 'checked' )

		{

			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			alerta('Selecione um Método para Silte');

			return false;

		}/*else if( $('input[name="serial_number"]').val() == 0 || $('input[name="serial_number"]').val() == '' )
		{

			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			alerta('Número de Série deve ser preenchido');

			$('input[name="serial_number"]').focus();

			return false;

		}*/

		$(this).blur();	

		$.ajax({

			dataType:'json',

			url:'/modal/result_cad.php',

			type:'POST',

			data: $('.alt_resultado').serializeArray(),

			beforeSend: function() 

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				

			},

			success: function( data )

			{

				if( data.error == 1 )

				{

					alerta('Alteração não Realizada');

				}else if( data.error == 2 )

				{

					alerta('Não há permissão para gravar os dados');

				}else

				{
					$('.box_alert').load('/inc/list_confirm_result.php?samp='+$('input[name=pk_people_samp]').val(),function()
					{
						$('.box_alert').fadeIn(1000);
						$('.box_alert').css({'top':'calc(40% - '+($('.box_alert').height()/2)+'px)', 'left': 'calc(50% - '+($('.box_alert').width()/2)+'px)', 'margin-left':'0'});		

						$('.box_ok').click(function(event)
						{
							location.href="/resultado";
						});
					});

					//alerta('Envio Realizado com Sucesso');
					//$('.box_alert').load('/inc/list_confirm_result.php?samp='+$('input[name=pk_people_samp]').val());
					//$('.box_alert').fadeIn(1000);

					//setTimeout(function(){location.href="/resultado";},2500);

				}

			}

		});		

	});



	$('.edit_resultado').click(function(event)

	{

		$(this).blur();

		event.preventDefault();

		$.ajax({

			dataType:'json',

			url:'/modal/result_verific.php',

			type:'GET',

			//data: {'inicial': $('.inicial').val(), 'final': $('.final').val(), 'ano': $('.year').val() },

			data: {'inicial': $(this).attr('data-inicial'), 'final': $(this).attr('data-final'), 'ano': $(this).attr('data-year') },

			beforeSend: function() 

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				

			},

			success: function( data )

			{

				if( data.error == 1 )

				{

					alerta(data.frase);

				}else

				{

					location.href="/resultado/alterar/"+data.number;

				}

			}

		});		

	});



	$('.add_selos').click(function(event)

	{

		$(this).blur();

		event.preventDefault();

		$.ajax({

			dataType:'json',

			url:'/modal/selos_verific.php',

			type:'GET',

			//data: ,

			beforeSend: function() 

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				

			},

			success: function( data )

			{

				if( data.error == 1 )

				{

					alerta(data.frase);

				}else

				{

					location.href="/selo/novo/";

				}

			}

		});		

	});





	$('.form_selos .vlr_unitario').html($('.form_selos .description').find('option:selected').data('rel'));

	$('.form_selos .description').change(function()

	{

		$('.form_selos .vlr_unitario').html($('.form_selos .description').find('option:selected').data('rel'));



		$('.form_selos .vlr_total').html('R$ ' + (($('.form_selos .quantidade').val()*($('.form_selos .vlr_unitario').html()).replace(',','.')).toFixed(2)).replace('.',','));

	});



	$('.form_selos .quantidade').keypress(function(event)

	{

		var tecla = event.keyCode || event.charCode;

		if(  tecla == 8 )
			return true;

		if ( tecla < 48 || tecla > 57 )

	        return false;

	    //alert(tecla);

	});



	$('.form_selos .quantidade').keyup(function()

	{

		$('.form_selos .vlr_total').html('R$ ' + (($(this).val()*($('.form_selos .vlr_unitario').html()).replace(',','.')).toFixed(2)).replace('.',','));

	});



	$('.cad_selos button').click(function(event)

	{

		$(this).blur();

		event.preventDefault();

		$.ajax({

			dataType:'json',

			url:'/modal/selos_cad.php',

			type:'GET',

			data: $('.cad_selos').serializeArray(),

			beforeSend: function() 

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				

			},

			success: function( data )

			{

				if( data.error == 1 )

				{

					alerta(data.frase);

				}else

				{

					alerta('Cadastro Efetuado com Sucesso');

					setTimeout(function(){

						location.href="/selo";

					},3000);

				}

			}

		});		

	});



	$('.alterar_selos button').click(function(event)

	{

		$(this).blur();

		event.preventDefault();

		$.ajax({

			dataType:'json',

			url:'/modal/selos_alt.php',

			type:'GET',

			data: $('.alterar_selos').serializeArray(),

			beforeSend: function() 

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				

			},

			success: function( data )

			{

				if( data.error == 1 )

				{

					alerta(data.frase);

				}else

				{

					alerta('Alteração Efetuado com Sucesso');

					setTimeout(function(){

						location.href="/selo";

					},3000);

				}

			}

		});		

	});



	$('.listagem_selos .excluir').click(function(event)

	{

		if( $(this).hasClass('readonly') )

		{

			return false;

		}

		//alert($(this).attr('data-rel'));



		if(confirm('Deseja Cancelar Este Pedido?') )

		{

			$.ajax({

				dataType:'json',

				url:'/modal/selos_cancelamento.php',

				type:'GET',

				data: {'data' : $(this).attr('data-rel')},

				beforeSend: function() 

				{

					$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

				},

				success: function( data )

				{

					if( data.error == 1 )

					{

						alerta(data.frase);

					}else

					{

						alerta('Cancelamento Efetuado com Sucesso');

						setTimeout(function(){

							location.href="/selo";

						},3000);

					}

				}

			});		

		}

	});

});



function alerta( mensagem )

{

	$('.box_alert p').html( mensagem );


	//$('.modal').css({'display':'block','background':'#000','z-index':'99999'});

	$('.box_alert').fadeIn(1000);

	setTimeout(function(){

	$('.box_alert').fadeOut(	

						1000,

						function()

						{

							$('.modal').css({'display':'none','background':'url(/imagens/ajax-loader.gif) no-repeat center #000','z-index':'9999'});

							$('.modal').remove();

						})

				},2500);



}