<?php 
	session_start();
	require_once 'controller/fpdf/fpdf.php';
	require_once 'model/conexao_bd.php';
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

	$conexao = conexao();
	$web_id_relatorio = $_GET['web_id_relatorio'];
	
	class PDF extends FPDF
	{
		function Header()
		{
			require_once 'model/conexao_bd.php';
			$conexao = conexao();

			$web_id_relatorio = $_GET['web_id_relatorio'];
			$query_header = "
				SELECT 
				   sf_samp_service.cr_receive_date::DATE  
				  ,sf_samp_service.snumber 
				  ,sf_samp_service.bag_id  
				  ,sf_fc_profundity(sf_samp_service.profundity)    
				  ,sf_samp_service.identif 
				  ,sf_samp_service.fk_laboratory
				  ,CASE 
				      WHEN ( sf_samp_service.fk_laboratory = 1 ) THEN
					sf_samp_service.laboratory_name
				      ELSE
					sf_laboratory.identification
				      END AS laboratory
				  
				  ,sf_samp_service.farm_owner   
				  ,sf_samp_service.farm       
				  ,sf_samp_service.city    
				  ,sf_samp_service.state    
				  ,sf_profundity.profundity as profundidade
				FROM   
				  sf_samp_service    
				  INNER JOIN sf_lab_type   ON ( sf_lab_type.pk_lab_type      	= sf_samp_service.fk_lab_type  )   
				  INNER JOIN sf_laboratory ON ( sf_samp_service.fk_laboratory  	=  sf_laboratory.pk_laboratory )
				  LEFT JOIN sf_profundity                 ON ( sf_profundity.pk_profundity = sf_samp_service.profundity )  
				WHERE 
				  sf_samp_service.pk_samp_service = " . $web_id_relatorio;

			$result_header = pg_query($conexao, $query_header);
			$array_header = pg_fetch_assoc($result_header);

			if( $array_header['fk_laboratory'] == 1 )
			{
				/*$this->Image('imagens/logo_spec.png',475,30,90,90);*/
			}else if( $array_header['fk_laboratory'] == 2 )
			{
				/*$this->Image('imagens/logo_lab_generalizado.png',475,30,90,90);*/
			}else
			{

			}
			$this->SetFont('Arial','',8);
			$this->SetXY(30,125);
			$this->SetFillColor(50,54,57);
			$this->SetTextColor(255,255,255);
			
			//Dados do Cliente
				$this->SetTextColor(255,255,255);
				$this->SetX(30);
				$this->Cell(535,15,'DADOS DO CLIENTE',0,1,'C',true);
				$this->SetTextColor(77,77,77);
				
				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Proprietário:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(460,15,$array_header['farm_owner'],0,1,'L',false);
				
				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Propriedade:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(460,15,$array_header['farm'],0,1,'L',false);
				
				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Cidade:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(270,15,$array_header['city'],0,0,'L',false);
				
				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Estado:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(125,15,$array_header['state'],0,1,'L',false);
			
			//Dados do amostra
				$this->SetTextColor(255,255,255);
				$this->SetX(30);
				$this->Cell(535,15,'DADOS DA AMOSTRA',0,1,'C',true);
				$this->SetTextColor(77,77,77);
				
				//Linha
				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Nº Amostra:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(150,15,$array_header['snumber'],0,0,'L',false);

				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Profundidade:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(100,15,$array_header['profundidade'],0,0,'L',false);
				
				$this->SetFont('Arial','B',8);
				$this->Cell(50,15,'Bag ID:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(95,15,$array_header['bag_id'],0,1,'L',false);
				
				//Linha
				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Laboratório:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(270,15,$array_header['laboratory'],0,0,'L',false);
				
				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Data Análise:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(125,15,mostraData($array_header['cr_receive_date']),0,1,'L',false);
				
				//Linha
				$this->SetFont('Arial','B',8);
				$this->Cell(70,15,'Identificação:',0,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(460,15,$array_header['identif'],0,1,'L',false);
				
				$this->Cell(50,10,'',0,1,'R',false);

		}
		
		function Footer()
		{
			$this->SetXY(30,-30);
			$this->SetDrawColor(77,77,77);
			$this->SetTextColor(77,77,77);
			$this->SetFont('Arial','',8);
			$this->Cell(178,13,'','T',0,'C',false);
			$this->Cell(179,13,'','T',0,'C',false);
			$this->Cell(178,13,'Pagina 1 de 1','T',0,'R',false);
		}
	}
	
	$pdf = new PDF('P','pt','A4');
	$pdf->AliasNbPages();
	
	//include 'model/model_amostra.php';
	
	
	$pdf->AddPage();	
	
	
	//FIM HEADER ---
		
		//Header tabela
			/*$pdf->Cell(535,15,'RESULTADOS ANALÍTICOS',1,1,'C',true);
			$pdf->SetX(28);
			
			$pdf->Cell(220,15,'Ensaio','TLB',0,'C',true);
			$pdf->Cell(110,15,'Resultado','TLB',0,'C',true);
			$pdf->Cell(70,15,'Unidade','TLB',0,'C',true);
			$pdf->Cell(135,15,'Técnica',1,1,'C',true);*/
	

	$query_body = "
			SELECT              
			  sf_samp_service_det.ro_result_report AS resultado  
			 ,sf_pa_det_res.report_identif AS det_desc 
			 ,COALESCE(sf_pa_unity.abbrev, '-')                         AS unidade
			 ,COALESCE(sf_pa_det_res.report_technic, '-')               AS tecnica
			FROM    
			  sf_samp_service_det    
			  INNER JOIN sf_pa_det_res   ON ( sf_pa_det_res    .pk_pa_det_res   = sf_samp_service_det.fk_pa_det_res   )    
			  INNER JOIN sf_samp_service ON ( sf_samp_service  .pk_samp_service = sf_samp_service_det.fk_samp_service )
			  LEFT  JOIN sf_pa_unity     ON ( sf_pa_unity      .pk_pa_unity     = sf_samp_service_det.ro_fk_pa_unity  )
			WHERE  
			      sf_samp_service_det.fk_samp_service =  " . $web_id_relatorio . "
			ORDER BY    
			  sf_samp_service_det.norder
			 ,sf_samp_service_det.fk_pa_det_res";
	$result_body = pg_query($conexao, $query_body);
	
	if( pg_num_rows($result_body) > 0 )
	{
		$pdf->SetFont('Arial','',8);
		$pdf->SetFillColor(50,54,57);
		$pdf->SetDrawColor(211,211,211);
		$pdf->SetTextColor(255,255,255);
		
		$pdf->Cell(535,15,'RESULTADOS ANALÍTICOS',1,1,'C',true);
		$pdf->SetX(28);
		
		$pdf->Cell(220,15,'Ensaio','TLB',0,'C',true);
		$pdf->Cell(110,15,'Resultado','TLB',0,'C',true);
		$pdf->Cell(70,15,'Unidade','TLB',0,'C',true);
		$pdf->Cell(135,15,'Técnica',1,1,'C',true);
	}

	while ( $row = pg_fetch_array($result_body) ) 
	{				
		//Valores
		$pdf->SetFillColor(5,154,126);
		$pdf->SetTextColor(77,77,77);
		$pdf->Cell(220,15,$row['det_desc'],'TLB',0,'L',false);
		$pdf->Cell(110,15,$row['resultado'],'TLB',0,'C',false);
		$pdf->Cell(70,15,$row['unidade'],'TLB',0,'C',false);
		$pdf->Cell(135,15,$row['tecnica'],1,1,'C',false);
	}
			
	//Fim
		$pdf->SetFont('Arial','',6);
		$pdf->SetDrawColor(50,54,57);
		$pdf->Cell(535,10,'Fim dos Resultados','T',1,'R',false);
		/*$pdf->Cell(535,10,'','B',1,'R',false);*/

		/*$pdf->SetFont('Arial','',8);
		$pdf->Cell(535,25,'O(s) resultado(s) contido(s) neste Relatório de Ensaio refere(m)-se somente a amostra enviada pelo cliente.',0,1,'C',false);*/
	
		

	
	$pdf->Output();



	function mostraData ($data) {
		if ($data!='') {
		   return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4));
		}
		else { return ''; }
	}	
?>