<?php
	session_start();
	session_destroy(); 
	$retorno_login = $_GET['retorno_login'];
?>
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login</title>
<link rel="icon" type="image/x-icon" href="/ecolaudo/favicon.ico" />
<meta http-equiv="content-language" content="PT-br"/>
<meta http-equiv="X-UA-Compatible" content="IE=9;IE=10;IE=11;IE=Edge;" />

<link href="/ecolaudo/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/ecolaudo/css/fontes.css" rel="stylesheet" type="text/css" />
<link href="/ecolaudo/css/login.css" rel="stylesheet" type="text/css" />
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script type="text/javascript" src="/ecolaudo/js/jshake-1.1.min.js"></script>

<script>

$(document).ready(function(){
	
	var ua = navigator.userAgent;
	var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
	if (re.exec(ua) != null)
	{
		var rv = parseFloat( RegExp.$1 );
	}
	//alert(rv);
	//alert(navigator.appName);

	if ( rv < 9) 
	{
		
	  	$('#conteudo').css('height', ($('#main').innerHeight() - 175) + 'px');
		
		$('.usuario').each(function(){
			valor = $(this).attr('placeholder');
			$(this).val(valor);
		});
		$('input[type=password]').each(function(){
			valor = $(this).attr('placeholder');
			$(this).val(valor);
		});
		
		$('input[type=text]').click(function(){
			$(this).val('');
		});
		$('input[type=text]').blur(function(){
			if( $(this).val() == '' )
			{
				valor = $(this).attr('placeholder');
				$(this).val(valor);
			}
		});
		
		$('input[type=password]').click(function(){
			$(this).val('');
		});
		$('input[type=password]').blur(function(){
			if( $(this).val() == '' )
			{
				valor = $(this).attr('placeholder');
				$(this).val(valor);
			}
		});
	}
	
	
	
	var confirmacao = "<?php echo $retorno_login ?>";
	if ( confirmacao == "falha" ) {
    	$( "#box_login" ).effect( "shake" );
	}


	$('.recuperar').click(function()
	{
		if( rv == 8 )
		{
			$('.usuario').val($('.usuario').attr('placeholder'));
		}
		else
		{
			$('.usuario').val('');
		}
		$('.usuario').css('margin-top','40px');
		
		$('.senha').css('display','none');
		$('.senha').val('');
		$('#lembrar').attr('checked',false);
		$('.oculta_principal').css('display','none');
		$('.botao_submit').val('enviar');
		$('.oculta_recuperacao').css('display','block');
		
		$('.botao_submit').addClass('submit_lembre');
	});
	
	//Submit recuperação de senha
	$('.botao_submit').click(function(event)
	{
		//alert($(this).hasClass('submit_lembre'));
		if( $(this).hasClass('submit_lembre') )
		{
			event.preventDefault();
			
			$.ajax({
				//dataType:'json',
				url: '/ecolaudo/model/model_recuperar_senha.php',
				data: { recuperacao : $('.usuario').val() },
				type: 'POST',
				beforeSend: function()
				{
					
				},
				success: function(data)
				{
					$('.loading').css({'display':'block','background':'#000','z-index':'9999'});
					$('.box_alert p').html( data );
					$('.box_alert').fadeIn(1000);
					setTimeout(function(){
					$('.box_alert').fadeOut(	
										1000,
										function()
										{
											if(rv == 8)
											{
												$('.usuario').val($('.usuario').attr('placeholder'));
											}else
											{
												$('.usuario').val('');
											}
											$('.usuario').css('margin-top','0');
											
											$('.senha').css('display','block');
											
											if(rv == 8)
											{
												$('.senha').val('*******');
											}else
											{
												$('.senha').val('');
											}
											
											
											$('.oculta_principal').css('display','block');
											$('.botao_submit').val('logar');
											$('.oculta_recuperacao').css('display','none');
											
											$('.botao_submit').removeClass('submit_lembre');
											$('.loading').css({'display':'none','background':'url(/ecolaudo/imagens/ajax-loader.gif) no-repeat center #000','z-index':'9999'});
										})
								},2500);					
				}
			});
			
			
					
			
		}	
	});
	
	$('.oculta_recuperacao').click(function()
	{
		$(this).css('display','none');
		
		$('.usuario').css('margin-top','0');
		
		if(rv == 8)
		{
			$('.usuario').val($('.usuario').attr('placeholder'));
			$('.senha').val('*******');
		}else
		{
			$('.usuario').val('');
			$('.senha').val('');
		}

		$('.senha').css('display','block');
		
		$('.oculta_principal').css('display','block');
		$('.botao_submit').val('logar');
		
		$('.botao_submit').removeClass('submit_lembre');
	});	
})
</script>



</head>

<body>


<div id="login">

	<div class="metade_cima">
    	
    </div>
	<div class="metade_baixo">
    	
    </div>
    
    <div class="box_alert fonte_padrao">
    	<p>&nbsp;</p>
    </div>    
    
    <div id="box_login" class="box_login">
	<div class="loading"></div>
    
    	<div class="formulario">
        	<!--<div class="fonte_padrao">
                <p><br><br><br><br>Página em manutenção. <br><br>Desculpe-nos o transtorno.</p>
            </div>  -->
            <form action="/ecolaudo/controller/login_controle.php" method="post" target="_self">
                <input id="email" name="email" autocomplete="off" type="text" placeholder="usuário (email)" class="box_form_login usuario fonte_padrao" value="<?php
							 if (isset($_COOKIE['email_eco'])) 
							 { 
							 	print $_COOKIE['email_eco'];
							 }else if( isset($_GET['email'] ) )
							 {
								 print $_GET['email'];
							 } 
					?>">
                <input id="senha" name="senha" type="password" placeholder="senha" class="box_form_login senha fonte_padrao" value="<?php print isset($_COOKIE['pass_eco'])? $_COOKIE['pass_eco']:""; ?>">
                <input name="acao" type="submit" value="logar" class="botao_submit fonte_padrao">
                <div class="lembre fonte_padrao oculta_principal">
                	<input type="checkbox" name="lembrar" id="lembrar" <?php print ( isset($_COOKIE['email_eco']) && isset($_COOKIE['pass_eco'])) ? 'checked="checked"':""; ?>> 
              
                   	<label for="lembrar">Lembrar usuário</label>
              	
                	<label class="recuperar">Esqueceu sua senha?</label>
               	</div>
                 <div class="lembre fonte_padrao oculta_recuperacao">
                	<label class="cancelar"><< Cancelar</label>
               	</div>
            </form>
               
        </div>
        
    </div>
    
    <div id="footer">
    	<a href="http://www.allims.com.br" target="_blank" class="logo_allims">
        	logo.Allims
    	</a>
    </div>   
</div>

</body>
</html>