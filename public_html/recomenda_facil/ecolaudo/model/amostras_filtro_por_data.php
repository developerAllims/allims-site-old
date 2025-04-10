<?php
 
 	// Este arquivo vai deixar de existir, depois que eu terminar de implementar
	// no arquivo: model_index_amostras.php o filtro de data também, naquela
	// lógica de programação que deu certo (inserindo os filtros, quase que dinamicamente)
 
	// pego as variaveis necessárias para a query abaixo funcionar
	// (pego essas variáveis da sessao iniciada) 
	//session_start(); // é necessário iniciar sessão para eu poder passar os dados dessa pg. para outra pg.
	//$_SESSION['data_desde'] = $_POST['data_desde']; 
	//$_SESSION['data_ate'] = $_POST['data_ate']; 
 
 
 
/*
	Aqui geramos a Query respoável por pegar a listagem principal da página, quando o usuário loga no sistema
	essa listagem é sem filtros	passa todos os dados.
*/ 

//include_once("conexao_bd.php"); 
 
 
 
	
	 $result=pg_query($conexao, "SELECT 
				 uor.pk_web_users_or 
				,am.pk_samp as am__pk_samp 
				,sv.pk_samp_service as am__pk_samp_service 
				,am.cr_receive_date::date as am__data 
				,am.number_main as am__number_main 
				,sv.fk_lab as am__fk_lab 
				,am.fk_samp_type as am__solofolha 
				,am.nyear as am__nyear 
				,sv.fk_pa_service as am__tipoanalise 
				,pf.description as am__profundidade 
				,am.snumber as am__snumber 
				,lb_samp_identification(am.pk_samp, '  ') as am__identificacao 
				,CASE WHEN sv.st_date_finish_w_report IS NULL THEN 0::Integer ELSE 1::Integer END as am__status 
				,sv.st_date_finish_w_report::date as am__data_liberacao 
				-- ,sv.estimated_delivery as am__previsao 
				,CASE 
				  WHEN COALESCE(estimated_delivery_by_user, false) = true THEN sv.estimated_delivery_by_user_date  
				  ELSE sv.estimated_delivery 
				 END AS am__previsao 
				,pt.pk_proto as pt__pk_proto 
				,pt.service_date   as pt__data 
				,(COALESCE(pt.locked_proto, '0') = '1') as locked_proto
				,(COALESCE(pt.locked_payament, '0') = '1') as locked_payament
				,st.sn_complement  as am__solofolha 
				,st.pk_samp_type  
				,sl.report_description as sl__report_description 
				,so.pk_person      as so__pk_person 
				,so.person         as so__nome 
				,lb_fc_address_w_number (so.address, so.address_number) as so__endereco 
				,so.zip_code 		 as so__cep 
				,cy.city 	         as so__cidade 
				,es.state     	     as so__uf 
				,pr.pk_farms_owners as pr__pk_farms_owner 
				,pr.name            as pr__nome 
				,fz.pk_farms        as fz__pk_farms 
				,fz.farm            as fz__propriedade 
				,of.sreport_number  
				,of.n_report_number as report_number 
				,ps.identification_report  

	FROM 
		lb_web_users_or	        uor 
					INNER JOIN lb_samp_service 	sv ON ( sv.fk_official_reports = uor.fk_official_reports ) 
					INNER JOIN lb_samp	         am ON ( am.pk_samp   = sv.fk_samp  ) 
					INNER JOIN lb_proto         pt ON ( pt.pk_proto  = am.fk_proto ) 
					INNER JOIN lb_samp_type     st ON ( st.pk_samp_type = am.fk_samp_type ) 
					INNER JOIN lb_lab_samp_type sl ON ( sl.fk_samp_type = st.pk_samp_type and sl.fk_lab = sv.fk_lab ) 
					INNER JOIN lb_official_reports of ON ( of.pk_official_reports = sv.fk_official_reports ) 
					INNER JOIN cm_people        so ON ( so.pk_person = pt.fk_solic ) 
					INNER JOIN lb_pa_service    ps ON ( ps.pk_pa_service = sv.fk_pa_service ) 
					LEFT  JOIN lb_farms_owners  pr ON ( pr.pk_farms_owners = am.fk_farms_owners )
					LEFT  JOIN lb_farms         fz ON ( fz.pk_farms  = am.fk_farms )
					LEFT  JOIN cm_cities        cy ON ( cy.pk_city   = so.fk_city  )
					LEFT  JOIN cm_states        es ON ( es.pk_state  = cy.fk_state )
					LEFT  JOIN lb_profundity    pf ON ( pf.pk_profundity  = am.fk_profundity )

	WHERE
	
	
	
			
					uor.fk_web_users = ".$usuario->getId()." /* usuario logado */ 
					AND  sv.hidden_service <> '1' 
					AND am.cadaster_finalized
					
					AND DATE(cr_receive_date) BETWEEN '".$data_desde."' AND '".$data_ate."'
			
					
					
					
			
			
			

		/* CONTROLE DE PASTAS */
		/*	if (pasta == null || pasta.intValue() == 0){
				sql = sql + and uor.fk_web_users_folders is null  ;
			} else {
				sql = sql + and uor.fk_web_users_folders = ? ;
			}

			sql = sql + */
				ORDER BY  
						am__data DESC, am__snumber DESC   

				LIMIT 100 --  Rotinas.maxAmoPage.toString() + /* controle de paginas (paginacão) */ 
				OFFSET 0 ;");
				
					
		


?>











