<?php 
	include '../model/conexao_bd.php';
	date_default_timezone_set('America/Sao_Paulo');


	$conexao = conexao();
	

	$query_cultures = "SELECT id_sf_tecnologia, id_sf_cultura, id_sf_versao FROM sf_cultures WHERE is_enabled = true AND project = 1 AND fk_technology = " . $_POST['fk_technology'] . " AND id = " . $_POST['fk_cultures'] . " ORDER BY identification";

	$result_cultures = pg_query($conexao, $query_cultures);
	$array_cultures = pg_fetch_assoc($result_cultures);


	$query_parametros = "SELECT * FROM sf_pa_culturas WHERE tecnologia = " . $array_cultures['id_sf_tecnologia'] . " AND cultura = " . $array_cultures['id_sf_cultura'] . " AND versao = " . $array_cultures['id_sf_versao'];

	$result_paramentros = pg_query($conexao, $query_parametros);
	$array_paramentros = pg_fetch_assoc($result_paramentros);	

	//print_r($array_paramentros)


	$html .= '<div class="combo">';
	if( $array_paramentros['questionardensidade'] == 'true' || $array_paramentros['questionardensidade'] == 't' )
	{
		//x metros mandar sempre M ( Metro )
		$result = 0;
		if (cvUnidadeMedida($array_paramentros['esprua'], 'CM', 'MT') * cvUnidadeMedida($array_paramentros['espcova'], 'CM', 'MT') > 0 )
     	{
     		$result = (
     			    	  10000 / 
     			    	  (
     			    	  	  cvUnidadeMedida($array_paramentros['esprua'],  'CM', 'MT') 
     			    	  	  * 
     			    	  	  cvUnidadeMedida($array_paramentros['espcova'], 'CM', 'MT')
     			    	  )
     			      );
		}else
		{
	     	$result = 0;
		}



		$html .= '
			<div class="inline espacamento">
				<p>Espaçamento</p> 
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td><span class="s_rua">Rua</span> </td>
						<td><span class="s_cova">Cova</span></td>
						<td><span>Plantas /ha</span></td>
					</tr>
					<tr>
						<td>
							<input type="text" name="esprua" value="' . str_replace('.',',',cvUnidadeMedida($array_paramentros['esprua'],  'CM', 'MT')) . '">&nbspx&nbsp
						</td>
						<td>
							<input type="text" name="espcova" value="' . str_replace('.',',',cvUnidadeMedida($array_paramentros['espcova'], 'CM', 'MT')) . '">&nbsp
						</td>
						<td>
							<input type="text" name="plantas-ha" readonly="readonly" tabindex="99" value="' . floor($result) . '">
						</td>
					</tr>
				</table>
			</div>';
	}


	if( $array_paramentros['temproducao'] == 'true' || $array_paramentros['temproducao'] == 't' )
	{
		$html .= '
			<div class="inline">
				<p>Produção Esperada</p>
					<input type="text" name="p-esperada" value="' . str_replace('.',',',$array_paramentros['pd_desejada']) . '">
					<span>' . $array_paramentros['pd_unidade'] . '</span>
			</div>';
	}
	$html .= '</div>';


	$html .= '<div class="combo">';
			$html .= '
				<div class="inline">
					<p>Produção Anterior</p>
					<input type="text" name="p-anterior" placeholder="Produção Anterior">
					<span>' . $array_paramentros['pd_unidade'] . '</span>
				</div>';
	$html .= '</div>';


	$html .= '<div class="combo">';
		if( $array_paramentros['questionarculturaanterior'] == 'true' || $array_paramentros['questionarculturaanterior'] == 't')
		{
			//$array_cultures['id_sf_tecnologia'] . " AND cultura = " . $array_cultures['id_sf_cultura'] . " AND versao = " . $array_cultures['id_sf_versao'];

			$query_anterior = "SELECT DISTINCT
								codigo
								, descricaocomum 
								FROM 
								sf_culturas_sf 
								INNER JOIN sf_pa_culturas ON ( sf_pa_culturas.tecnologia = " . $array_cultures['id_sf_tecnologia'] . " AND sf_pa_culturas.cultura = sf_culturas_sf.codigo AND sf_pa_culturas.produzMassaSeca = true  )
								ORDER BY descricaocomum";
			$result_anterior = pg_query($conexao, $query_anterior);

			$html .= '
					<div class="inline">
						<p>Cultura Anterior</p>
							<select name="c-anterior">';
								while ( $array_anterior = pg_fetch_array($result_anterior) ) 
								{
									$html .= '<option value="' . $array_anterior['codigo'] . '">' . $array_anterior['descricaocomum'] . '</option>';
								}
			$html .=		'</select>
					</div>';
		}

		
		if( $array_paramentros['utilizaresultadofoliar'] == 'true' || $array_paramentros['utilizaresultadofoliar'] == 't' )
		{
			$html .= '
				<div class="inline">
					<p>Amostra de Folha</p>
					<input type="text" name="amostra-folha" placeholder="Nº Amostra">
					<input type="text" name="ano-folha" placeholder="Ano Amostra" maxlength="4" value="'. date('Y') .'">
				</div>';
		}


		if( $array_paramentros['questionarclasseresposta'] == 'true' || $array_paramentros['questionarclasseresposta'] == 't'  )
		{
			if( ( $array_paramentros['cr_naoquestionarrfoliar'] == 'true' || $array_paramentros['cr_naoquestionarrfoliar'] == 't' ) /*&&  amostra de folha estiver preenchido */ )
			{
				$html .= '
					<div class="inline">
						<p>Classe de Resposta</p>
							<select name="c-resposta">
								<option value="0">Alta</option>
								<option value="1">Média</option>
								<option value="2">Baixa</option>
							</select>
					</div>';
			}
			
		}
	$html .= '</div>';
	

	



	$html .= '<div class="combo">';
		if( $array_paramentros['questionarm3solocova'] == 'true' || $array_paramentros['questionarm3solocova'] == 't' )
		{
			$html .= '
					<div class="inline">
						<p>Tamanho da cova</p>
						<input type="text" name="t-cova">
					</div>
					';
		}

		if( $array_paramentros['questionarsementes'] == 'true' || $array_paramentros['questionarsementes'] == 't' )
		{
		
			$html .= '
				<div class="inline">
				<p>Quantidade de Sementes</p>
					<input type="text" name="q-sementes" value="'.str_replace('.',',',$array_paramentros['qtdesementes']).'">
					<span>' . $array_paramentros['unidsementes'] . '</span>
				</div>';
		}


		if( $array_paramentros['questionarcalda'] == 'true' || $array_paramentros['questionarcalda'] == 't' )
		{
		
			$html .= '
					<div class="inline">
					<p>Quantidade de Calda</p>
						<input type="text" name="q-calda" value="'.str_replace('.',',',$array_paramentros['caldapulverizacao']).'">
						<span>' . $array_paramentros['unidpulverizacao'] . '</span>
					</div>';
		}
    
		$html .= '<input type="hidden" name="hidden_classe_resposta" value="'.$array_paramentros['questionarclasseresposta'].'">';
	    $html .= '<input type="hidden" name="hidden_classe_espacamento" value="'.$array_paramentros['questionardensidade'].'">';
	    $html .= '<input type="hidden" name="hidden_classe_p_unidade" value="'.$array_paramentros['pd_unidade'].'">';
		$html .= '<input type="hidden" name="hidden_classe_c_resposta" value="'.$array_paramentros['questionarclasseresposta'].'">'; 	
	    $html .= '<input type="hidden" name="hidden_classe_s_unidade" value="'.$array_paramentros['unidsementes'].'">';
		$html .= '<input type="hidden" name="hidden_classe_c_unidade" value="'.$array_paramentros['unidpulverizacao'].'">'; 
		$html .= '<input type="hidden" name="hidden_classe_r_foliar" value="'.$array_paramentros['utilizaresultadofoliar'].'">'; 

		$html .= '<input type="hidden" name="hidden_pd_minima" value="'.$array_paramentros['pd_minima'].'">'; 
		$html .= '<input type="hidden" name="hidden_pd_maxima" value="'.$array_paramentros['pd_maxima'].'">'; 

	$html .= '</div>';

	$html .= '<div class="combo">';
	    $html .= '<button type="button" class="btn_enviar bt_down" style="float:right; margin-right:0px; padding-top:0px; cursor:pointer;">Enviar</button>';    $html .= '</div>';

   




	    function cvUnidadeMedida( $valor, $unidFonte, $unidDestino)
	    {

	     	$erro = 0;
  			  // Transforma em centimetros;
			if ( $unidFonte == 'CM' )
			{

			}else if ($unidFonte == 'MT') 
			{
				$valor = $valor * 100;
			}else if ($unidFonte == 'PO') 
			{
				$valor = $valor * 2.54;
			}else
			{
				$erro = 1;
			} 

			  // Transforma na destino
			if( $unidDestino == 'CM')
			{

			} else if ($unidDestino == 'MT' )
	     	{
	     		$valor = $valor / 100;
	     	}  else if ($unidDestino == 'PO') 
		    {
		    	$valor = $valor / 2.54;
		    } else
			{
				$erro = 1;	
			} 

			if ( $erro == 0 ) 
			{
			     return $valor;
			} else
			{
		        return 0;
			}
	    }



	  $json = array(
					'html' => $html
				);
			echo json_encode($json);
			exit;	

?>