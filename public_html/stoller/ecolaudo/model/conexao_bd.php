<?php
	function conexao()
	{
		if(@($conexao=pg_connect("host=recfac.postgresql.dbaas.com.br dbname='recfac' port=5432 user='recfac' password='r@allFal2209' connect_timeout=5"))) 
		{
			
		}else
		{
			return "Nao foi possível estabelecer uma conexão com o banco de dados.";
		}
		return $conexao;		
	}
	
	
	function pdo_conexao()
	{
		try 
		{
			$pdo = new PDO("pgsql:host=recfac.postgresql.dbaas.com.br dbname='recfac' port=5432 user='recfac' password='r@allFal2209' connect_timeout=5");
		} catch (PDOException  $e) 
		{
			return $e->getMessage();
			exit;			 
		}
	
		return $pdo;	
	}
?>