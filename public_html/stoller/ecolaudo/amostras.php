<?php 
    header("Pragma: no-cache");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-cache, cachehack=".time());
    header("Cache-Control: no-store, must-revalidate");
    header("Cache-Control: post-check=-1, pre-check=-1", false);
// Verificando login do usuÃ¡rio //

    //echo $_SERVER['HTTP_USER_AGENT'];
/*$browser = get_browser();
print '<pre>';
print_r($browser);
print '</pre>';*/



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
	

if( $_GET['folder'] == 'caixadeentrada' )
{
	$folder = '';	
}else
{
	$folder = $_GET['folder'];
}


	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Amostras</title>
<meta http-equiv="content-language" content="PT-br"/>
<meta http-equiv="X-UA-Compatible" content="IE=9;IE=10;IE=11;IE=Edge;" />
<link rel="icon" type="image/x-icon" href="/ecolaudo/favicon.ico" />
<link href="/ecolaudo/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/ecolaudo/css/fontes.css" rel="stylesheet" type="text/css" />
<link href="/ecolaudo/css/main.css" rel="stylesheet" type="text/css" />

<!-- necessÃ¡rio para funcionar o page-slide -->
<script type="text/javascript" src="/ecolaudo/js/jquery-1.7.1/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/ecolaudo/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/ecolaudo/js/admin.js"></script>

<link rel="stylesheet" type="text/css" href="/ecolaudo/js/jquery-1.7.1/jquery.pageslide.css" />
<link rel="stylesheet" href="/ecolaudo/css/font-awesome.css">
<link href="/ecolaudo/css/datepicker.css" rel="stylesheet" type="text/css"/>
<link href="/ecolaudo/css/opniao.css" rel="stylesheet" type="text/css"/>



    <link rel="stylesheet" type="text/css" href="/ecolaudo/plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
    <link rel="stylesheet" type="text/css" href="/ecolaudo/css/template.css">

    <script type="text/javascript" src="/ecolaudo/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/ecolaudo/plugins/ckeditor/samples/js/sample.js"></script>
    <script type="text/javascript" src="/ecolaudo/js/template.js"></script>

    <script type="text/javascript">
       /* $(document).ready(function()
        {
            //$( "ul li:nth-child(2)" )
            $('#conteudo_tabela tr td').each(function( index )
            {
                alert($(this).css('height'));
                //$('.fundo table thead tr th:nth-child('+index+')').css('height', $(this).css('height'));   
            });
        })*/
    </script>
</head>

<body>
<!-- MAIN -->
<div id="main">
	<div class="box_alert fonte_padrao">
     	<p>&nbsp;</p>
    </div> 

    <div class="box_recomendacao">
            
    </div>
    
    <div id="header" class="fonte_padrao">
    	<!-- dropdown menu de login -->
        	<?php
		
			
			//echo $_SERVER['SERVER_NAME'];
			 include $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/includes/menu_superior_login.php'; ?>
        <!-- dropdown menu de login -->
        <!-- menu nÃ­vel01 -->
           <?php include $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/includes/menu_header.php' ?>
        <!-- menu nÃ­vel01 -->
        
        <!-- menu nÃ­vel02 -->
           <div class="menu_nivel02">
                <div class="content">
                 	<div class="busca-geral">
	                    <input type="text" name="busca" placeholder="Procure uma amostra ..." class="busca fonte_input" maxlength="30">
                        <input type="submit" class="btn-busca" value="">

                        <input type="hidden" name="meuid" value="<?php print $usuario->getId(); ?>">
    				</div>                
                    <ul>
                        <li><div id="botao" class="bt_down filtro" data-desde="" data-ate="" data-interessado="" data-amostras=""  data-fazenda="" >Filtro</div></li>
                        <li><div id="botao" class="bt_down pastas">Pastas</div></li>
                        <li><div id="botao" class="bt_down amostra-email">Copiar p/ Email</div></li>
                        <li><div id="botao" class="bt_down importar">Importar</div></li>
                        <!-- <li><div id="botao" class="bt_down visualizar">Visualizar</div></li> -->
                        <!-- <li><div id="botao" class="bt_down grafico">GrÃ¡fico</div></li> -->
                    </ul>
                    
                    <div class="pagination">
                    	página 
                        <input type="text" name="pagina" class="pagina" maxlength="4">
                    	<!--<label class="current"></label>-->
                        de
                        <label class="all"></label>
                        <!--A data-value corresponde a pÃ¡gina anterior ou a próxima
                        	class enabled = disponivel para troca de pagina( enable só serve para ser usado no jquery) 
                            disabled= não disponivel ( essa classe contem a programação CSS ).
                        -->
                        
                        <input type="hidden" name="current_page" class="current_page" value="1">
                    	<div id="botao" class="bt_down previous_pag " data-value="0">&lt;</div>
                        <div id="botao" class="bt_down next_pag " data-value="2">&gt;</div>
                    </div>
                </div>	
           </div> 
        <!-- menu nÃ­vel02 -->
    
        <!-- header oculta -->
        <div id="header_oculta">
        
            <!-- menu nÃ­vel03 -->
               <div class="menu_nivel03">
                    <div class="content">
                        
                    </div>  
               </div> 
            <!-- menu nÃ­vel03 -->
        
        </div>
    <!-- header oculta -->
    </div>    
	
    
	<!-- conteÃºdo principal (listagem das tabelas) -->
    	<div class="fundo">
            <table>
            <!-- cabeÃ§alho da listagem_amostra -->
                <thead> 
                    <tr>    
                         <th width="40"> <div class="lab00" style="height:30px !important; margin-top: 0px !important; margin-bottom: -5px !important; margin-left: 5px;"></div> </th> 
                         <th width="40"> <div style="padding-top:1px !important; margin-top:-12px; margin-left: 5px;"> <input type="checkbox" name="chkbox" id="select_all" value="1" /></div> </th> 
                         <th> <div class="padding_left20">Data</div> </th> 
                         <th> <div class="padding_left20">Nº Amostra</div>  </th> 
                         <th> <div class="padding_left20">Laboratório</div>  </th> 
                         <th> <div class="padding_left20">Matriz </div></th> 
                         <th> <div class="padding_left20">Proprietário </div> </th> 
                         <th> <div class="padding_left20">Propriedade </div> </th> 
                         <th> <div class="padding_left20">Identificação </div> </th> 
                         <th> <div class="padding_left20">Profundidade </div> </th> 
                         <th width="80"> <div class="padding_left20">Edição </div> </th> 
                         <th width="110"> <div class="padding_left20">Rec. Agro. </div> </th>   
                    </tr> 
                </thead> 
            </table>   
        </div>
        <div id="conteudo">
			<table class="listagem_amostra fonte_listagem_amostra">
            <!-- cabeÃ§alho da listagem_amostra -->
                <thead class="topo_listagem"> 
                    <tr>	
                         <th width="40"> </th> 
                         <th width="40">  </th> 
                         <th> <div class="padding_left20">Data</div> </th> 
                         <th> <div class="padding_left20">Nº Amostra</div>  </th> 
                         <th> <div class="padding_left20">Laboratório</div>  </th> 
                         <th> <div class="padding_left20">Matriz </div></th> 
                         <th> <div class="padding_left20">Proprietário </div> </th> 
                         <th> <div class="padding_left20">Propriedade </div> </th> 
                         <th> <div class="padding_left20">Identificação </div> </th> 
                         <th> <div class="padding_left20">Profundidade </div> </th> 
                         <th width="80"> <div class="padding_left20">Edição </div> </th> 
                         <th width="110"> <div class="padding_left20">Rec. Agro. </div> </th>   
                    </tr> 
                </thead> 
                <tbody id="conteudo_tabela">
                </tbody>
        	</table>
        </div>    
	<!-- conteÃºdo principal (listagem das tabelas) -->
    
    <div id="footer">
    	
	<a href="http://www.allims.com.br" target="_blank" class="logo_allims">
       		logo.Allims
	</a>        
    </div>

    <div class="loading"></div>
    <div class="modal"></div>
    
    <div class="pergunta_grafico">
    	<div id="botao" class="bt_down sel_cultura" data-id="">Selecione uma cultura</div>
        <ul class="listagem">
        </ul>
    </div>

</div>
<!-- MAIN -->




</body>
</html>