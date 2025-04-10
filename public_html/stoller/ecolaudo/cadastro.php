<?php 
// Verificando login do usuário //
    header("Pragma: no-cache");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-cache, cachehack=".time());
    header("Cache-Control: no-store, must-revalidate");
    header("Cache-Control: post-check=-1, pre-check=-1", false);

	session_start();
	require_once 'controller/login_usuario.php';
	require_once 'controller/login_sessao.php';
	require_once 'controller/login_autenticador.php';

    require_once 'controller/login_autenticador.php';
	 
	$aut = Autenticador::instanciar();
	 
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}
	else {
		$aut->expulsar();
	}
	

    include 'model/conexao_bd.php';

    $conexao = conexao();
	//print_r($usuario);
// Verifica se o filtro foi ligado

//	$filtro = $_GET['filtro'];
	
	//print '<pre>';
	//print_r($_SERVER);
	//print '</pre>';

    if( isset($_GET['samp']) && is_numeric($_GET['samp']) )
    {
        $query_verificacao = "
            SELECT 
               sf_samp_service.imput_type
              ,COALESCE(sf_recomendacoes_controle.qtty_rec, 0) as qtty_fert
            FROM
              sf_samp_service
              LEFT JOIN sf_recomendacoes_controle ON (     sf_recomendacoes_controle.Laboratorio = 1
                                                         AND sf_recomendacoes_controle.Amostra = sf_samp_service.pk_samp_service
                                                         AND sf_recomendacoes_controle.Ano = " . $usuario->getId()  . " )
            WHERE 
              sf_samp_service.pk_samp_service = " . $_GET['samp'];
        $result_verificacao = @pg_query($conexao, $query_verificacao);
        $array_verificacao = @pg_fetch_assoc($result_verificacao);

        if( @pg_num_rows($result_verificacao) == 0 /*|| $array_verificacao['imput_type'] != 0*/ || $array_verificacao['qtty_fert'] != 0 )
        {
            header('Location: /amostras');
        }
   


        $query_principal = "
            SELECT 
              * 
            FROM
              sf_samp_service
            WHERE
              pk_samp_service = " . $_GET['samp'];
        $result_principal = @pg_query($conexao, $query_principal);
        $array_principal = @pg_fetch_assoc($result_principal);

     }


    function mostraData ($data) {
        if ($data!='') {
           return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4));
        }
        else { return ''; }
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Cadastro de Amostras</title>
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

<script type="text/javascript">
    //jQuery('.loading').css('display','block');
    $(document).ready(function()
    {
        jQuery('.loading').css('display','none');
    })

    
</script>
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
                 	<span class="subtitle">Cadastro de Amostra</span>
                </div>	
           </div> 
        <!-- menu nível02 -->
    
    </div>   
    <div class="loading" style="display: block"></div>
    <div class="box_alert fonte_padrao">
        <p>&nbsp;</p>
    </div> 
	<!-- conteúdo principal (listagem das tabelas) -->
        <div id="conteudo">
            <form class="fundo_cadastro">
			<table class="table_100 table_cadastro fonte_listagem_amostra">
                <!-- <tr>
                     <td class="padding_left20"> Tipo de Amostra: </td> 
                     <td class="padding_left20" colspan="3"> 
                        <?php 
                
                           // $query = 
                
                        ?>
                     </td>
                </tr> -->

                <tr>
                    <td class="padding_left20"> Laboratório:</td> 
                    <td class="padding_left20" colspan="3"> <input type="text" name="laboratorio" class="texto" value="<?php print htmlspecialchars($array_principal['laboratory_name']) ?>"> </td>
                </tr> 
                <!-- <tr class="disabled"> -->	
                <tr>
                    <td class="padding_left20"> Serviço: </td> 
                    <td class="padding_left20" colspan="3"> <input type="text" name="servico" class="texto" value="<?php print htmlspecialchars($array_principal['service_name']) ?>"> </td>
                </tr>
                
                <tr>
                    <td class="padding_left20"> Número Amostra: </td> 
                    <td class="padding_left20"> <input type="text" name="amostra" class="texto" value="<?php print htmlspecialchars($array_principal['snumber']) ?>"> </td>
                    <td class="padding_left20"> Data: </td> 
                    <td class="padding_left20"> <input type="text" name="data" class="texto data_completa" placeholder="00/00/0000" maxlength="10" value="<?php print mostraData($array_principal['cr_receive_date']) ?>"> </td>
                </tr> 
                <tr>
                    <td class="padding_left20"> Proprietário: </td> 
                    <td class="padding_left20" colspan="3"> <input type="text" name="proprietario" class="texto" value="<?php print htmlspecialchars($array_principal['farm_owner']) ?>"> </td>
                </tr> 
                <tr>
                    <td class="padding_left20"> Propriedade: </td> 
                    <td class="padding_left20" colspan="3"> <input type="text" name="propriedade" class="texto" value="<?php print htmlspecialchars( $array_principal['farm']) ?>"> </td>
                </tr> 
                <tr>
                    <td class="padding_left20"> Gleba: </td> 
                    <td class="padding_left20" colspan="3"> <input type="text" name="gleba" class="texto" value="<?php print htmlspecialchars($array_principal['farm_lot']) ?>"> </td>
                </tr> 
                <tr>
                    <td class="padding_left20"> Cidade: </td> 
                    <td class="padding_left20"> <input type="text" name="cidade" class="texto" value="<?php print htmlspecialchars($array_principal['city']) ?>"> </td>
                    <td class="padding_left20"> UF: </td> 
                    <td class="padding_left20"> <input type="text" name="uf" class="texto" value="<?php print htmlspecialchars($array_principal['state']) ?>"> </td>
                </tr> 


                

                <tr>
                    <td class="padding_left20"> Profundidade: </td> 
                    <td class="padding_left20"> 
                        <?php 
                            $query_profundidade = "SELECT * FROM sf_profundity WHERE pk_profundity > 0 ";
                            $result_profundidade = pg_query($conexao, $query_profundidade);

                            print '<select name="profundidade">';
                            while ( $array_profundidade = pg_fetch_array($result_profundidade) ) 
                            {
                                print '<option value="'.$array_profundidade['pk_profundity'].'" '.( $array_profundidade['pk_profundity'] == $array_principal['profundity'] ? 'selected': ''). '>'.$array_profundidade['profundity'].'</option>';
                            }
                            print '</select>';
                        ?>

                    </td>
                    <td class="padding_left20"> BagID: </td> 
                    <td class="padding_left20"> <input type="text" name="bagid" class="texto" value="<?php print htmlspecialchars($array_principal['bag_id']) ?>"> </td>
                </tr> 
                <tr>
                    <td class="padding_left20"> Identificação: </td> 
                    <td class="padding_left20" colspan="3"> <input type="text" name="identificacao" class="texto" value="<?php print htmlspecialchars($array_principal['identif']) ?>"> </td>
                </tr> 
                <tr>
                    <td class="padding_left20" valign="top"> Imagem: </td> 
                    <td class="padding_left20" valign="top" colspan="3"> 
                        <input type="file" name="img_file" accept="image/x-png,image/jpeg">

                        
                            <?php 
                                if( isset($_GET['samp']) )
                                {
                                    $root = $_SERVER["DOCUMENT_ROOT"];
                                    $uploadfile = '/ecolaudo/upload/00img_' . $_GET['samp'] . '_' . $usuario->getId();
                                   
                                    if( file_exists( $root . $uploadfile.'.png' ) )
                                    {
                                        print '<div class="img" style="display:inline-block;">';
                                        print '<img class="img_preview" src="' . $uploadfile . '.png">';       
                                    }else if( file_exists( $root . $uploadfile.'.jpg' ) )
                                    {
                                        print '<div class="img" style="display:inline-block;">';
                                        print '<img class="img_preview" src="' . $uploadfile . '.jpg">';          
                                    }else if( file_exists( $root . $uploadfile.'.jpeg' ) )
                                    {
                                        print '<div class="img" style="display:inline-block;">';
                                        print '<img class="img_preview" src="' . $uploadfile . '.jpeg">';       
                                    }else
                                    {
                                        print '<div class="img" style="display:none;">';
                                        print '<img class="img_preview" src="">';
                                    }
                                }else
                                {
                                    print '<div class="img" style="display:none;">';
                                    print '<img class="img_preview" src="">';
                                }
                            ?>
                            <a href="javascript:void(0)" class="remove"></a>
                            <input type="hidden" name="remove_img" value="0">
                        </div>
                        <!-- <img class="img_preview" src=""> -->
                    </td> 
                </tr> 
            </table>


            <?php
                $vowels = array("º", "¹", "²", "³", "°", " ", "+", "%", ".");
 

                $query_tables = "
                    SELECT
                        sf_pa_det_group.group_name
                       ,sf_pa_det_group.pk_pa_det_group
                       ,sub_sel.report_abbrev
                    FROM
                       (
                        SELECT 
                             report_abbrev
                            ,fk_pa_det_group
                            ,MIN(norder) as morder
                        FROM
                            sf_pa_det_res
                        WHERE
                                fk_lab_type = 1
                            AND to_question = true
                        GROUP BY
                            report_abbrev, fk_pa_det_group
                        ) as sub_sel
                        LEFT JOIN sf_pa_det_group ON sf_pa_det_group.pk_pa_det_group = sub_sel.fk_pa_det_group
                    ORDER BY
                        fk_pa_det_group, morder
                ";
                $result_tables = pg_query( $conexao, $query_tables );

                $group = '';
                $var = 0;
                while ( $array_tables = pg_fetch_array($result_tables) ) 
                {
                    $var++;
                    if( $group != $array_tables['pk_pa_det_group'] && $array_tables['pk_pa_det_group'] != 2 && $array_tables['pk_pa_det_group'] != 5)
                    {
                        if( $group != '' )
                        {
                            print '</table>';
                        }

                        print '<table class="table_cadastro fonte_listagem_amostra">';
                        print '<tr>';
                             print '<td colspan="4" class="padding_left20"><b><u>'.$array_tables['group_name'].'</u></b></td>';
                        print '</tr>';

                        print '<tr>';
                             print '<td class="padding_left20"> <b>Determinação</b> </td>';
                             print ( ($array_tables['group_name'] != 'Textura' && $array_tables['group_name'] != 'Macro (Cálculos)') ? '<td class="padding_left20"> <b>Extrator</b> </td> ' : '');
                             print ( $array_tables['group_name'] != 'Macro (Cálculos)' ? '<td class="padding_left20"> <b>Unidade</b> </td> ' : '');
                             print '<td class="padding_left20"> <b>Resultado</b> </td> ';
                       print '</tr>';
                    }

                        if( isset($_GET['samp']) )
                        {
                            $query_resultado_principal = "
                                SELECT
                                    *
                                FROM
                                    sf_samp_service_det
                                    INNER JOIN sf_pa_det_res ON sf_pa_det_res.pk_pa_det_res = sf_samp_service_det.fk_pa_det_res
                                WHERE
                                    sf_samp_service_det.fk_samp_service =  " . $_GET['samp'] . "
                                    AND sf_pa_det_res.report_abbrev = '" . $array_tables['report_abbrev'] . "'";
                            $result_resultado_principal = @pg_query($conexao, $query_resultado_principal);
                            $array_resultado_principal = @pg_fetch_assoc($result_resultado_principal);
                        }


                        if( ! isset($_GET['samp']) )
                        {
                            $query_default = "
                                        SELECT 
                                          fk_pa_det_res
                                          ,fk_pa_unity
                                        FROM
                                          sf_pa_det_default
                                        WHERE 
                                          fk_web_users = " . $usuario->getId() . "
                                          AND fk_laboratory = 1
                                          AND fk_pa_det_res in (
                                                                SELECT
                                                                    pk_pa_det_res
                                                                FROM
                                                                   sf_pa_det_res 
                                                                WHERE
                                                                       report_abbrev = '" . $array_tables['report_abbrev'] . "'
                                                                   AND to_question = true
                                                                ORDER BY
                                                                   report_technic )
                                        ORDER BY 
                                          pk_pa_det_default DESC
                                        LIMIT 1";
                            $result_default = pg_query( $conexao, $query_default );
                            $array_default = pg_fetch_assoc($result_default);
                        }


                        print '<tr>';
                            print '<td class="padding_left20"> '. $array_tables['report_abbrev'] . ' </td>';
                    
                            
                            $query_technic = "
                                SELECT
                                    pk_pa_det_res
                                    ,report_technic
                                FROM
                                   sf_pa_det_res 
                                WHERE
                                       report_abbrev = '" . $array_tables['report_abbrev'] . "'
                                   AND to_question = true
                                ORDER BY
                                   report_technic";



                            $result_technic = pg_query( $conexao, $query_technic );

                            if( $array_tables['pk_pa_det_group'] != 4 && $array_tables['pk_pa_det_group'] != 5 && $array_tables['pk_pa_det_group'] != 2 ) 
                            {
                                print '<td class="padding_left20"> ';
                                print '<select name="'.$var.'[extrator]" class="campo_extrator"  data-rel="'. trim(str_replace($vowels, "", $array_tables['report_abbrev'])).'">';
                            }
                            
                            while ( $array_technic = pg_fetch_array($result_technic) ) 
                            {

                                if( $array_tables['pk_pa_det_group'] == 4 || $array_tables['pk_pa_det_group'] == 5 || $array_tables['pk_pa_det_group'] == 2 ) 
                                {
                                    print '<input type="hidden" name="'.$var.'[extrator]" class="campo_extrator" data-rel="'.trim(str_replace($vowels, "", $array_tables['report_abbrev'])).'" value="'.( $array_resultado_principal['fk_pa_det_res'] != '' ? $array_resultado_principal['fk_pa_det_res'] : $array_technic['pk_pa_det_res'] ).'">';
                                    break;
                                    //'<option value="'.$array_technic['pk_pa_det_res'].'">'.$array_technic['report_technic'].'</option>';
                                }else
                                {
                                    if( ! isset($_GET['samp']) && $array_default['fk_pa_det_res'] != '' )
                                    {

                                        print '<option value="'.$array_technic['pk_pa_det_res'].'" '.( $array_technic['pk_pa_det_res'] == $array_default['fk_pa_det_res'] ? 'selected' : '' ).'>'.$array_technic['report_technic'].'</option>';
                                    }else
                                    {

                                        print '<option value="'.$array_technic['pk_pa_det_res'].'" '.( $array_technic['pk_pa_det_res'] == $array_resultado_principal['fk_pa_det_res'] ? 'selected' : '' ).'>'.$array_technic['report_technic'].'</option>';
                                    }

                                }
                            }

                            if( $array_tables['pk_pa_det_group'] != 4 && $array_tables['pk_pa_det_group'] != 5 && $array_tables['pk_pa_det_group'] != 2 ) 
                            {
                                print '</select>';
                                print '</td>';
                            }


                        $query_unity = "
                            SELECT
                                sf_pa_unity.pk_pa_unity
                               ,sf_pa_unity.abbrev
                            FROM
                               (
                                    SELECT
                                        sf_pa_det_res.fk_pa_unity as pk_pa_unity
                                    FROM
                                        sf_pa_det_res
                                    WHERE
                                        fk_lab_type = 1
                                        AND sf_pa_det_res.report_abbrev = '" . $array_tables['report_abbrev'] . "'
                                    UNION
                                    SELECT
                                        sf_pa_det_unity.pk_pa_unity
                                    FROM
                                        sf_pa_det_res
                                        INNER JOIN sf_pa_det_unity ON ( sf_pa_det_unity.pk_pa_det_res = sf_pa_det_res.pk_pa_det_res )
                                    WHERE
                                        fk_lab_type = 1
                                        AND sf_pa_det_res.report_abbrev = '" . $array_tables['report_abbrev'] . "'
                               ) as sub_sel
                                INNER JOIN sf_pa_unity ON sf_pa_unity.pk_pa_unity = sub_sel.pk_pa_unity
                            ORDER BY
                                sf_pa_unity.abbrev
                        ";

                        $result_unity = pg_query( $conexao, $query_unity );

                        if( $array_tables['pk_pa_det_group'] == 2) 
                        {
                            print '<td class="padding_left20"></td>';                            
                        }                    

                        print '<td class="padding_left20"> ';
                        print '<select name="'.$var.'[unidade]" class="campo_unity ' . ( $array_tables['pk_pa_det_group'] == 4 || $array_tables['pk_pa_det_group'] == 5 ? 'unity_textura' : '' ) . '" ' . ( $array_tables['pk_pa_det_group'] == 2 || $array_tables['pk_pa_det_group'] == 5 ? 'readonly' : '' ) . '  data-rel="'.trim(str_replace($vowels, "", $array_tables['report_abbrev'])).'" >';
                    

                        while ( $array_unity = pg_fetch_array($result_unity) ) 
                        {
                            if( ! isset($_GET['samp']) && $array_default['fk_pa_unity'] != '' )
                            {
                                print '<option value="'.$array_unity['pk_pa_unity'].'" '.( $array_unity['pk_pa_unity'] == $array_default['fk_pa_unity'] ? 'selected' : '' ).'>'.$array_unity['abbrev'].'</option>';
                            }else
                            {
                                print '<option value="'.$array_unity['pk_pa_unity'].'" '.( $array_unity['pk_pa_unity'] == $array_resultado_principal['ro_fk_pa_unity'] ? 'selected' : '' ).'>'.$array_unity['abbrev'].'</option>';
                            }
                        }
                        
                        if( $array_tables['pk_pa_det_group'] != 2 ) 
                        {
                            print '</select>';
                            print '</td>';
                        }
                        


                    print '<td class="padding_left20"> <input type="text" ' . ( $array_tables['pk_pa_det_group'] == 5 || $array_tables['pk_pa_det_group'] == 2 ? 'readonly' : '' ) . ' data-rel="'.trim(str_replace($vowels, "", $array_tables['report_abbrev'])).'" name="'.$var.'[resultado]" class="texto resultados campo_result" value="'.$array_resultado_principal['ro_result_report'].'"> </td>';

                    print '</tr> ';

                    $group = $array_tables['pk_pa_det_group'];
                }
                print '</table>';
            ?>







            <table class="table_cadastro table_100 fonte_listagem_amostra">
                <tr>
                        <?php 
                            if( $_GET['samp'] )
                            {
                                
                                print '<td class="padding_left20">';
                                print '<a href="javascript:void(0)" id="botao" data-id="'.$_GET['samp'].'" class="bt_down excluir">Excluir</a>';
                                print '<input type="hidden" name="operation" value="alt">';
                                print '<input type="hidden" name="samp_service" value="'.$_GET['samp'].'">';
                                print '</td>';
                            }
                         ?>
                        
                    
                    <td class="padding_left20">
                        <!-- <a href="javascript:void(0)" id="botao" class="bt_down cancelar">Cancelar</a> -->
                        <a href="javascript:void(0)" id="botao" data-id="<?php print $_GET['samp']; ?>" class="bt_down salvar">Salvar alterações</a>
                    </td>
                </tr>
        	</table>
            </form>
        </div>    
    
    <div id="footer">
        <a href="http://www.allims.com.br" target="_blank" class="logo_allims">
       		logo.Allims
        </a>        
    </div>

</div>
<!-- MAIN -->




</body>
</html>