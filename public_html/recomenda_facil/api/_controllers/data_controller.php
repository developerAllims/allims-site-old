<?php
	if ( isset( $_SERVER["HTTP_HOST"] ) )
	{
		switch ( $_SERVER["HTTP_HOST"] )
		{
			/*case "192.168.0.8":
				define ( 'DB_HOST', '179.188.16.157' );
				define ( 'DB_USER', 'recfac' );
				define ( 'DB_PASS', 'r@allFal2209');
				define ( 'DB_DATABASE','recfac');
				define ( 'MEMCACHED', false );
				break;*/
			default:
				define ( 'DB_HOST', '52.166.199.221' );
				define ( 'DB_USER', 'postgres' );
				define ( 'DB_PASS', 'Ya17al70ra20li#ms19');
				define ( 'DB_DATABASE','ALLIMS');
				define ( 'MEMCACHED', false );
				break;
		}
	
		define ( 'HTTP_HOST', $_SERVER["HTTP_HOST"] );
	}

	define ( 'CACHE_HASH', '000000001' );
	define ( 'CACHE', true );
	define ( 'SESSION_ID_HASH', '260ca9dd8a4577fc00b7bd5810298076' );
	define ( 'BETA_TOKEN', '62f0cbf600ee574d20a6c1bfcf083085' );
	define ( 'BETA_PASSWORD', 'xxxxxxxx' );
	define ( 'CHAVE', HTTP_HOST );
?>