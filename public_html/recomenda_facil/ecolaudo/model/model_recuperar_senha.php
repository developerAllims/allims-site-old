<?php
	$email = $_POST['recuperacao'];
	
include_once('conexao_bd.php'); 

$conexao = conexao();
$query 	= 'SELECT * FROM sf_web_users WHERE user_login = \'' . $email . '\'' ;
$result = pg_query( $conexao, $query );


if( pg_num_rows($result) )
{
	while( $linha = pg_fetch_array($result) )
	{
		$res_email 	= $linha['user_login'];
		$res_pass 	= $linha['user_password'];
	}


	// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
	// O return-path deve ser ser o mesmo e-mail do remetente.
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: Ecolaudo <labonline@ibra.com.br>\r\n"; // remetente
	//$headers .= "Return-Path: eu@seudominio.com\r\n"; // return-path
	
	
	$corpo_email = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Email</title>
<!--<style type="text/css">
	td{ padding:0 25px;}
</style>-->

</head>

<body style="padding:0; margin:0; font-family:Arial, Helvetica, sans-serif; color:#666;">
    <table style="width:80%;" bgcolor="#f1f1f1" cellpadding="0" cellspacing="0">
    	<tr height="70">
        	<td bgcolor="#6f9d41" style="border-bottom:1px solid #CCC; padding:0 10px;">
            	<img src="http://labonline.ibra.com.br/ecolaudo/imagens/email_teste_logo_header.png" />
            </td>
        </tr>
        <tr height="60" >
            <td style="padding:0 25px;"><strong>Ol&aacute; ' .  $res_email . '</strong></td>
        </tr>
        <tr>    
            <td style="padding:0 25px;">Segue abaixo email e senha de acesso para o <font color="#80a633">Sistema Lab.Online</font>.</td>
        </tr>
        <tr height="10">
        </tr>
        <tr height="25">
            <td style="padding:0 25px;"><strong>Email</strong>: ' . $res_email . '</td>
        </tr>
        <tr> 
            <td style="padding:0 25px;"><strong>Senha</strong>: ' . $res_pass . '</td>
        </tr>
        <tr>     
            <td style="padding:0 25px;"><a href="http://labonline.ibra.com.br/email/' .  $res_email . '" target="new"><img src="http://labonline.ibra.com.br/ecolaudo/imagens/email_teste_btn_login_email.png" style="margin:15px 0;" /></a></td>
        </tr>
        <tr height="40">
        </tr>
        <tr> 
            <td style="padding:0 25px;"><strong>Obrigado.</strong></td>
        </tr>
        <tr> 
            <td style="padding:0 25px;">Equipe Lab.Online</td>
         </tr>
        <tr>    
            <td style="padding:0 25px;"><a href="http://labonline.ibra.com.br">labonline.ibra.com.br</a></td>
        </tr>
        <tr height="20">
        </tr>
    </table>

<font size="2" color="#CCC">Lab.Online &eacute; o m&oacute;dulo online do ALLIMS. Para conhecer os outros m&oacute;dulos, acesse: <a href="http://www.allims.com.br">www.allims.com.br</a></font>
</body>
</html>';
	

    require_once('class.smtp.php');
    require_once('class.phpmailer.php'); //chama a classe de onde você a colocou.

    $mail = new PHPMailer(); // instancia a classe PHPMailer
    
    $mail->IsSMTP();
    //$mail->SMTPDebug  = true;
    //configuração do gmail
    $mail->Port = 587; //porta usada pelo gmail.
    $mail->Host = 'smtplw.com.br'; 
    $mail->IsHTML(true); 
    $mail->Mailer = 'smtp'; 
    $mail->SMTPSecure = 'tls';
    
    //configuração do usuário do gmail
    $mail->SMTPAuth = true; 
    $mail->Username = 'ibra'; // usuario gmail.   
    $mail->Password = 'bpIpWmzq5611'; // senha do email.
    
    $mail->SingleTo = true; 
    

    // configuração do email a ver enviado.
    $mail->SetFrom('ibra@ibra.com.br', '=?UTF-8?B?'.base64_encode('IBRA Laborátorio').'?='); 
    
    $mail->addAddress($res_email); // email do destinatario.
    
    $mail->Subject = '=?UTF-8?B?'.base64_encode('IBRA LabOnline - Recuperação de Senha').'?='; 
    $mail->Body = $corpo_email;
    

    if(!$mail->Send())
        echo 'Erro de envio de email !';
    else
        echo 'Email enviado com sucesso !';

    exit;
	/*
	
	$corpo_email = 'Segue abaixo email e senha de acesso para o Sistema EcoLaudo <br />';
	$corpo_email .= 'Email: ' . $res_email . ' <br /> ';
	$corpo_email .= 'Senha: ' . $res_pass . ' <br /> ';*/
	
	
	$envio = mail($res_email, 'IBRA LabOnline - Recuperação de Senha', $corpo_email , $headers);
	 
	if($envio)
	 echo 'Email enviado com sucesso !';
	else
	 echo 'Erro de envio de email !';
 
}else
{
	echo 'Nenhum email foi encontrado !';
}
?>