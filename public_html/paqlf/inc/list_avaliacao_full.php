<?php 
    date_default_timezone_set('America/Sao_Paulo');
    require_once ('../modal/functions.php');
    require_once ('../modal/conex_bd.php');
    $conexao = conexao();
    $pk_person = $_GET['samp'];
    $date_year = ( $_GET['ano'] != '' ? $_GET['ano'] : (date('Y')-1) );
    
    $fk_pa_det_res_groups = ($_GET['groups'] ? $_GET['groups'] : 1);

    $where = ( 'ep_program_year.number_year = '. $date_year.'');

    //$order = ( $_GET['order'] != '' ? $_GET['order'] . ',' : '');


    $query = "SELECT
                 ep_people_program_year.pk_people_program_year
                ,ep_people_program_year.total_annual
                ,ep_people_program_year.full_repeat 
                ,ep_people_program_year.considerate 
                ,ep_people_program_year.inaccuracy  
                ,ep_people_program_year.haziness    
                ,ep_people_program_year.ie          
                ,ep_people_program_year.final_group 
		        ,ep_people_program_year.derating_reason
                ,ep_program_year.number_year
            FROM
                ep_people_program_year
                INNER JOIN ep_program_year ON ( ep_program_year.pk_program_year = ep_people_program_year.fk_program_year )
                INNER JOIN ep_people ON ( ep_people.pk_person = ep_people_program_year.fk_person  )
            WHERE
                ep_program_year.number_year = {$date_year}
                AND need_calcule = false
                AND fk_pa_det_res_groups = {$fk_pa_det_res_groups}
                AND ep_program_year.is_visible = true
            ORDER BY  ep_people_program_year.ie DESC";

    $result = pg_query($conexao, $query);
    $int = 0;

        
        while ( $array = @pg_fetch_array($result) ) 
        {
            $int++;
            print '<tr '.( $int%2 == 1 ? 'class="cinza_claro"' : '') .'>';
                print '<td align="center">' . $array['number_year'] . '</td>';
                print '<td align="right">' . $array['total_annual'] . '</td>';
                print '<td align="right">' . $array['full_repeat'] . '</td>';
                print '<td align="right">' . $array['considerate'] . '</td>';
                print '<td align="right">' . number_format($array['inaccuracy'],2, ',', '') . '</td>';
                print '<td align="right">' . number_format($array['haziness'],2, ',', '') . '</td>';
                print '<td align="right">' . number_format($array['ie'],2, ',', '') . '</td>';
                print '<td align="center">' . (trim($array['final_group']) == '-' ? '<span title="'.$array['derating_reason'].'">*</span>' : $array['final_group'] ) . '</td>';
            print '</tr>';
        }
?>
    <input type="hidden" class="hidden_year" value="<?php print $_GET['ano']; ?>">
    <input type="hidden" class="hidden_groups" value="<?php print $fk_pa_det_res_groups; ?>">
    <input type="hidden" class="hidden_person" value="<?php print $pk_person; ?>">

