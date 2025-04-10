<?php
	ini_set ( 'display_errors', 1 );
	//error_reporting ( E_ALL ~E_NOTICE );
	//error_reporting ( 0 );
	// Inicia sessões
	session_start();
	
	// URL
	define ("url", $_SERVER ['HTTP_HOST']);
	define ("path", $_SERVER ['DOCUMENT_ROOT'] . '/api');
	define ("path_ipocket", path.'/ipocket');
	
	include ( path . '/_controllers/data_controller.php' );
	include ( path . '/_helpers/dao_helper.php' );
	include ( path . '/_helpers/db_helper.php' );
	include ( path . '/_helpers/util_helper.php' );
	
	$counter_new = 0;
	$counter_cached = 0;

	#
	# PREVENT SQL INJECTION BY PRE-VERIFYING AND SANITIZING ALL PARAMS RECEIVED BY THE PAGE
	#
	foreach ( $_POST as $key => $value )
	{
		if ( is_array( $_POST["$key"] ) )
		{
			foreach( $_POST["$key"] as $internal_key => $internal_value )
			{
				if( is_array( $_POST["$key"]["$internal_key"] ) )
				{
					foreach( $_POST["$key"]["$internal_key"] as $sub_internal_key => $sub_internal_value )
					{
						$_POST["$key"]["$internal_key"]["$sub_internal_key"] = util::clear_string( $sub_internal_value );
					}
				}else
				{
					$_POST["$key"]["$internal_key"] = util::clear_string( $internal_value );
				}
			}
		}
		else
		{
			$_POST["$key"] = util::clear_string( $value );
		}
	}

	foreach ( $_GET as $key => $value )
	{
		if ( is_array( $_GET["$key"] ) )
		{
			foreach( $_GET["$key"] as $internal_key => $internal_value )
			{
				if( is_array( $_GET["$key"]["$internal_key"] ) )
				{
					foreach( $_GET["$key"]["$internal_key"] as $sub_internal_key => $sub_internal_value )
					{
						$_GET["$key"]["$internal_key"]["$sub_internal_key"] = util::clear_string( $sub_internal_value );
					}
				}else
				{
					 $_GET["$key"]["$internal_key"] = util::clear_string( $internal_value );
				}
			}
		}
		else
		{
			$_GET["$key"] = util::clear_string( $value );
		}
	}

	foreach ( $_REQUEST as $key => $value )
	{
		if ( is_array( $_REQUEST["$key"] ) )
		{
			foreach( $_REQUEST["$key"] as $internal_key => $internal_value )
			{
				if( is_array( $_REQUEST["$key"]["$internal_key"] ) )
				{			
					foreach( $_REQUEST["$key"]["$internal_key"] as $sub_internal_key => $sub_internal_value )
					{
						$_REQUEST["$key"]["$internal_key"]["$sub_internal_key"] = util::clear_string( $sub_internal_value );
					}
				}else
				{
					$_REQUEST["$key"]["$internal_key"] = util::clear_string( $internal_value );
				}
			}
		}
		else
		{
			$_REQUEST["$key"] = util::clear_string( $value );
		}
	}

?>