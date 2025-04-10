<?php
class dao
{
	# ------------------------------------------------------------------ #
	public static function duplicate( $obj )
	{
		$new_object = clone $obj;
		$new_object->id = null;
		return $new_object;
	}
	
	# ------------------------------------------------------------------ #
	public static function decrement( &$obj, $field, $how_much = 1 )
	{
		$result = db::query( 'UPDATE ' . get_class( $obj ) . ' SET `' . $field . '` = ( `' . $field . '` - ' . $how_much . ' ) WHERE id = ' . $obj->id . ' LIMIT 1' );
		
		if ( $result )
		{
			$obj->$field -= $how_much;
			return true;
		}
		else
		{
			return false;
		}
	}
	
	# ------------------------------------------------------------------ #
	public static function delete( &$obj, $where )
	{
		$result = db::query( 'DELETE FROM ' . get_class( $obj ) . ' ' . $where . ' LIMIT 1' );
		return ( $result ? true : false );
	}
	
	# ------------------------------------------------------------------ #
	public static function find( $class_name, $conditions = null, $order = null, $limit = NULL, $just_count = false, $debug_mode = false )
	{
		if ( ! empty( $conditions ) )
		{
			foreach ( $conditions as $key => $value )
			{
				if ( substr( $value, 0, 1 ) == '=' )
				{
					$conditions["$key"] = '`' . $key . '` = \'' . substr( $value, 1 ) . '\'';
				}
				elseif ( substr( $value, 0, 1 ) == '~' )
				{
					$conditions["$key"] = '`' . $key . '` LIKE \'%' . str_replace( ' ', '%', substr( $value, 1 ) ) . '%\'';
				}
				elseif ( substr( $value, 0, 2 ) == 'B~' )
				{
					$conditions["$key"] = '`' . $key . '` LIKE BINARY \'' . substr( $value, 2 ) . '\'';
				}
				elseif ( substr( $value, 0, 2 ) == '<>' )
				{
					$conditions["$key"] = '`' . $key . '` <> \'' . substr( $value, 2 ) . '\'';
				}
				elseif ( substr( $value, 0, 2 ) == '!=' )
				{
					$conditions["$key"] = '`' . $key . '` != \'' . substr( $value, 2 ) . '\'';
				}
				elseif ( substr( $value, 0, 2 ) == '>=' )
				{
					$conditions["$key"] = '`' . $key . '` >= \'' . substr( $value, 2 ) . '\'';
				}
				elseif ( substr( $value, 0, 2 ) == '<=' )
				{
					$conditions["$key"] = '`' . $key . '` <= \'' . substr( $value, 2 ) . '\'';
				}
				elseif ( substr( $value, 0, 2 ) == '>>' )
				{
					$conditions["$key"] = '`' . $key . '` > \'' . substr( $value, 2 ) . '\'';
				}
				elseif ( substr( $value, 0, 2 ) == '<<' )
				{
					$conditions["$key"] = '`' . $key . '` < \'' . substr( $value, 2 ) . '\'';
				}
				elseif ( substr( $value, 0, 2 ) == 'IN' )
				{
					$conditions["$key"] = '`' . $key . '` IN (' . substr( $value, 2 ) . ')';
				}
				elseif ( substr( $value, 0, 2 ) == 'IS' )
				{
					$conditions["$key"] = '`' . $key . '` IS ' . substr( $value, 2 ) . '';
				}
				else
				{
					$conditions["$key"] = '`' . $key . '` = \'' . $value . '\'';
				}
			}
		}
		if( $limit )
		{
			$limit = $limit[0].', '.$limit[1];
		}
		if ( $just_count )
		{
			$sql = 'SELECT COUNT( * ) AS q FROM `' . $class_name . '` ' . ( $conditions ? ' WHERE ' . implode( ' AND ', $conditions ) : '' ) . ( $order ? ' ORDER BY ' . $order . ' ' : '' ) . ( $limit ? ' LIMIT ' . $limit . ' ' : '' );
			
			if ( $debug_mode )
			{
				return $sql;
			}
			
			$results = db::query( $sql );
			
			if ( ! empty( $results ) )
			{
				$row = $results[0];
				return $row->q;
			}
			else
			{
				return '?';
			}
		}
		else
		{
			$out = array();
			$sql = 'SELECT * FROM `' . $class_name . '` ' . ( $conditions ? ' WHERE ' . implode( ' AND ', $conditions ) : '' ) . ( $order ? ' ORDER BY ' . $order . ' ' : '' ) . ( $limit ? ' LIMIT ' . $limit . ' ' : '' );
			//print $sql.'<br />';
			if ( $debug_mode )
			{
				return $sql;
			}
			
			$results = db::query( $sql );
			
			if ( ! empty( $results ) )
			{
				//print '<pre>';
				//print_r( $results );
				//print '</pre>';
				
				foreach ( $results as $row )
				{
					//print $key;
					
					$out[] = new $class_name( $row->id );
				}
			}
			
			return $out;
		}
	}
	
	# ------------------------------------------------------------------ #
	public static function find_by_sql( $sql )
	{
		//print $sql.'<br />';
		return db::query( $sql );
	}
	
	# ------------------------------------------------------------------ #
	public static function increment( &$obj, $field, $how_much = 1 )
	{
		$result = db::query( 'UPDATE ' . get_class( $obj ) . ' SET `' . $field . '` = ( `' . $field . '` + ' . $how_much . ' ) WHERE id = ' . $obj->id . ' LIMIT 1' );
		
		if ( $result )
		{
			$obj->$field += $how_much;
			return true;
		}
		else
		{
			return false;
		}
	}
	
	# ------------------------------------------------------------------ #
	public static function obj2post( &$obj )
	{
		foreach ( get_class_vars( get_class( $obj ) ) as $key => $value )
		{
			$_POST["$key"] = $obj->$key;
		}
	}
	
	# ------------------------------------------------------------------ #
	public static function post2obj( &$obj )
	{
		foreach ( get_class_vars( get_class( $obj ) ) as $key => $value )
		{
			if ( @$_POST["$key"] !== NULL && @$_POST["$key"] != 'id' && @$_POST["$key"] != 'password' )
			{
				$obj->$key = $_POST["$key"];
			}
		}
	}
	
	# ------------------------------------------------------------------ #
	public static function save( &$obj, $force_insert = false )
	{
		$sql = util::get_save_sql( $obj, $force_insert );
		
		//print $sql;
		
		if ( db::query( $sql ) )
		{
			$obj->id = ( isset( $obj->id ) ? $obj->id : db::insert_id() );
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>