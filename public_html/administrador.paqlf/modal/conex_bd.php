<?php



	function conexao()



	{



		//if(@($conexao=pg_connect ("host=localhost dbname=PAQLF port=5432 user=postgres password=root"))) 



		//if(@($conexao=pg_connect ("host=179.188.16.113 dbname=bd_paqlf port=5432 user=bd_paqlf password=o@jsLpaq92"))) 
		if(@($conexao=pg_connect ("host=179.188.16.157 dbname=paqlf_oficial port=5432 user=paqlf_oficial password=o@jsLpaq92")))


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



			//$pdo = new PDO("pgsql:host=179.188.16.113 dbname=bd_paqlf port=5432 user=bd_paqlf password=o@jsLpaq92");
			$pdo = new PDO("pgsql:host=179.188.16.157 dbname=paqlf_oficial port=5432 user=paqlf_oficial password=o@jsLpaq92");






			//host=192.168.7.23 dbname=PAQLF_2016_07_27 port=5432 user=postgres password=ilimsupdate");



			//host=localhost dbname=PAQLF port=5432 user=postgres password=root");



		 } catch (PDOException  $e) 



		 {



			return $e->getMessage();



			exit;



		 }



		



		return $pdo;



	}



?>