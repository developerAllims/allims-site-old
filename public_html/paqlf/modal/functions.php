<?php 

//Limpando variavel
function cleanString($text) {
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ' // Double quote
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}

// Passando data do banco "AAAA-MM-DD" para "DD/MM/AAAA" //
function mostraData ($data) {
    if ($data!='') {
       return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4));
    }
    else { return ''; }
}

function replace( $search, $replace, $object )
{
    return str_replace( $search, $replace, $object);
}


function fc_test_query( $conexao, $query)
{
    if(!pg_send_query($conexao, $query))
    die("ERRO Send_query");

    if(!($result = pg_get_result($conexao)))
    die("ERRO get_result");

    if(function_exists("pg_result_error_field"))
    {
        $fieldcode = array("PGSQL_DIAG_SEVERITY",        "PGSQL_DIAG_SQLSTATE");
        foreach($fieldcode as $fcode)
        {
            if( pg_result_error_field($result, constant($fcode)) )
            {
                $error_code .= ' ' . pg_result_error_field($result, constant($fcode));      
            }
        }
        pg_free_result($result);
    }

    return $error_code;
}
?>