$(document).ready(function()

{

	$('form input').keypress(function(event)

	{

		if( event.keyCode == 13 )

		{

			$('.login button').trigger('click');

		}

	});



	$('.login button').click(function()

	{

		/*$.ajax({

			dataType:'json',

			url:'/controller/login_controle.php',

			type:'POST',

			data: $('.login').serializeArray(),

			beforeSend: function()

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			},
			success: function(data)
			{
				if( data.acao == 1 )

				{
					location.href="/laboratorio";

				}else

				{

					alerta('Login e/ou senha não encontrado.')

					$('form input:text').val('');

					$('form input:password').val('');

				}

			}

		});	*/

		$.ajax({

			dataType:'json',

			url:'/controller/login_controle.php',

			type:'POST',

			data: $('.login').serializeArray(),

			beforeSend: function()

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');
				
			},
			success: function(data)
			{
				if( data.acao == 1 )
				{
					location.href="/laboratorio";

				}else

				{

					alerta('Login e/ou senha não encontrado.')

					$('form input:text').val('');

					$('form input:password').val('');

				}

			}

		});

	});



	$('.esqueceu').click(function()

	{

		//alert($('input[name="email"]').val());

		if( $('input[name="email"]').val() == '')

		{

			$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			alerta('Digite o email que deseja recuperar a senha.');

			$('input[name="email"]').focus();

		}else

		{

			$.ajax({

			dataType:'json',

			url:'/modal/recuperar.php',

			type:'POST',

			data: {'email': $('input[name="email"]').val()},

			beforeSend: function()

			{

				$('body').append('<div class="modal"><div class="box_alert"><p></p></div></div>');

			},

			success: function( data )

			{

				
				if( data.acao == 1 )

				{

					alerta(data.frase);

				}else

				{

					alerta(data.frase);

				}

			}

		});	

		}

	});

});





function alerta( mensagem )

{

	$('.box_alert p').html( mensagem );

	//$('.loading').css({'display':'block','background':'#000','z-index':'0'});

	$('.box_alert').fadeIn(1000);

	setTimeout(function(){

	$('.box_alert').fadeOut(	

						1000,

						function()

						{

							$('.modal').css({'display':'none','background':'url(/images/ajax-loader.gif) no-repeat center #000','z-index':'9999'});

							$('.modal').remove();

						})

				},2500);



}