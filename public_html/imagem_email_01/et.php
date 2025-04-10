<?php
	
	$uri = $_SERVER['REQUEST_URI'];
	$conexao = pg_connect("host=lims_update.postgresql.dbaas.com.br dbname=lims_update port=5432 user=lims_update password=sira19lims70");
	$query="insert into email_log (message) values ('" . $uri . "')";
	$result=pg_query($conexao,$query);


	header('Content-Type: image/jpeg');
	readfile('logo_embrapa2_cor.jpg');
	exit;
?>