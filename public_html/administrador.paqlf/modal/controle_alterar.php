<?php 

	require('acessos.php'); 

	require('functions.php'); 

	require('conex_bd.php');

	$conexao = conexao();



	$pk_samp_control = $_POST['programa'];

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

					);

			echo json_encode($json);

			exit;

	} 







	$query = "UPDATE 

				ep_samp_control SET 

					description = '{$description}', 

					manu_date = '{$criacao}', 

					inf_add = '{$inf_add}'

					,log_date = 'NOW()'

					,log_fk_user = ".$user->getId()."

			WHERE pk_samp_control = {$pk_samp_control}";	



	$result = pg_query( $conexao, $query);	

	$num_rows = pg_affected_rows($result);





	if( $num_rows > 0 )

	{

		$frase = 'Alteração Realizada com Sucesso';

		$error = 0;



	}else

	{

		$frase = 'Alteração não Realizada';

		$error = 1;

	}







	$json = array(

				'error' => $error

				,'frase' => $frase

				);

		echo json_encode($json);

		exit;

	

	

?>