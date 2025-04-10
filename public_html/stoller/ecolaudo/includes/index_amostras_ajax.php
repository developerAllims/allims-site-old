<?php
	// Verificando login do usuário //
	

	session_start();
	require_once '../controller/login_usuario.php';
	require_once '../controller/login_sessao.php';
	require_once '../controller/login_autenticador.php';


	$aut = Autenticador::instanciar();
	 
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}
	else {
		$aut->expulsar();
	}
	
	$data_desde 		= pg_escape_string(dataBanco($_POST['data_desde']));
	$data_ate 			= pg_escape_string(dataBanco($_POST['data_ate']));
	$web_interessado 	= pg_escape_string(convertem($_POST['web_interessado']));
	$web_fazenda 		= pg_escape_string(convertem($_POST['web_fazenda']));
	$web_amostras 		= pg_escape_string(convertem($_POST['web_amostras']));
	$generico 			= pg_escape_string(convertem($_POST['generico']));
	$pagina 			= @$_POST['pagina'] ? $_POST['pagina'] : 1 ;
	$pagina 			= ($pagina - 1) * 50;
	$folder 			= strtolower($_POST['folder']);

	$atupagina 			= ( $_POST['atupagina'] == 'true' ? 'true' : 'false' );
	//echo $generico;

	$html = '';
	
	include_once '../model/conexao_bd.php'; 	
	$conexao = conexao();

	include_once '../model/model_index_amostras.php';
	
	

	// Passando data "DD/MM/AAAA" para o banco "AAAA-MM-DD" //
	function dataBanco ($data) {
		if(count(explode("/",$data)) > 1)
		{
	        return implode("-",array_reverse(explode("/",$data)));
	    }else { return $data; }
	}	


	// Passando data do banco "AAAA-MM-DD" para "DD/MM/AAAA" //
	function mostraData ($data) {
		if ($data!='') {
		   return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4));
		}
		else { return ''; }
	}	
		
	//Função maiuscula com acentuação
	function convertem($term) 
	{
		$palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
		return trim($palavra); 
	}
	
	$html = '';
	// VARIAVEL HTML PARA FORMAR O QUE SERA APRESENTADO
		
		while ( $row = pg_fetch_array($result)) 
		{
		   $i++;	
				
			if( $i%2 == 1 )
			{		
							
				$html .= '<tr class="cor">';
			}
			
			// Solo //													
			if ( $row['am__folha'] == 1 ) 
			{ 
				$html .=  '<td class="lab01"></td>';
			};	
			// Folha //
			if ( $row['am__folha'] == 2 ) 
			{ 
				$html .=  '<td class="lab02"></td>';
			}
			// Fertilizante //
			if ( $row['am__folha'] == 3 ) 
			{ 
				$html .=  '<td class="lab03"></td>'; 
			}
			// Nutrição Animal //
			if ( $row['am__folha'] == 4 ) 
			{
				$html .=  '<td class="lab04"></td>'; 
			}
			// Meio Ambiente //
			if ( $row['am__folha'] == 5 ) 
			{				
				$html .=  '<td class="lab05"></td>';
			}
			// Nematóides //
			if ( $row['am__folha'] == 6 ) 
			{ 
				$html .=  '<td class="lab06"></td>';
			}
			// Microbiologia //
			if ( $row['am__folha'] == 7 ) 
			{
				$html .=  '<td class="lab07"></td>';
			}
			//Sementes
			if ( $row['am__folha'] == 9 ) 
			{ 
				//Falta Icone para Sementes
				$html .=  '<td class="lab02"></td>';
			}

			/*if( $row['locked_proto'] != 'f' || $row['locked_payament'] != 'f' || $row['am__status'] != 1 ) 
			{
				
				//$html .=  '<td><input type="checkbox" name="item" class="check_" disabled="disabled" ></td>';
				$html .=  '<td><img class="block" src="/ecolaudo/imagens/waiting.png" title="Amostra n�o finalizada" alt="Amostra n�o finalizada"/></td>';				$html .=  '<td><a href="javascript:void(0);" class="blocked">'.mostraData($row['am__data']).'</a></td>';
				$html .=  '<td><a href="javascript:void(0);" class="blocked">'.$row['am__snumber'].'</a></td>'; // nº da amostra //
				$html .=  '<td><a href="javascript:void(0);" class="blocked">'.utf8_decode($row['matrix']).'</a></td>'; // matriz //
				$html .=  '<td><a href="javascript:void(0);" class="blocked">'.utf8_decode($row['pr__nome']).'</a></td>'; // interessado //
				$html .=  '<td><a href="javascript:void(0);" class="blocked">'.utf8_decode($row['fz__propriedade']).'</a></td>'; // propriedade //
				$html .=  '<td><a href="javascript:void(0);" class="blocked">'.substr(utf8_decode($row['am__identificacao']),0,28).'</a></td>'; // identificacao //
				if( $usuario->getCan_Insert_Rec() == 't' || $usuario->getCan_Insert_Rec() == 'true' )
				{
					$html .=  '<td> -  </td>';
				}
				$html .=  '</tr>';							
				
			}else
			{*/
				$html .=  '<td ><input type=checkbox name=item class=check_ value=1 data-id="'.$row["am__pk_samp_service"].'" data-type="'. $row['am__folha'] .'" data-rel="'.str_replace('/','-',$row['am__snumber']).'" data-ajax="'. $row['pk_web_users_or'] .'"></td>';
				$html .=  '<td>'; // data (a seguir eu uso uma função q converte p/ formato br) //
				$html .=  '<a href="javascript:void(0);" data-ajax="'.$row["am__pk_samp_service"].'">'.mostraData($row['am__data']).'</a></td>';
				$html .=  '<td><a href="javascript:void(0);" data-ajax="'.$row["am__pk_samp_service"].'">'.$row['am__snumber'].'</a></td>'; // nº da amostra //
				$html .=  '<td><a href="javascript:void(0);" data-ajax="'.$row["am__pk_samp_service"].'">'.utf8_decode($row['laboratory_name']).'</a></td>'; // laboratory_name //
				$html .=  '<td><a href="javascript:void(0);" data-ajax="'.$row["am__pk_samp_service"].'">'.utf8_decode($row['matrix']).'</a></td>'; // matriz //
				

				$html .=  '<td><a href="javascript:void(0);" data-ajax="'.$row["am__pk_samp_service"].'">'.utf8_decode($row['pr__nome']).'</a></td>'; // interessado //
				$html .=  '<td><a href="javascript:void(0);" data-ajax="'.$row["am__pk_samp_service"].'">'.utf8_decode($row['fz__propriedade']).'</a></td>'; // propriedade //
				$html .=  '<td><a href="javascript:void(0);" data-ajax="'.$row["am__pk_samp_service"].'">'.utf8_decode($row['am__identificacao']).'</a></td>'; // identificacao //

				$html .=  '<td><a href="javascript:void(0);" data-ajax="'.$row["am__pk_samp_service"].'">'.utf8_decode($row['profundidade']).'</a></td>'; // profundidade //

				$html .=  '<td class="padding_left20"><button class="editar_amostra" data-rel="'.$row["am__pk_samp_service"].'" type="button"></button></td>'; //Botao editar



				if( $row['am__folha'] == 1 )
				{
					$html .=  '<td>';
						if( $row['qtty_fert'] < 5 )
						{
							$html .= '<button class="recomendar" data-id="'.$row["am__pk_samp_service"].'" type="button"></button>';
						}

						for( $int_rec = 1; $int_rec <= $row['qtty_fert']; $int_rec++ )
						{
							if( $row["rec_status_".$int_rec] == 0 ) 
							{
								
							}else if( $row["rec_status_".$int_rec] == 1 ) 
							{
								$html .= '<button class="rec_editar" title="'. utf8_decode($row["rec_cultura_".$int_rec]) .'" data-id="'.$row["am__pk_samp_service"].'" data-value="'.$row["rec_id_".$int_rec].'"></button>';

							}else if( $row["rec_status_".$int_rec] == 2 ) 
							{
								$html .= '<div class="calc_aguardando" title="'. utf8_decode($row["rec_cultura_".$int_rec]) .'" data-id="'.$row["am__pk_samp_service"].'"></div>';
							}else if( $row["rec_status_".$int_rec] == 3 ) 
							{
								$html .= '<div class="calc_erro" title="'. utf8_decode($row["rec_cultura_".$int_rec]) .'" data-rel="'.utf8_decode($row["rec_message_".$int_rec]).'" data-id="'.$row["am__pk_samp_service"].'" data-value="'.$row["rec_id_".$int_rec].'"></div>';
							}
						}
				
					$html .=  '</td>';								
					
					}else
					{
						$html .=  '<td style="text-align:center">-</td>';
					}

					$html .=  '</tr>';							
			}
			
		//}
		
		$json = array(
				'qnt_total' => $num_rows,
				'html'	    => utf8_encode($html)
				//,'query' => $query
				);
		//print_r($row);
		echo json_encode($json);
		exit;
?>	        





