<?php 
    require_once ('../modal/functions.php');
    require_once ('../modal/conex_bd.php');
    $conexao = conexao();

    $query_titulo = "SELECT number_year FROM ep_program_year WHERE pk_program_year = " . $_GET['samp'];
	$result_titulo = pg_query( $conexao, $query_titulo );
	$array_titulo = pg_fetch_all($result_titulo);


	print  $array_titulo[0]['number_year'];
?>