<?php 
	include ('functions.php');
	require('acessos.php'); 
	require ('conex_bd.php');
	$conexao = conexao();

	$pk_steps = $_POST['samp'];

	$query  = "SELECT ep_fc_calcule_all_people_program_year( {$pk_steps} )";





	if(!pg_send_query($conexao, $query))
    die("ERRO Send_query");

    if(!($result = pg_get_result($conexao)))
    die("ERRO get_result");

    if(function_exists("pg_result_error_field"))
    {
        $fieldcode = array(  "PGSQL_DIAG_MESSAGE_PRIMARY", "PGSQL_DIAG_SEVERITY", "PGSQL_DIAG_SQLSTATE");
        foreach($fieldcode as $fcode)
        {
            if( pg_result_error_field($result, constant($fcode)) )
            {
            	if( pg_result_error_field($result, constant("PGSQL_DIAG_MESSAGE_PRIMARY") ) )
            	{
            		$error_code .= pg_result_error_field($result, constant("PGSQL_DIAG_MESSAGE_PRIMARY"));    
            		break;
            	}else
            	{
            		$error_code .= ' ' . pg_result_error_field($result, constant($fcode));      	
            	}
                
            }
        }
        //pg_free_result($result);
    }

    
    $array = @pg_fetch_assoc($result);
    
	
	$json = array(
					'error' => $array['ep_fc_calcule_all_people_program_year']
					,'frase' => $error_code
					);
			echo json_encode($json);
			exit;
?>