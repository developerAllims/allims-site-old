<?php 
	//VERIFICA USUARIO LOGADO
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


	include_once('conexao_bd.php'); 
	$conexao = conexao();



    $fileName =  '0000' . date('YmdHis') . utf8_encode($_FILES["file"]["name"]); // The file name
    $fileTmpLoc = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
    $fileType = $_FILES["file"]["type"]; // The type of file it is
    $fileSize = $_FILES["file"]["size"]; // File size in bytes
    $fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
    
    if (!$fileTmpLoc) 
    { // if file not chosen
        $error = "Selecione um arquivo";
        
        $json = array(
					'error' 	=> $error
					);
			echo json_encode($json);
			exit;
    }

    $content = '';
    if(move_uploaded_file($fileTmpLoc, "../upload/$fileName"))
    {
        $handle = fopen("../upload/$fileName", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) 
            {
                // process the line read.
                $content .= utf8_encode($line);
            }

            fclose($handle);
            @unlink("../upload/$fileName");


		    $query = "
		    	INSERT INTO
		    		sf_storage_data
		    		(
		    			 fk_web_users
		    			,data_type
		    			,date_insert
		    			,file_content
		    		)
		    	VALUES
				(
					" . $usuario->getId() . "
					, 0
					, NOW()
					,'" . pg_escape_string($content) . " '
				) RETURNING pk_storage_data";


			$result= @pg_query( $conexao , $query );
			$num_rows = @pg_num_rows($result);

			if( pg_num_rows($result) > 0)
			{
				$array_returning = pg_fetch_assoc($result);

				$query_log = "SELECT * FROM sf_storage_data_logs WHERE fk_storage_data = ". $array_returning['pk_storage_data'];
				$result_log = pg_query( $conexao, $query_log );

				$message = '';
				while ( $array_log = pg_fetch_array($result_log)) 
				{
					$message .= 'Linha: ' . $array_log['line_number'];
					$message .= ' - ' . $array_log['message'];
					$message .= '<br>';
				}
			}else
			{
				$error = "Erro ao tentar importar dados";
			}

        } else {
            // error opening the file.
            $error = "Erro ao tentar abrir o arquivo";
        }
    } else {
        $error = "move_uploaded_file function failed";
    }


	
	
	$json = array(
				'rows'		=> $num_rows,
				'message'	=> $message,
				'error' 	=> $error
				);
		echo json_encode($json);
		exit;
 
    //sf_storage_data

    // store file content as a string in $str
    //$str = file_get_contents($_FILES["file"]["name"]);
    //echo $str;


    /*print_r($_FILES);

	$filename = $_FILES['file']['tmp_file'];


	//$handle = fopen ($filename, 'r');
	$conteudo = file_get_contents( $filename );
	/*
	$conteudo = fread ($handle);
	fclose ($handle);*/

	/*print 'oi' . $conteudo;*/
?>