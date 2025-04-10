<?php
//print_r($_POST);
//print_r($_FILES);
//exit;
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
include_once("conexao_bd.php");
$conexao = conexao();

	//print_r($_POST);


	if( $_POST['operation'] == 'alt')
	{
		$query_samp_service = "
			UPDATE 
				sf_samp_service
			SET
				 fk_laboratory = 1
				,fk_lab_type = 1
				,snumber = '" . pg_escape_string($_POST['amostra']) . "'
				,cr_receive_date = " . ( dataBanco($_POST['data']) == 'null' ? 'null' : "'" . dataBanco($_POST['data']) . "'" ) . "
				,bag_id = '" . pg_escape_string($_POST['bagid']) . "'
				,farm_owner = '" . pg_escape_string($_POST['proprietario']) . "'
				,farm = '" . pg_escape_string($_POST['propriedade']) . "'
				,farm_lot = '" . pg_escape_string($_POST['gleba']) . "'
				,state = '" . pg_escape_string($_POST['uf']) . "'
				,city = '" . pg_escape_string($_POST['cidade']) . "'
				,profundity = "  . pg_escape_string($_POST['profundidade']) . "
				,identif = '" . pg_escape_string($_POST['identificacao']) . "'
				,service_name = '" . pg_escape_string($_POST['servico']) . "'
				,laboratory_name = '" . pg_escape_string($_POST['laboratorio']) . "'
			WHERE pk_samp_service = " . $_POST['samp_service'];
		$result_samp_service = pg_query( $conexao, $query_samp_service );

		if( ! @pg_affected_rows ($result_samp_service) )
		{
			$json = array(
					'error' => '10'
					//'query' => $query
					);
			echo json_encode($json);
			exit;
		}


		$query_samp_service_det = "";
		$qnt = 0;
		$var = $_POST;
		foreach( $var as $value )
		{
			if( is_array($value) )
			{
				$qnt = $qnt+10;
				$var_extrator  = '';
				$var_unidade   = '';
				$var_resultado = '';
				foreach ($value as $key2 => $value2)
				{
					if( $key2 == 'extrator' )
					{
						$var_extrator  = $value2;
					}else if( $key2 == 'unidade' )
					{
						$var_unidade   = $value2;
					}else if( $key2 == 'resultado' )
					{
						$var_resultado = $value2;
					}

				}
				
				$query_samp_service_det .= "
						SELECT 
							sf_fc_update_samp_service_det( 
								"  .  $_POST['samp_service']  . "
								," . $var_extrator . "
								," . $var_unidade . "
								," . ( empty($var_resultado) ? 'null' : $var_resultado = str_replace(',', '.', $var_resultado) ). "
								," . $qnt . ");";
			}
		}

		$result = @pg_query($conexao,$query_samp_service_det);

		if( ! @pg_affected_rows ($result) )
		{
			$json = array(
					'error' => '1'
					,'query' => $query_samp_service_det
					,'message' => ''
					);
			echo json_encode($json);
			exit;
		}
		

	}else
	{

		$query_samp_service = "
			INSERT INTO
				sf_samp_service
				(
					 fk_laboratory
					,fk_lab_type
					,snumber
					,cr_receive_date
					,bag_id
					,farm_owner
					,farm
					,farm_lot
					,date_include
					,imput_type
					,state
					,city
					,profundity
					,identif
					,service_name
					,laboratory_name
					,fk_web_users_include
				)
			VALUES
				(
				  1
				, 1
				, '" . pg_escape_string($_POST['amostra']) . "'
				, " . ( dataBanco($_POST['data']) == 'null' ? 'null' : "'" . dataBanco($_POST['data']) . "'" ) . "
				, '" . pg_escape_string($_POST['bagid']) . "'
				, '" . pg_escape_string($_POST['proprietario']) . "'
				, '" . pg_escape_string($_POST['propriedade']) . "'
				, '" . pg_escape_string($_POST['gleba']) . "'
				,NOW()
				,0
				, '" . pg_escape_string($_POST['uf']) . "'
				, '" . pg_escape_string($_POST['cidade']) . "'
				, "  . pg_escape_string($_POST['profundidade']) . "
				, '" . pg_escape_string($_POST['identificacao']) . "'
				, '" . pg_escape_string($_POST['servico']) . "'
				, '" . pg_escape_string($_POST['laboratorio']) . "'
				, "  . $usuario->getId() . "
				)
			RETURNING pk_samp_service
		";
		$result_samp_service = pg_query( $conexao, $query_samp_service );
		$samp_service = pg_fetch_assoc($result_samp_service);

		if( ! @pg_affected_rows ($result_samp_service) )
		{
			$json = array(
					'error' => '10',
					'query' => $query_samp_service
					,'message' => ''
					);
			echo json_encode($json);
			exit;
		}

		

		$query_samp_service_det = "";
		$qnt = 0;
		$var = $_POST;
		foreach( $var as $value )
		{
			if( is_array($value) )
			{
				$qnt = $qnt+10;
				$var_extrator  = '';
				$var_unidade   = '';
				$var_resultado = '';
				foreach ($value as $key2 => $value2)
				{
					if( $key2 == 'extrator' )
					{
						$var_extrator  = $value2;
					}else if( $key2 == 'unidade' )
					{
						$var_unidade   = $value2;
					}else if( $key2 == 'resultado' )
					{
						$var_resultado = $value2;
					}

				}
				
				$query_samp_service_det .= "
						SELECT 
							sf_fc_update_samp_service_det( 
								"  . $samp_service['pk_samp_service']  . "
								," . $var_extrator . "
								," . $var_unidade . "
								," . ( empty($var_resultado) ? 'null' : $var_resultado = str_replace(',', '.', $var_resultado) ). "
								," . $qnt . ");";
			}
		}
		//print $query_samp_service_det;
		$result = @pg_query($conexao,$query_samp_service_det);

		if( ! @pg_affected_rows ($result) )
		{
			$json = array(
					'error' => '1'
					,'message' => ''
					//,'query' => $query_samp_service_det
					);
			echo json_encode($json);
			exit;
		}


	}


/*	if( $_FILES['img_file']['size'] > 50000 )
	{
		$dados['erro'] = 4;
		echo json_encode($dados);
		exit;
	}
*/

	if( $_POST['remove_img'] == '1' )
	{
		$root = $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/upload/';
		$uploadfile = $root . '00img_' . $_POST['samp_service'] . '_' .$usuario->getId();

		if( file_exists( $uploadfile.'.png' ) )
		{
			@unlink($uploadfile . '.png');
		}else if( file_exists( $uploadfile.'.jpg' ) )
		{
			@unlink($uploadfile . '.jpg');
		}else if( file_exists( $uploadfile.'.jpeg' ) )
		{
			@unlink($uploadfile . '.jpeg');
		}

		
	}else
	{
		if( isset($_FILES) && !empty($_FILES) )
		{
			if( $_FILES['img_logo']['size'] > 5000000 )
			{
				$json = array(
							'error' => '4',
							'message' => '<br>Tamanho de Imagem superior a 5 MB'
							);
					echo json_encode($json);
					exit;
				exit;
			}


			$root = $_SERVER["DOCUMENT_ROOT"] . '/ecolaudo/upload/';
			if( isset( $_POST['samp_service'] ) )
			{
				$uploadfile = $root . '00img_' . $_POST['samp_service'] . '_' . $usuario->getId();
			}else
			{
				$uploadfile = $root . '00img_' . $samp_service['pk_samp_service'] . '_' .$usuario->getId();
			}
			
			//$uploadfile = $root . '00img_'.$usuario->getId();

			if( file_exists( $uploadfile.'.png' ) )
			{
				rename( $uploadfile.'.png', $uploadfile.'_.png' );
				$rename = $uploadfile.'_.png';
			}else if( file_exists( $uploadfile.'.jpg' ) )
			{
				rename( $uploadfile.'.jpg', $uploadfile.'_.jpg' );
				$rename = $uploadfile.'_.jpg';
			}else if( file_exists( $uploadfile.'.jpeg' ) )
			{
				rename( $uploadfile.'.jpeg', $uploadfile.'_.jpeg' );
				$rename = $uploadfile.'_.jpeg';
			}


			if( strripos($_FILES['img_file']['type'],'jpg') || strripos($_FILES['img_file']['type'],'jpeg') || strripos($_FILES['img_file']['type'],'png') )
			{
				$ext = explode('/',$_FILES['img_file']['type']);
				if( move_uploaded_file($_FILES['img_file']['tmp_name'], $uploadfile . '.' . $ext[1] ) )
				{
					@unlink($rename);
				}else
				{
					rename( $rename, substr($rename,1) );

					
					$json = array(
							'error' => '5'
							,'message' => ''
							//'query' => $query
							);
					echo json_encode($json);
					exit;
					/*$dados['error'] = 5;
					echo json_encode($dados);
					exit;*/
				}
			}
		}
	}
/*
	$dados['erro'] = 0;
	echo json_encode($dados);
	exit;
*/


	$json = array(
				'error' => '0'
				,'message' => ''
				//'query' => $query
				);
		echo json_encode($json);
		exit;


		// Passando data "DD/MM/AAAA" para o banco "AAAA-MM-DD" //
	function dataBanco ($data) {
		if(count(explode("/",$data)) > 1)
		{
			$explode_data = explode("/",$data);
			if( @checkdate($explode_data[1], $explode_data[0], $explode_data[2] ) )
			{
	        	return implode("-",array_reverse(explode("/",$data)));
			}else 
			{
				 return 'null'; 
			}

	    }else { return 'null'; }
	}	

	//function 
?>