<?php
date_default_timezone_set('America/Sao_Paulo');
class db
{
	# ------------------------------------------------------------------ #
	public final function __construct()
	{
		global $conn;
		//$conn = @mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_DATABASE ) or die( 'Can`t establish database connection.<br>Check your connection' );
		//$db = @mysqli_select_db( DB_DATABASE, $conn ) or die( 'Can`t select database.' );
		$conn = pg_connect("host=".DB_HOST." dbname=".DB_DATABASE." user=".DB_USER." password=".DB_PASS) or die( "Can`t establish database connection.<br>Check your connection: ".pg_last_error() );
	}

	# ------------------------------------------------------------------ #
	public static function insert_id($result)
	{
		return pg_last_oid($result);
	}

	# ------------------------------------------------------------------ #
	public static function num_rows( $result )
	{
		return pg_num_rows( $result );
	}

	# ------------------------------------------------------------------ #
	public static function begin()
	{
		return pg_query( 'BEGIN' );
	}

	# ------------------------------------------------------------------ #
	public static function rollback()
	{
		return pg_query( 'ROLLBACK' );
	}

	# ------------------------------------------------------------------ #
	public static function commit()
	{
		return pg_query( 'COMMIT' );
	}

	# ------------------------------------------------------------------ #
	public static function query( $sql, $use_cache = false, $expires_hours = 2 )
	{
		//echo $sql;
		global $conn, $mc, $counter_new, $counter_cached;

		if ( strtolower( substr( trim( $sql ), 0, 6 ) ) != 'select' )
		{
			$use_cache = false;
		}

		if ( MEMCACHED && $use_cache )
		{
			$expires = 60 * 60 * $expires_hours;
			$key = md5( $sql );
			$results = $mc->get( $key );

			if ( $results )
			{
				$counter_cached++;
			}
			else
			{
				$counter_new++;
				$tmp = array();
				$results = pg_query( $conn, $sql );

				if ( $results != 1 && $results != 0 )
				{
					while ( $row = pg_fetch_object( $results ) )
					{
						$tmp[] = $row;
					}

					$results = $tmp;
				}

				$mc->set( $key, $results, false, $expires );
			}
		}
		else
		{
			$counter_new++;
			$tmp = array();
			//$results = pg_query( $conn, $sql );

			$results = @pg_query( $conn, $sql ); // or die($jsonReturn = "{\"submit_error\" : {\"sucess\" : false, \"message\" : \"Internal error uncoded " . $sql . "\", \"errorcode\" : \"-9999\"}}");

			//print_r( pg_fetch_assoc($results) );

			if ( $results != 1 && $results != 0 )
			{
				while ( $row = pg_fetch_object( $results ) )
				{
					$tmp[] = $row;
				}

				$results = $tmp;
			}else
			{
				$pasta = $_SERVER['DOCUMENT_ROOT'] . '/api/logs/';
				$name_txt = 'log_'.date('YmdHis');
				
				if( !($fp = fopen($pasta.$name_txt.".txt", "a") ) )
				{
					//print 'não foi possivel criar o arquivo' . $pasta.$name_txt;
				}
				else
				{
					$escreve = fwrite($fp, utf8_decode(pg_last_error($conn)));	
					fclose($fp);
				}

				die($jsonReturn = "{\"submit_error\" : {\"sucess\" : false, \"message\" : \"Internal error uncoded\", \"sql\" : \"" . $results . " -- " . $sql ." \", \"errorcode\" : \"-9999\"}}");
			}
		}
		return $results;
	}
}

$db = new db();
?>
