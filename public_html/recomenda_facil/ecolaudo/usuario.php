<?php 
// Verificando login do usuário //

	session_start();
	require_once 'controller/login_usuario.php';
	require_once 'controller/login_sessao.php';
	require_once 'controller/login_autenticador.php';
	 
	$aut = Autenticador::instanciar();
	 
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}
	else {
		$aut->expulsar();
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lab.Online - Usuário</title>
<meta http-equiv="content-language" content="PT-br"/>
<meta http-equiv="X-UA-Compatible" content="IE=9;IE=10;IE=11;IE=Edge;" />
<link rel="icon" type="image/x-icon" href="/ecolaudo/favicon.ico" />
<link href="/ecolaudo/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/ecolaudo/css/fontes.css" rel="stylesheet" type="text/css" />
<link href="/ecolaudo/css/main.css" rel="stylesheet" type="text/css" />
<link href="/ecolaudo/css/opniao.css" rel="stylesheet" type="text/css"/>

<!-- necessário para funcionar o page-slide -->
<script src="/ecolaudo/js/jquery-1.7.1/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/ecolaudo/js/admin.js"></script>
</head>

<body>
<!-- MAIN -->
<div id="main">
    <div id="header" class="fonte_padrao">
    	<!-- dropdown menu de login -->
        	<?php include 'includes/menu_superior_login.php'; ?>
        <!-- dropdown menu de login -->
        <!-- menu nível01 -->
           <?php include 'includes/menu_header.php' ?>
        <!-- menu nível01 -->
        
        <!-- menu nível02 -->
           <div class="menu_nivel02">
                <div class="content">
                 	<span class="subtitle">Configurações gerais da conta</span>
                </div>	
           </div> 
        <!-- menu nível02 -->
    
    </div>   

    <div class="box_alert fonte_padrao">
        <p>&nbsp;</p>
    </div>  
	<!-- conteúdo principal (listagem das tabelas) -->
        <div id="conteudo">
			<table class="listagem_usuarios fonte_listagem_amostra">
                <tr class="nome">
                	 <input type="hidden" name="h-nome" value="<?php print $usuario->getNome(); ?>">
                     <td class="padding_left20"> Nome: </td> 
                     <td class="padding_left20 into" width="70%"> <span><?php print $usuario->getNome(); ?></span> </td> 
                     <td class="padding_left20"> <a href="javascript:void(0)">Editar</a> </td>
                </tr> 
                <tr class="disabled">	
                     <td class="padding_left20"> Email: </td> 
                     <td class="padding_left20"> <span><?php print $usuario->getEmail(); ?></span> </td> 
                     <td class="padding_left20"> <img src="/ecolaudo/imagens/cadeado.png" width="12" class="lock">  </td>
                </tr>
                <tr class="telefone">	
                	 <input type="hidden" name="h-telefone" value="<?php print $usuario->getTelefone(); ?>">
                     <td class="padding_left20"> Telefone: </td> 
                     <td class="padding_left20 into"> <span><?php print $usuario->getTelefone(); ?></span> </td> 
                     <td class="padding_left20"> <a href="javascript:void(0)">Editar</a> </td>
                </tr>
                <tr class="cidade">	
                	 <input type="hidden" name="h-cidade" value="<?php print $usuario->getCidade(); ?>">
                     <td class="padding_left20"> Cidade: </td> 
                     <td class="padding_left20 into"> <span><?php print $usuario->getCidade(); ?></span> </td> 
                     <td class="padding_left20"> <a href="javascript:void(0)">Editar</a> </td>
                </tr>
                <tr class="estado">	
                	 <input type="hidden" name="h-estado" value="<?php print $usuario->getEstado(); ?>">
                     <td class="padding_left20"> Estado: </td> 
                     <td class="padding_left20 into"> <span><?php print $usuario->getEstado(); ?></span> </td> 
                     <td class="padding_left20"> <a href="javascript:void(0)">Editar</a> </td>
                </tr>
                <tr class="senha">	
                	 <input type="hidden" name="h-senha" value="********">
                     <td class="padding_left20"> Senha: </td> 
                     <td class="padding_left20 into"> <span>******</span> </td> 
                     <td class="padding_left20"> <a href="javascript:void(0)" >Editar</a> </td>
                </tr>
        	</table>
        </div>    
    
    <div id="footer">
    	<a href="http://www.allims.com.br" target="_blank" class="logo_allims">
           	logo.Allims
    	</a>        
    </div>
<div class="loading"></div>
</div>
<!-- MAIN -->




</body>
</html>