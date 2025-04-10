<?php 

	require('acessos.php'); 

	require('functions.php'); 

	require('conex_bd.php');

	$conexao = conexao();



	$description = $_POST['controle'];

	$criacao = inverteData($_POST['criacao']);

	$inf_add = $_POST['informacoes'];





	$data = @explode("/",$_POST['criacao']); // fatia a string $dat em pedados, usando / como referência

	$d = $data[0];

	$m = $data[1];

	$y = $data[2];



	$res = @checkdate($m,$d,$y);

	if ( $res != 1 )

	{

	   $frase = 'Data de Expedição Inválida';

	   $error = 1;



	   $json = array(

					'error' => $error

					,'frase' => $frase

					//'dados' => $query,

					//'acao'		=> 1

					);

			echo json_encode($json);

			exit;

	} 



	$query = "INSERT INTO ep_samp_control( description, manu_date, inf_add, log_date, log_fk_user ) VALUES ( '{$description}', '{$criacao}', '{$inf_add}', 'NOW()', {$user->getId()})";	

	$result = pg_query( $conexao, $query);

	

	$num_rows = pg_affected_rows($result);



	if( $num_rows > 0 )

	{

		$frase = 'Cadastro Realizado com Sucesso';

		$error = 0;



	}else

	{

		$frase = 'Cadastro não Realizado';

		$error = 1;

	}





	$json = array(

				'error' => $error

				,'frase' => $frase

				);

		echo json_encode($json);

		exit;

	

	

?>

