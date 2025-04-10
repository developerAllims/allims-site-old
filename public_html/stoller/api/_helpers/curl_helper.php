<?php
class curl
{
	var $callback = false;
	
	# ------------------------------------------------------------------ #
	function set_callback( $func_name )
	{
		$this->callback = $func_name;
	}
	
	# ------------------------------------------------------------------ #
	function do_request( $method, $url, $vars )
	{
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, 1 );
		curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_COOKIEJAR, 'cookie.txt' );
		curl_setopt( $ch, CURLOPT_COOKIEFILE, 'cookie.txt' );
		
		if ( $method == 'POST' )
		{
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $vars );
		}
		
		$data = curl_exec( $ch );
		curl_close( $ch );
		
		if ( $data )
		{
			if ( $this->callback )
			{
					$callback = $this->callback;
					$this->callback = false;
					return call_user_func( $callback, $data );
			}
			else
			{
				return $data;
			}
		}
		else
		{
			return false;
		}
	}
	
	# ------------------------------------------------------------------ #
	function get( $url )
	{
		return $this->do_request( 'GET', $url, 'NULL' );
	}
	
	# ------------------------------------------------------------------ #
	function post( $url, $vars )
	{
		return $this->do_request( 'POST', $url, $vars );
	}
}
?>