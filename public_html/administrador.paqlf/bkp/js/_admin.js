$(document).ready(function()
{
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

	$('.readonly').click(function()
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

	$('#check_all').change(function()
	{
		if( $(this).attr('checked') == 'checked' )
		{
			$('.td_check_all input:checkbox').attr('checked',true);
			$('.td_check_all label').css({'background-image':"url('/images/ico_check_on.png')"});
		}else
		{
			$('.td_check_all input:checkbox').attr('checked',false);
			$('.td_check_all label').css({'background-image':"url('/images/ico_check_off.png')"});
		}
	});


	$('.logout').click(function()
	{
		location.href="/";
	});


	$('.listagem_laboratorio .cabecalho .pointer').click(function()
	{
		var text = $(this).html();
		var order = $(this).attr('data-rel');
		var param = '';

		if( text == 'Número' )
		{
			param = 'lab_number ';
		}else if( text == 'Laboratório' )
		{
			param = 'person ';
		}else if( text == 'Cidade' )
		{
			param = 'city ';
		}else if( text == 'Estado' )
		{
			param = 'state ';
		}else
		{
			return false;
		}

		$('.listagem_laboratorio .cabecalho .pointer').attr('data-rel','ASC');
		if( order == 'ASC')
		{
			$(this).attr('data-rel','DESC');
		}

		$.ajax({
			dataType:'html',
			url:'/inc/list_laboratorios.php',
			type:'GET',
			data: { 'order' : param+order },
			success: function( data )
			{
				$('.listagem_laboratorio tbody').html(data);


				$('.listagem_laboratorio .excluir').click(function()
				{
					var div = $(this);

					if(confirm('Deseja Excluir Este Laboratório?') )
					{
						$.ajax({
							dataType:'json',
							url:'/modal/excluir_laboratorio.php',
							type:'GET',
							data: {'id' : $(this).attr('data-id')},
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
			}
		});		

	});

	$('.listagem_laboratorio .excluir').click(function()
	{
		var div = $(this);

		if(confirm('Deseja Excluir Este Laboratório?') )
		{
			$.ajax({
				dataType:'json',
				url:'/modal/excluir_laboratorio.php',
				type:'GET',
				data: {'id' : $(this).attr('data-id')},
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
						//alerta(data.error);
						if( data.error == '2' )
						{
							alerta('Email já cadastrado.');
						}else
						{
							alerta('Erro de cadastro');
						}
					}else
					{
						alerta('Email cadastrado com sucesso.');
						
						setTimeout(function()
						{
							if( $('.lab_on').val() == '-10' )
							{
								location.href="/usuario";
							}else
							{
								location.href="/laboratorio/usuario/"+$('.lab_on').val();
							}
						},3000);					
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


	$('.alterar_usuario_cadastrado button').click(function(event)
	{
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
						
						setTimeout(function()
						{
							if( $('.lab_on').val() == '-10' )
							{
								location.href="/usuario";
							}else
							{
								location.href="/laboratorio/usuario/"+$('.lab_on').val();
							}
						},3000);
					}else
					{
						alerta('Alteração não Realizada');
					}
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
								setTimeout(function(){location.href='/usuario/alterar';},2500);
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
			$.ajax({
				dataType:'json',
				url:'/modal/user_alt_cadastrado.php',
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
						setTimeout(function(){location.href='/usuario/alterar';},2500);
					}else
					{
						alerta('Alteração não Realizada');
					}
				}
			});
		}
	});


	$('.usuarios .excluir').click(function()
	{
		var div = $(this);

		if(confirm('Deseja Excluir Este Usuário?') )
		{
			$.ajax({
				dataType:'json',
				url:'/modal/excluir_usuario.php',
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


	$('.alt_lab button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/lab_alt.php',
			type:'POST',
			data: $('.alt_lab').serializeArray(),
			beforeSend: function() 
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.rows )
				{
					alerta('Alteração Realizada com Sucesso');
					setTimeout(function(){
						location.href="/laboratorio";
					},3000);
					
				}else
				{
					alerta('Alteração não Realizada');
				}
			}
		});		
	});


	$('.novo_lab button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/lab_novo.php',
			type:'POST',
			data: $('.novo_lab').serializeArray(),
			beforeSend: function() 
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.rows == '-1' )
				{
					alerta('Número de Laboratório já cadastrado');
				}else if( data.rows == 1 )
				{
					alerta('Cadastro Realizado com Sucesso');
					location.href="/laboratorio";
				}else
				{
					alerta('Cadastro não Realizado');
				}
			}
		});		
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

					$('.nome_cidades a').click(function()
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

	$('.form_amostras .pesquisar').click(function()
	{
		if($('.filtro input:text').val() != '')
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

					$('.listagem_amostra tbody .abrir').click(function()
					{
						if( $(this).hasClass('not_calculed') )
						{
							$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
							alerta('As Médias desta Amostra ainda não foram calculadas.');
							return false;
						}


						//alert('oi');
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
									data: { 'samp' : $(this).attr('data-id'), 'laboratorio':$('.link_laboratorio').val()},
									beforeSend: function() 
									{
										$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
									},
									success: function( data )
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
											$('.sub_item').animate({ "height" : "25px", "display" : "block"},500);
										}
										$('.listagem_amostra tbody tr').removeClass('fechar');
										$(div).addClass('fechar');
									}
								});
						}
					});
				}
			});	
		}
	});


	$('.abas a').click(function()
	{
		if( $(this).hasClass('selected') )
		{
			return false;
		}
		$('.abas a').removeClass('selected');
		$(this).addClass('selected');
			$.ajax({
			dataType:'html',
			url:'/inc/list_avaliacoes.php',
			type:'GET',
			data: { 'groups' : $(this).attr('data-id'), 'ano' : $('.hidden_year').val() , 'samp' : $('.hidden_person').val() },
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{				
				$('.modal').remove();
				$('.tabela_avaliacoes tbody').html(data);
			}
		});		

	});

	$('.tabela_avaliacoes .cabecalho .pointer').click(function()
        {
            var text = $(this).html();
            var elemento = $(this);
            var order = $(this).attr('data-rel');
            var param = '';

            if( text == 'Número' )
            {
                param = 'ep_people.lab_number ';
            }else if( text == 'Laboratório' )
            {
                param = 'ep_people.person ';
            }else if( text == 'Total Anual' )
            {
                param = 'ep_people_program_year.total_annual ';
            }else if( text == 'Total com Repetição' )
            {
                param = 'ep_people_program_year.full_repeat  ';
            }else if( text == 'Ponderado' )
            {
                param = 'ep_people_program_year.considerate  ';
            }else if( text == 'Inexatidão' )
            {
                param = 'ep_people_program_year.inaccuracy ';
            }else if( text == 'Imprecisão' )
            {
                param = 'ep_people_program_year.haziness ';
            }else if( text == 'I.E.' )
            {
                param = 'ep_people_program_year.ie ';
            }else if( text == 'Grupo' )
            {
                param = 'ep_people_program_year.final_group  ';
            }
            else
            {
                return false;
            }

            $('.tabela_avaliacoes .cabecalho .pointer').attr('data-rel','ASC');
            if( order == 'ASC')
            {
                elemento.attr('data-rel','DESC');
            }

            $.ajax({
                dataType:'html',
                url:'/inc/list_avaliacoes.php',
                type:'GET',
                data: { 'order' : param+order, 'ano' : $('.form_avaliacoes .data').val() },
                success: function( data )
                {
                    $('.tabela_avaliacoes tbody').html(data);
                }
            });     

        });

	$('.data').keypress(function(event)
	{
		var tecla = event.keyCode || event.charCode;

	    if ( tecla == 13 )
	    	$('.pesquisar').trigger('click');
		
		if ( tecla < 48 || tecla > 57 )
	        return false;
	});

	
	/*$('.data_completa').on("paste", function (e) {
        e.preventDefault();

        var text;
        var clp = (e.originalEvent || e).clipboardData;

        //alert(clp);
        if (clp === undefined || clp === null) {
            text = window.clipboardData.getData("text") || "";
            if (text !== "")
            {

            }
            /*if (text !== "") {
                if (window.getSelection) {
                    var newNode = document.createElement("span");
                    newNode.innerHTML = text;
                    window.getSelection().getRangeAt(0).insertNode(newNode);
                } else {
                    document.selection.createRange().pasteHTML(text);
                }
            }
        } else {
            text = clp.getData('text/plain') || "";
            if (text !== "") 
            {

            	var kp = jQuery.Event("keypress");

            	//var ex = text.split('');
            	for( var i = 0; i < text.length; i++)
            	{
            		
            		//kp.keyCode = ex[i];
            		kp.keyCode = text.charCodeAt([i]);
            		//alert(text.charCodeAt([i]) + ' --- ' + i + '----' + kp.keyCode);
            		$('.data_completa').trigger(kp);
            	}
            }
            //if (text !== "") {
            //   document.execCommand('insertText', false, text);
            //}
        }
    });*/


	$('.data_completa').keypress(function(event)
	{
		var qnt = $(this).val().length;
		//var kC = (document.all) ? event.keyCode : e.keyCode;
		//var tecla = event.keyCode;
		var tecla = event.keyCode || event.charCode;
		//alert(tecla);

		if(  tecla == 8 )
			return true;
		
		if ( tecla < 48 || tecla > 57)
        return false;

    	if( qnt == 2 || qnt == 5)
    		$(this).val( $(this).val() + '/' );


    	/*
			if (((ardt[1]==4)||(ardt[1]==6)||(ardt[1]==9)||(ardt[1]==11))&&(ardt[0]>30))
				erro = true;
			else if ( ardt[1]==2) {
				if ((ardt[0]>28)&&((ardt[2]%4)!=0))
					erro = true;
				if ((ardt[0]>29)&&((ardt[2]%4)==0))
					erro = true;
			}
    	*/
	});

	$('.form_avaliacoes .pesquisar').click(function()
	{
		$.ajax({
				dataType:'html',
				url:'/inc/list_avaliacoes.php',
				type:'GET',
				data: $('.filtro').serializeArray(),
				beforeSend: function()
				{
					$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
				},
				success: function( data )
				{
					$('.modal').remove();
					$('.tabela_avaliacoes tbody').html(data);
				}
			});	
	});

	$('.listagem_amostra tbody .abrir').click(function()
	{
		if( $(this).hasClass('not_calculed') )
		{
			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			alerta('As Médias desta Amostra ainda não foram calculadas.');
			return false;
		}
		
		//alert('oi');
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
					data: { 'samp' : $(this).attr('data-id'), 'laboratorio':$('.link_laboratorio').val()},
					beforeSend: function() 
					{
						$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
					},
					success: function( data )
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
							$('.sub_item').animate({ "height" : "25px", "display" : "block"},500);
						}
						$('.listagem_amostra tbody tr').removeClass('fechar');
						$(div).addClass('fechar');
					}
				});
		}
	});
	

	$('.novo_contrato button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/contrato_cad.php',
			type:'GET',
			data: $('.novo_contrato').serializeArray(),
			beforeSend: function() 
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.error == 0 )
				{
					alerta(data.frase);
					setTimeout(function(){location.href='/laboratorio/contrato/'+$('.lab_on').val();},2500);
				}else
				{
					alerta(data.frase);
				}
			}
		});		
	});

	$('.lista_contratos .excluir').click(function()
	{
		var div = $(this);

		if(confirm('Deseja Excluir Este Contrato?') )
		{
			$.ajax({
				dataType:'json',
				url:'/modal/excluir_contrato.php',
				type:'GET',
				data: {'id' : $(this).attr('data-id')},
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


	$('.alterar_contrato button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/contrato_alt.php',
			type:'GET',
			data: $('.alterar_contrato').serializeArray(),
			beforeSend: function() 
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( ! data.error )
				{
					alerta(data.frase);
					setTimeout(function(){location.href='/laboratorio/contrato/'+$('.lab_on').val();},2500);
				}else
				{
					alerta(data.frase);
				}
			}
		});		
	});

	$('.novo_contrato .dates').keypress(function(event)
	{
		mascaraData($(this),event);
	});

	$('.filtro .where').change(function()
	{
		$.ajax({
			dataType:'html',
			url:'/inc/list_selos.php',
			type:'GET',
			data: { 'where' : $(this).val(), 'samp' : $('.listagem_selos').attr('data-id') },
			beforeSend: function() 
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				$('.modal').remove();
				$('.listagem_selos tbody').html(data);
				//alert(data);
			}
		});	
		//alert('oi');
	});

	$('.add_selos').click(function()
	{
		$(this).blur();
		event.preventDefault();
		$.ajax({
			dataType:'json',
			url:'/modal/selos_verific.php',
			type:'POST',
			data: { 'lab' : $('.listagem_selos').attr('data-id') },
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
					location.href="/laboratorio/selo/novo/" + $('.listagem_selos').attr('data-id');
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
	});


	$('.form_selos .quantidade').keyup(function()
	{
		$('.form_selos .vlr_total').html('R$ ' + (($(this).val()*($('.form_selos .vlr_unitario').html()).replace(',','.')).toFixed(2)).replace('.',','));
	});

	$('.cad_selos button').click(function()
	{
		$(this).blur();
		event.preventDefault();
		$.ajax({
			dataType:'json',
			url:'/modal/selos_cad.php',
			type:'POST',
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
						location.href="/laboratorio/selo/" + $('.lab_on').val();
					},3000);
				}
			}
		});		
	});

	$('.alterar_selos_laboratorio button').click(function()
	{
		$(this).blur();
		event.preventDefault();
		$.ajax({
			dataType:'json',
			url:'/modal/selos_alt_laboratorio.php',
			type:'GET',
			data: $('.alterar_selos_laboratorio').serializeArray(),
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
						location.href="/laboratorio/selo/" + $('.lab_on').val();
					},3000);
				}
			}
		});		
	});


	$('.alterar_selos button').click(function()
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


	$('.list_programas .excluir').click(function()
	{
		var div = $(this);

		if(confirm('Deseja Excluir Este Contrato?') )
		{
			$.ajax({
				dataType:'json',
				url:'/modal/excluir_programa.php',
				type:'GET',
				data: {'id' : $(this).attr('data-id')},
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

	$('.novo_ano_programa button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/programa_novo_ano.php',
			type:'POST',
			data: $('.novo_ano_programa').serializeArray(),
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.error == 1 )
				{
					alerta('Ano já cadastrado');
				}else
				{
					if( data.rows == 1 )
					{
						alerta('Cadastrado com Sucesso');
						setTimeout(function(){
							location.href="/programa";
						},3000);
					}else
					{
						alerta('Inclusão não Realizada');
					}					
				}
				
			}
		});		
	});


	$('.listagem_amostra_etapa tbody .abrir').click(function()
	{

		if( $(this).hasClass('fechar') )
		{
			$('.sub_item').children('td').css('color','#fbfbfb');
			if( $('.listagem_amostra_etapa tbody tr').hasClass('sub_item') )
			{
				$('.sub_item').animate({ "height" : "0px", "display" : "none"},500,function()
				{
					$(this).remove();
				});
			}
			$('.listagem_amostra_etapa tbody tr').removeClass('fechar');
		}else
		{
			if( $(this).hasClass('not_calculed') )
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
				alerta('As Médias desta Amostra ainda não foram calculadas.');
				return false;
			}
			
			var div = $(this);
			$.ajax({
					dataType:'json',
					url:'/modal/amostras_subtable.php',
					type:'GET',
					data: { 'samp' : $(this).attr('data-id'), 'laboratorio':$(this).attr('data-rel')},
					beforeSend: function() 
					{
						$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
					},
					success: function( data )
					{
						$('.modal').remove();
						if( $('.listagem_amostra_etapa tbody tr').hasClass('sub_item') )
						{
							$('.sub_item').animate({ "height" : "0px", "display" : "none"},500,function()
							{
								$(this).remove();
							});
						}

						if( ! $(this).hasClass('readonly') )
						{
							$(data.html).insertAfter(div);
							$('.sub_item').animate({ "height" : "25px", "display" : "block"},500);
						}
						$('.listagem_amostra_etapa tbody tr').removeClass('fechar');
						$(div).addClass('fechar');
					}
				});
		}
	});


	$('.list_programas_etapa input:checkbox').change(function()
	{
		//alert($(this).attr('checked'));
		var checked = 'false';

		if( $(this).attr('checked') == 'checked' )
		{
			checked = 'true';
		}

		$.ajax({
			dataType: 'json',
			url: '/modal/programa_etapa_visible.php',
			type: 'GET',
			data: { 'samp' : $(this).attr('data-id'), 'value' : checked },
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.rows == 1 )
				{
					alerta( 'Alteração Realizada com Sucesso.')
				}else
				{
					alerta( 'Alteração não Realizada.')
				}
			}
			
		});
	});

	$('.list_programas_etapa .edit.readonly').click(function()
	{
		$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
		alerta('Etapa Não pode ser Alterada pois já foi Calculada');
	});

	$('.list_programas_etapa .calcule').click(function()
	{
		var div = $(this);
		if( ! $(this).hasClass('readonly') )
		{
			//var r = 
			if( confirm('Deseja Calcular Esta Etapa?') ) //confirm('Deseja Calcular Esta Etapa?') )
			{
				$.ajax({
					dataType:'json',
					url:'/modal/programa_etapa_fim.php',
					type:'POST',
					data: {'samp' : $(this).attr('data-id')},
					beforeSend: function()
					{
						$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
					},
					success: function( data )
					{
						if( data.error == 1 )
						{
							alerta('Etapa calculada com sucesso.');
							div.addClass('readonly');

						}else if( data.error == 2 )
						{
							alerta('Etapa já calculada.');

						}else if( data.error == 3 )
						{
							alerta('Prazo de envio em aberto.');
						}else
						{
							alerta(data.frase);
						}
					}
				});	
			}
		}
	});

	$('.nova_etapa_programa button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/programa_nova_etapa.php',
			type:'POST',
			data: $('.nova_etapa_programa').serializeArray(),
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.error == 0 )
				{
					alerta(data.frase);
					setTimeout(function(){
						location.href="/programa/etapa/"+$('.programa').val();
					},3000);
				}else
				{
					alerta(data.frase);
				}
			}
		});		
	});


	$('.alterar_etapa_programa button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/programa_altera_etapa.php',
			type:'POST',
			data: $('.alterar_etapa_programa').serializeArray(),
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.error == 0 )
				{
					alerta(data.frase);
					setTimeout(function(){
						location.href="/programa/etapa/"+$('.voltar').val();
					},3000);
				}else
				{
					alerta(data.frase);
				}
			}
		});		
	});


	$('.list_programas_etapa .excluir').click(function()
	{
		var div = $(this);

		if(confirm('Deseja Excluir Esta Etapa?') )
		{
			$.ajax({
				dataType:'json',
				url:'/modal/excluir_etapa.php',
				type:'GET',
				data: {'id' : $(this).attr('data-id')},
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

	$('.list_programa_amostras .readonly').click(function()
	{
		$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
		alerta('Amostra Não pode ser Alterada pois já foi Calculada');
	});

	$('.nova_amostra_programa button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/programa_novo_programa.php',
			type:'POST',
			data: $('.nova_amostra_programa').serializeArray(),
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.erro == 1 )
				{
					alerta('Limite de Amostras por Etapas Excedido');
				}else if( data.erro == 2 )
				{
					alerta('Número da Amostra já cadastrada.');
				}else
				{
					alerta('Cadastrado com Sucesso');
					setTimeout(function(){
						location.href="/programa/amostra/"+$('.programa').val();
					},3000);
				}
			}
		});		
	});

	$('.alterar_amostra_programa button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/programa_alterar_programa.php',
			type:'POST',
			data: $('.alterar_amostra_programa').serializeArray(),
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.rows == 1 )
				{
					alerta('Alteração Realizada com Sucesso');
					setTimeout(function(){
						location.href="/programa/amostra/"+$('.voltar').val();
					},3000);
				}else
				{
					alerta('Alteração não Realizada');
				}
			}
		});		
	});


	$('.list_programa_amostras .excluir').click(function()
	{
		var div = $(this);

		if(confirm('Deseja Excluir Esta Etapa?') )
		{
			$.ajax({
				dataType:'json',
				url:'/modal/excluir_amostra.php',
				type:'GET',
				data: {'id' : $(this).attr('data-id')},
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


	$('.novo_controle button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/controle_novo.php',
			type:'POST',
			data: $('.novo_controle').serializeArray(),
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.error == 0 )
				{
					alerta(data.frase);
					setTimeout(function(){
						location.href="/areferencias";
					},3000);
				}else
				{
					alerta(data.frase);
				}
			}
		});		
	});

	$('.alterar_controle button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/controle_alterar.php',
			type:'POST',
			data: $('.alterar_controle').serializeArray(),
			beforeSend: function()
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.error == 0 )
				{
					alerta(data.frase);
					setTimeout(function(){
						location.href="/areferencias";
					},3000);
				}else
				{
					alerta(data.frase);
				}
			}
		});		
	});

	$('.lista_controle .excluir').click(function()
	{
		var div = $(this);

		if(confirm('Deseja Excluir Este Controle?') )
		{
			$.ajax({
				dataType:'json',
				url:'/modal/excluir_controle.php',
				type:'GET',
				data: {'id' : $(this).attr('data-id')},
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


	$('.filtro .filtro_control').change(function()
	{
		//$(this).css('width', 'auto');
		$.ajax({
			dataType:'html',
			url:'/inc/list_controles_uso.php',
			type:'GET',
			data: { 'samp' : $(this).val() },
			beforeSend: function() 
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				$('.modal').remove();
				$('.lista_controle tbody').html(data);
				//alert(data);
			}
		});	
		//alert('oi');
	});


	$('.novo_contato button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/contato_cad.php',
			type:'GET',
			data: $('.novo_contato').serializeArray(),
			beforeSend: function() 
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.error == 1 )
				{
					
					alerta('Cadastro não Realizado');
				}else
				{
					alerta('Cadastrado com Sucesso');
					setTimeout(function(){location.href='/laboratorio/contato/'+$('.lab_on').val();},2500);
				}
			}
		});		
	});

	$('.alt_contato button').click(function(event)
	{
		$.ajax({
			dataType:'json',
			url:'/modal/contato_alt.php',
			type:'POST',
			data: $('.alt_contato').serializeArray(),
			beforeSend: function() 
			{
				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			},
			success: function( data )
			{
				if( data.rows )
				{
					alerta('Alteração Realizada com Sucesso');
					setTimeout(function(){location.href='/laboratorio/contato/'+$('.lab_on').val();},2500);
				}else
				{
					alerta('Alteração não Realizada');
				}
			}
		});		
	});

	$('.lista_contatos .excluir').click(function()
	{
		var div = $(this);

		if(confirm('Deseja Excluir Este Contato?') )
		{
			$.ajax({
				dataType:'json',
				url:'/modal/excluir_contato.php',
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


	$('.gerar_selos').click(function()
	{
		camposMarcados = new Array();
		$("input[type=checkbox][name='impressoes']:checked").each(function(){
		    camposMarcados.push($(this).val());
		});

		if( camposMarcados != '') 
		{
			fechar = window.open("/impressao/"+camposMarcados, "_blank");
			
			$(fechar).ready(function() { 
	               fechar.print(); 
	           }); 
			$(fechar).load(function()
			{
				setTimeout(function(){fechar.close(),5000});
			});
		}else
		{
			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
			alerta('Selecione um Laboratório para gerar os selos');
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

function mascaraData( campo, e )
{
	var kC = (document.all) ? event.keyCode : e.keyCode;
	var data = campo.value;
	
	if( kC!=8 && kC!=46 )
	{
		if( data.length==2 )
		{
			campo.value = data += '/';
		}
		else if( data.length==5 )
		{
			campo.value = data += '/';
		}
		else
			campo.value = data;
	}
}