<?php
class util
{
	# ------------------------------------------------------------------ #
	public static function clear_string( $string )
	{
		$string = trim( $string );
		$string = str_replace( "\'", '`', $string );
		$string = str_replace( "'", '`', $string );
		$string = str_replace( "--", '', $string );
		return $string;
	}
	
	# ------------------------------------------------------------------ #
	public static function clear_file_name( $name )
	{
		$table = array(
			'Š'=>'S', 'š'=>'s', 'Đ'=>'D', 'đ'=>'d', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
			'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
			'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
			'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
			'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
			'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
			'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
			'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r'
		);
		
		$out = strtr( $name, $table );
		$out = preg_replace( "[^a-zA-Z0-9_.]", "-", $out );
		
		while ( strpos( $out, '--' ) !== false )
		{
			$out = str_replace( '--', '_', $out );
		}
		$out = str_replace( ' ', '_', $out );
		$out = str_replace( '-', '_', $out );
		$out = str_replace( '(', '_', $out );
		$out = str_replace( ')', '_', $out );
		$out = str_replace( '+', '_', $out );
		$out = str_replace( '*', '_', $out );
		
		return strtolower( trim( $out, '-' ) );
	}
	
	# ------------------------------------------------------------------ #
	public static function textilize( $text )
	{
		$text = nl2br( $text );
		return $text;
	}
	
	# ------------------------------------------------------------------ #
	public static function get_nice_time( $date )
	{
		if ( empty( $date ) )
		{
			return "No date provided";
		}
		
		$periods = array( "second", "minute", "hour", "day", "week", "month", "year", "decade" );
		$lengths = array( "60", "60", "24", "7", "4.35", "12", "10" );
		$now = time();
		$unix_date = strtotime( $date );
		
		if ( empty( $unix_date ) )
		{    
			return "Bad date";
		}
		
		if ( $now == $unix_date )
		{
			return "right now";
		}
		elseif ( $now > $unix_date )
		{    
			$difference = $now - $unix_date;
			$tense = "ago";
		}
		else
		{
			$difference = $unix_date - $now;
			$tense = "from now";
		}
		
		for ( $j = 0; $difference >= $lengths[$j] && $j < count( $lengths ) - 1; $j++ )
		{
			$difference /= $lengths[$j];
		}
		
		$difference = round( $difference );
		
		if ( $difference != 1 )
		{
			$periods[$j] .= "s";
		}
		
		return "$difference $periods[$j] {$tense}";
 	}
	
	# ------------------------------------------------------------------ #
	public static function get_save_sql( $object, $force_insert )
	{
		foreach ( get_class_vars( get_class( $object ) ) as $key => $value )
		{
			switch ( $key )
			{
				case 'created_at':
					$keys_values[] = "`" . $key . "` = '" . ( $object->id ? $object->$key : date( 'Y-m-d H:i:s' ) ) . "'";
					break;
					
				case 'updated_at':
					$keys_values[] = "`" . $key . "` = '" . date( 'Y-m-d H:i:s' ) . "'";
					break;
				default:
					if( ! empty( $object->$key ) )
					{
						if( $object->$key == 'NULL' )
							$keys_values[] = "`" . $key . "` = NULL ";
						else if( $object->$key == " 0 " )
							$keys_values[] = "`" . $key . "` = 0 ";
						else
							$keys_values[] = "`" . $key . "` = '" . $object->$key . "'";
					}
					break;
			}
		}
		
		$keys_values = implode( ',', $keys_values );
		
		if ( $force_insert == false && $object->id )
		{
			return 'UPDATE ' . get_class( $object ) . ' SET ' . $keys_values . ' WHERE id = ' . $object->id . '';
		}
		else
		{
			return 'INSERT INTO ' . get_class( $object ) . ' SET ' . $keys_values . '';
		}
	}
	
	# ------------------------------------------------------------------ #
	public static function words( $string, $words_returned, $dots = true, $strip_tags = true )
	{
		$string = ( $strip_tags ? strip_tags( $string ) : $string );
		$retval = $string;
		$array = explode( " ", $string );
		
		if ( count( $array ) <= $words_returned )
		{
			$retval = $string;
		}
		else
		{
			array_splice( $array, $words_returned );
			$retval = implode( " ", $array ) . ( $dots ? "..." : "" );
		}
		
		return trim( $retval );
	}
	
	# ------------------------------------------------------------------ #
	public static function data2banco( $data )
	{
		#
		# 30/01/2008 => 2008-01-30 (não altera as horas, se informado)
		#
		
		$hora = substr( $data, 10, 9 );
		$data = substr( $data, 0, 10 );
		return ( implode( '-', array_reverse( explode( '/', $data ) ) ) ) . $hora;
	}
	
	# ------------------------------------------------------------------ #
	public static function banco2data( $data, $show_time = false )
	{
		#
		# 2008-01-30 => 30/01/2008 (não altera as horas, se habilitado)
		#
		
		$hora = substr( $data, 10 );
		$data = substr( $data, 0, 10 );
		return( implode( '/', array_reverse( explode( '-', $data ) ) ) ) . ( $show_time ? $hora : '' );
	}
	
	# ------------------------------------------------------------------ #
	public static function valid_email( $email )
	{
		$isValid = true;
		$atIndex = strrpos( $email, '@' );
		
		if ( is_bool( $atIndex ) && ! $atIndex )
		{
			$isValid = false;
		}
		else
		{
			$domain = substr( $email, $atIndex + 1 );
			$local = substr( $email, 0, $atIndex );
			$localLen = strlen( $local );
			$domainLen = strlen( $domain );
		
			if ( $localLen < 1 || $localLen > 64 )
			{
				$isValid = false;
			}
			else if ( $domainLen < 1 || $domainLen > 255 )
			{
				$isValid = false;
			}
			else if ( $local[0] == '.' || $local[$localLen-1] == '.' )
			{
				$isValid = false;
			}
			else if ( preg_match( '/\\.\\./', $local ) )
			{
				$isValid = false;
			}
			else if ( ! preg_match( '/^[A-Za-z0-9\\-\\.]+$/', $domain ) )
			{
				$isValid = false;
			}
			else if ( preg_match( '/\\.\\./', $domain ) )
			{
				$isValid = false;
			}
			else if ( ! preg_match( '/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace( "\\\\", "", $local ) ) )
			{
				if ( ! preg_match( '/^"(\\\\"|[^"])+"$/', str_replace( "\\\\", "", $local ) ) )
				{
					$isValid = false;
				}
			}
			
			if ( $isValid && ! ( checkdnsrr( $domain, "MX" ) || checkdnsrr( $domain, "A" ) ) )
			{
				$isValid = false;
			}
		}
		return $isValid;
	}
	
	# ------------------------------------------------------------------ #
	function date_diff( $startDate, $endDate ) 
	{ 
		$startArry = date_parse( $startDate );
		$endArry = date_parse( $endDate );
		$start_date = gregoriantojd( $startArry["month"], $startArry["day"], $startArry["year"] );
		$end_date = gregoriantojd( $endArry["month"], $endArry["day"], $endArry["year"] );
		return round( ( $end_date - $start_date ), 0 );
	}
	
	# ------------------------------------------------------------------ #
	function date_add( $date, $days )
	{
		$date = explode( '-', $date );
		return date( 'Y-m-d', mktime( 0, 0, 0, $date[1], $date[2] + $days, $date[0] ) );
	}
	
	# ------------------------------------------------------------------ #
	function decode_sum( $elements, $sum )
	{
		#
		# GET MAXIMUM SUM POSSIBLE
		#
		$max = 0;
		$j = 1;
		
		for ( $i = 1; $i < $elements; $i++ )
		{
			$max += $j;
			$j = $j * 2;
		}
		
		$max += $j;
		
		#
		# CHECK VALUES
		#
		$results = array();
		
		for ( $i = $elements; $i > 0; $i-- )
		{
			if ( $j <= $sum )
			{
				$results[$i-1] = true;
				$sum -= $j;
			}
			else
			{
				$results[$i-1] = false;
			}
			
			$j = $j / 2;
		}
		
		return $results;
	}
	
	# ------------------------------------------------------------------ #
	public static function get_long_date( $date )
	{
		$date = strtotime( $date );
		$date = date( 'd', $date ) . ' de ' . util::get_month_name( date( 'm', $date ) ) . ', ' . date( 'Y', $date );
		return $date;
	}
	
	# ------------------------------------------------------------------ #
	public static function get_month_name( $m )
	{
		switch ( $m )
		{
			case 01: return 'janeiro'; break;
			case 02: return 'fevereiro'; break;
			case 03: return 'março'; break;
			case 04: return 'abril'; break;
			case 05: return 'maio'; break;
			case 06: return 'junho'; break;
			case 07: return 'julho'; break;
			case '08': return 'agosto'; break;
			case '09': return 'setembro'; break;
			case 10: return 'outubro'; break;
			case 11: return 'novembro'; break;
			case 12: return 'dezembro'; break;
		}
	}
	
	# ------------------------------------------------------------------ #
	public static function format_birthday( $birthday )
	{
		$birthday = str_replace( '\\', '', $birthday );
		$birthday = explode( '/', $birthday );
		$birthday = sprintf( "%02s", $birthday[2] ) . '-' . sprintf( "%02s", $birthday[0] ) . '-' . sprintf( "%02s", $birthday[1] );
		return $birthday;
	}
	
	# ------------------------------------------------------------------ #
	public static function get_config_value( $code )
	{
		include_once ( $_SERVER['DOCUMENT_ROOT'] . '/models/configs.php' );
		$config = new configs( array( 'code' => $code ) );
		
		if ( isset( $config->id ) )
		{
			return $config->value;
		}
		else
		{
			return false;
		}
	}
	
	//Essa Funçao Limita uma string ate uma quantidade maxima de caracters
	public static function chars_limit( $text = NULL, $limit = NULL)
	{
	    if( strlen($text) <= $limit )
		{ 
		  $new_text = $text;
	   	}
		else
		{ 
			 $last_space = strrpos(substr($text, 0, $limit), " "); // Localiza o útlimo espaço antes de $limite
			 $new_text = trim(substr($text, 0, $last_space))."..."; // Corta o $texto até a posição localizada
	   }
	   return $new_text; 
	}
	
	// Valida tipos de arquivos permitidos
	public static final function file_type ( $file )
	{
		$image_name			= explode ( ".", $file );
		$total_type_files 	= func_num_args () - 1;
		$parameters 		= func_get_args ();
		$is_valid			= false;
		
		for ( $indice = 1; $indice <= $total_type_files; $indice ++ )
		{
			if ( strtoupper( $image_name [1] ) == strtoupper( $parameters [ $indice ] ) )
			{
				return $is_valid = true;
			}
		}
		
		return $is_valid;
	}
	
	// Funcoes para calcular tamanho do disco
	public static function hd_space( $Caminho )
	{
		$UsedSpace = disk_total_space( $Caminho ) - disk_free_space( $Caminho );
		return $UsedSpace;
	}
	
	public static function hd_total( $Caminho )
	{
		$UsedSpace = disk_free_space( $Caminho ) + disk_total_space( $Caminho );
		return $UsedSpace;
	}
	
	public static function _mime_content_type($filename)
	{
		preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);
	
		switch(strtolower($fileSuffix[1]))
		{
			case "js" :
			return "application/x-javascript";
			
			case "json" :
			return "application/json";
			
			case "jpg" :
			case "jpeg" :
			case "jpe" :
			return "image/jpg";
			
			case "png" :
			case "gif" :
			case "bmp" :
			case "tiff" :
			return "image/".strtolower($fileSuffix[1]);
			
			case "css" :
			return "text/css";
			
			case "xml" :
			return "application/xml";
			
			case "doc" :
			case "docx" :
			return "application/msword";
			
			case "xls" :
			case "xlt" :
			case "xlm" :
			case "xld" :
			case "xla" :
			case "xlc" :
			case "xlw" :
			case "xll" :
			return "application/vnd.ms-excel";
			
			case "ppt" :
			case "pps" :
			return "application/vnd.ms-powerpoint";
			
			case "rtf" :
			return "application/rtf";
			
			case "pdf" :
			return "application/pdf";
			
			case "html" :
			case "htm" :
			case "php" :
			return "text/html";
			
			case "txt" :
			return "text/plain";
			
			case "mpeg" :
			case "mpg" :
			case "mpe" :
			return "video/mpeg";
			
			case "mp3" :
			return "audio/mpeg3";
			
			case "wav" :
			return "audio/wav";
			
			case "aiff" :
			case "aif" :
			return "audio/aiff";
			
			case "avi" :
			return "video/msvideo";
			
			case "wmv" :
			return "video/x-ms-wmv";
			
			case "mov" :
			return "video/quicktime";
			
			case "zip" :
			return "application/zip";
			
			case "tar" :
			return "application/x-tar";
			
			case "swf" :
			return "application/x-shockwave-flash";
			
			default :
				if(function_exists("mime_content_type"))
				{
					$fileSuffix = mime_content_type($filename);
				}
	
			//return "unknown/" . trim($fileSuffix[0], ".");
			return "outros";
		}
	}
	
	//Transformma Bytes em MB
	public static function correct_bytes_name( $size )
	{
		$i = 0;
		$iec = array("bytes", "Kb", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
		
		while ( ( $size / 1024 ) > 1 )
		{
			$size = $size / 1024;
			$i++;
		}
		
		return substr( $size,0 ,strpos( $size,'.' ) + 4 ).' '.$iec[$i];
	}
	
	 // Funcao para forcar LOGOFF em um determinado tempo ocioso
	public static function time_out( $tantosMinutos )
	{
		$TempoAtual = time();
	
		$TempoPast	= $_SESSION['tempo'];
		
		// valores para producao em milisegundos
		// $cinco_minutos = 5*60; 
		// $uma_hora = 60*60;
		// $vinte_minutos = 20*60;
		
		$Menos = $TempoAtual - $TempoPast;
		
		if($Menos > $tantosMinutos )
		{
			//header("Location: logout.php?timeout=".md5('1'));
		}
		
		$agora = time();
		
		$_SESSION['tempo'] = $agora;
	}
	
	// Funcoes para gerar senha aleatoria
	public static final function make_passwd( $digitos, $md5 = false )
	{
		srand( time() );
		
		for ( $i = 1; $i <= $digitos; $i++ )
		{
			list( $usec, $sec ) = explode(' ', microtime() );
			$make_seed = ( float ) $sec + (( float ) $usec * 100000);
			
			srand( $make_seed );
			
			$r = rand(1,9);
			
			if ($r < 6)
			{
				list( $usec, $sec ) = explode(' ', microtime() );
				$make_seed = ( float ) $sec + (( float ) $usec * 100000);
				
				srand( $make_seed );
				
				$r = rand(97, 122);
				
				$senha .= chr($r);
			}
			else
			{
				list( $usec, $sec ) = explode(' ', microtime() );
				$make_seed = ( float ) $sec + (( float ) $usec * 100000);
				
				srand( $make_seed );
				
				$r = rand(1,9);
				
				$senha .= $r;
			}
		}
		
		$senha = $senha;
		$senha = ( $md5 ? md5( $senha ) : $senha );
		
		return $senha;
	}
}
?>