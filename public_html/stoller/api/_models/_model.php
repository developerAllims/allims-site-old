<?php
class model
{
	# ------------------------------------------------------------------ #
	public function __construct( $id = null )
	{	
		if ( $id )
		{
			if ( is_array( $id ) )
			{
				$where = '';
				
				foreach ( $id as $key => $value )
				{
					$where .= ' AND `' . $key . '` = \'' . $value . '\' ';
				}
				
				$sql = 'SELECT * FROM ' . get_class( $this ) . ' WHERE id <> 0 ' . $where . '';
			}
			else
			{
				$sql = 'SELECT * FROM ' . get_class( $this ) . ' WHERE id = ' . $id . '';
			}
			
			$row = db::query( $sql );
			
			if ( ! empty( $row ) )
			{
				$row = $row[0];
				
				foreach ( get_class_vars( get_class( $this ) ) as $key => $value )
				{
					$this->$key = $row->$key;
				}
			}
		}
	}
	
	# ------------------------------------------------------------------ #
	public final function __set( $key, $value )
	{
		$this->$key = $value;
	}
		
	# ------------------------------------------------------------------ #
	public function __unset( $key )
	{
        unset( $this->$key );
    }
} 
?>