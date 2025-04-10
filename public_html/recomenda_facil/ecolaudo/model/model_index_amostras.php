<?php

// salvar: index_amostras.php (antigo: todas_as_amostras_do_usuario_logado)

// $row['am__data']

//Solo e folha apenas samp_type
//Outros

 
//Folders
 $query_folders 	= "SELECT * FROM sf_web_users_folders WHERE fk_web_users = ".$usuario->getId()." AND replace( sf_fc_remove_acentuation(LOWER(folder_name)), ' ' , '') = replace( sf_fc_remove_acentuation(LOWER('".$folder."')), ' ' , '') ORDER BY folder_name";
$result_folders	= pg_query($conexao, $query_folders);
$num_rows_folders = pg_num_rows($result_folders);
$row_folders = pg_fetch_array($result_folders);




// FILTROS //

	$filtro1 = !empty($web_interessado) ? " AND UPPER(sf_samp_service.farm_owner) LIKE UPPER('%".$web_interessado."%') " : "";
	$filtro2 = !empty($web_fazenda) ? " AND UPPER(sf_samp_service.farm) LIKE UPPER('%".$web_fazenda."%') " : "";
	$filtro3 = !empty($web_amostras) ? " AND UPPER(sf_lab_type    .identification) LIKE UPPER('%".$web_amostras."%')" : '';
	$filtroData = (!empty($data_desde) && !empty($data_ate )) ? " AND DATE(sf_samp_service.cr_receive_date) BETWEEN '".$data_desde."' AND '".$data_ate."'" : '';
	

	//Filtro generico
    $filtro4 = '';
	if( $generico )
	{
        $filtro4 .=  " AND (";
        $filtro4 .=  "             UPPER( sf_samp_service       .farm_owner         ) LIKE '%".$generico."%'";
        $filtro4 .=  "          OR UPPER( sf_samp_service       .farm               ) LIKE '%".$generico."%'";
        $filtro4 .=  "          OR UPPER( sf_samp_service       .snumber            ) LIKE '%".$generico."%'";
        $filtro4 .=  "          OR UPPER( sf_lab_type           .identification     ) LIKE '%".$generico."%'";
        $filtro4 .=  "          OR UPPER( sf_samp_service       .laboratory_name     ) LIKE '%".$generico."%'";

        $isdate = @explode('/', $generico);
        if( @checkdate($isdate[1],$isdate[0], $isdate[2]) )
        {   
            $filtro4 .=  "      OR DATE ( sf_samp_service       .cr_receive_date    ) = '".$generico."'";
        }        

        $filtro4 .=  "          OR UPPER( sf_samp_service       .city               ) LIKE '%".$generico."%'";
        $filtro4 .=  "          OR UPPER( sf_samp_service       .state              ) LIKE '%".$generico."%'";
        $filtro4 .=  "    )";

    }



		$query = "
		SELECT    
             uor.pk_web_users_or    
            ,sv.cr_receive_date::date as am__data    
            ,sv.snumber as am__snumber    

            ,COALESCE(sf_recomendacoes_controle.qtty_rec, 0) as qtty_fert

            ,sf_recomendacoes_controle.id[1] as rec_id_1
            ,sf_recomendacoes_controle.id[2] as rec_id_2
            ,sf_recomendacoes_controle.id[3] as rec_id_3
            ,sf_recomendacoes_controle.id[4] as rec_id_4
            ,sf_recomendacoes_controle.id[5] as rec_id_5

            ,sf_recomendacoes_controle.cultura[1] as rec_cultura_1
            ,sf_recomendacoes_controle.cultura[2] as rec_cultura_2
            ,sf_recomendacoes_controle.cultura[3] as rec_cultura_3
            ,sf_recomendacoes_controle.cultura[4] as rec_cultura_4
            ,sf_recomendacoes_controle.cultura[5] as rec_cultura_5

            ,sf_recomendacoes_controle.status[1] as rec_status_1
            ,sf_recomendacoes_controle.status[2] as rec_status_2
            ,sf_recomendacoes_controle.status[3] as rec_status_3
            ,sf_recomendacoes_controle.status[4] as rec_status_4
            ,sf_recomendacoes_controle.status[5] as rec_status_5

            ,sf_recomendacoes_controle.message_error[1] as rec_message_1
            ,sf_recomendacoes_controle.message_error[2] as rec_message_2
            ,sf_recomendacoes_controle.message_error[3] as rec_message_3
            ,sf_recomendacoes_controle.message_error[4] as rec_message_4
            ,sf_recomendacoes_controle.message_error[5] as rec_message_5

            ,sv.pk_samp_service as am__pk_samp_service    
            ,sv.fk_laboratory as am__fk_lab    
            ,sv.fk_lab_type as am__folha    
            ,st.identification as matrix    
            ,sf_fc_profundity(sv.profundity)    
            ,sv.identif as am__identificacao   

            ,1::Integer as am__status    

            ,sv.city           as so__cidade    
            ,sv.state           as so__uf    
            
            ,sv.farm_owner      as pr__nome    
            ,sv.farm            as fz__propriedade  
            ,sv.imput_type
            ,CASE WHEN COALESCE(sv.fk_laboratory,1) = 1 THEN sv.laboratory_name ELSE sf_laboratory.identification END as laboratory_name
            ,sf_profundity.profundity as profundidade
    ";

		$q_from = " 

        FROM     
    (

        SELECT DISTINCT
            sf_web_users_or   .pk_web_users_or
           ,sf_samp_service   .pk_samp_service
           ,sf_samp_service   .cr_receive_date
           ,sf_samp_service   .snumber
           ,sf_samp_service.laboratory_name  
           ,sf_samp_service.farm_owner 
           ,sf_samp_service.farm                  
        FROM          
            sf_web_users_or           
            INNER JOIN sf_samp_service      ON ( sf_samp_service    .pk_samp_service    = sf_web_users_or.fk_samp_service )";
        

        if( ! empty($filtro4) || !empty($filtro3) )
        {
            $q_from .=  "
             INNER JOIN sf_lab_type          ON ( sf_lab_type        .pk_lab_type            = sf_samp_service.fk_lab_type         )";
        }

        $q_from .= "
                WHERE          
                sf_web_users_or     .fk_web_users = ".$usuario->getId();


        if ( $num_rows_folders )
        {
            $q_from .= " AND sf_web_users_or     .fk_web_users_folders = " . $row_folders['pk_web_users_folders'] ;
        } else 
        {
            $q_from .= " AND sf_web_users_or     .fk_web_users_folders is null";
        }

        
        if( ! empty($filtro4) )
        {
            // Filtro generico
            $q_from .= $filtro4;
        }else
        {
            // Filtro especifico
            if( ! empty($filtro1) )
            {
                $q_from .= $filtro1;
            }

            if( ! empty($filtro2) )
            {
                $q_from .= $filtro2;   
            }

            if( ! empty($filtro3) )
            {
                $q_from .= $filtro3;
            }

            if( ! empty($filtroData) )
            {
                $q_from .= $filtroData;
            }
        }

        $q_from .=" 
        ORDER BY
             sf_samp_service .cr_receive_date DESC
            ,sf_samp_service .snumber         DESC
            ,sf_samp_service.laboratory_name  
            ,sf_samp_service.farm_owner 
            ,sf_samp_service.farm 
        <limit_offset>
    ) as         uor "; 


    if( ( $pagina == 0 ) || ( $atupagina == 'true' ) )
    {
        $result_qnt = pg_query($conexao, str_replace('<limit_offset>', ' ', "select count(*) as qnt " . $q_from ));
        $array_qnt = @pg_fetch_all($result_qnt);
        $num_rows = $array_qnt[0]['qnt']; 
    }



    $q_from .="
    INNER JOIN sf_samp_service      sv      ON ( sv.pk_samp_service      = uor.pk_samp_service )     
    INNER JOIN sf_lab_type          st      ON ( st.pk_lab_type          = sv.fk_lab_type      )     
    LEFT JOIN sf_profundity                 ON ( sf_profundity.pk_profundity = sv.profundity )    
    LEFT JOIN sf_laboratory                 ON ( sf_laboratory.pk_laboratory = sv.fk_laboratory )
    LEFT JOIN sf_recomendacoes_controle ON (     sf_recomendacoes_controle.Laboratorio = 1
                                             AND sf_recomendacoes_controle.Amostra = sv.pk_samp_service
                                             AND sf_recomendacoes_controle.Ano = ".$usuario->getId()." )
    ORDER BY
             sv .cr_receive_date DESC
            ,sv .snumber         DESC
            ,sv.laboratory_name  
            ,sv.farm_owner 
            ,sv.farm";

	$query .= $q_from;

	if( $pagina > 0 )
	{
		$limit .= 'LIMIT 50 OFFSET ' . $pagina;
	}else
	{
		$limit .= 'LIMIT 50 OFFSET 0';
	}

    //Para debugar
    //print str_replace('<limit_offset>', $limit , $query);

	$result=pg_query($conexao, str_replace('<limit_offset>', $limit , $query) );	
		



?>




