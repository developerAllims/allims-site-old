<?php 

	require_once ('functions.php');

	require_once ('conex_bd.php');

	$conexao = conexao();







	$query 	= "SELECT * FROM ep_users WHERE user_email = '" . pg_escape_string($_POST['email']) . "' AND is_active = true";

	$result = pg_query( $conexao, $query );



	if( pg_num_rows($result) == 1 )

	{



	

		$dados = pg_fetch_all($result);





		$corpo_email = '

			<!DOCTYPE html>

				<html>

				<head>

					<meta charset="utf-8">

					<title></title>

				</head>

				<body>

				<table width="576" border="0" cellpadding="0" cellspacing="0" style=" font-family: \'Verdana\'; color: #828282; font-size: 12px;  margin:0 auto; padding:0; ">

					<tr>

						<td><img src="http://www.allims.com.br/email_embrapa_paqlf/header_email_paqlf.jpg"></td>

					</tr>

					<tr height="30">

						<td style="border-bottom:1px solid #e4e4e3;"></td>

					</tr>

					<tr height="15">

						<td></td>

					</tr>

					<tr height="20">

						<td style="padding:0px 20px;">Olá <b>' . $dados[0]['user_name'] . '</b></td>

					</tr>

					<tr height="15">

						<td></td>

					</tr>

					<tr height="20">

						<td style="padding:0px 20px;">Segue abaixo email e senha de acesso para o Sistema PAQLF.</td>

					</tr>

					<tr height="15">

						<td></td>

					</tr>

					<tr height="20">

						<td style="padding:0px 20px;"><b>Email:</b> ' . $dados[0]['user_email'] . '</td>

					</tr>

					<tr height="20">

						<td style="padding:0px 20px;"><b>Senha:</b> ' . $dados[0]['user_password'] . '</td>

					</tr>

					<tr height="15">

						<td></td>

					</tr>

					<tr height="20">

						<td style="padding:0px 20px;">Obrigado,</td>

					</tr>

					<tr height="20">

						<td style="padding:0px 20px;">Equipe Embrapa Solos</td>

					</tr>

					<tr height="15">

						<td style="border-bottom:1px solid #e4e4e3;"></td>

					</tr>



					<tr>

						<td style="padding:0px 20px;"><font style="font-size: 8px;">Mensagem meramente informativa. Não responda a mesma.</font></td>

					</tr>

				</table>

				</body>

				</html>';









		require_once ('class.smtp.php');

	    require_once ('class.phpmailer.php'); //chama a classe de onde você a colocou.



	    $mail = new PHPMailer(); // instancia a classe PHPMailer

	    

	    $mail->IsSMTP();

	    //$mail->SMTPDebug  = true;

	    //configuração do locaweb

	    $mail->Port = '465'; //porta usada pelo gmail.

	    $mail->Host = 'smtplw.com.br'; 

	    $mail->IsHTML(true); 

	    $mail->Mailer = 'smtp'; 

	    $mail->SMTPSecure = 'ssl';

	    

	    //configuração do usuário do gmail

	    $mail->SMTPAuth = true; 

	    $mail->Username = 'marcelofcs'; // usuario locaweb.   

	    $mail->Password = 'UEfMyUFd7919'; // senha do email.

	    

	    $mail->SingleTo = true; 

	    



	    // configuração do email a ver enviado.

	    $mail->SetFrom('paqlf@paqlf.com.br', '=?UTF-8?B?'.base64_encode('Portal PAQLF').'?='); 

	    

	    $mail->addAddress($dados[0]['user_email']); // email do destinatario.

	    $mail->addAddress('webdesigner@allims.com.br'); // email do destinatario.

	    



	    $mail->Subject = '=?UTF-8?B?'.base64_encode('Portal PAQLF Administração - Recuperação de Senha').'?='; 

	    $mail->Body = $corpo_email;

	    



	    if(!$mail->Send())

	    {

	        $acao = 0;

	        $frase = 'Erro de envio de email!! </br> ' . $mail->ErrorInfo;

	    }else

	    {

	        $acao = 1;

	    	$frase = 'Email enviado com sucesso !';

	    }



	}else

	{

		$acao = 0;

    	$frase = 'Email não encontrado';

	}



    $json = array(

				'acao' => $acao,

				'frase' => $frase

				);

		echo json_encode($json);

		exit;

?>