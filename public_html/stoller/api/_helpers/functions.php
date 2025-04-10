<?php
include('../_controllers/config_controller.php');

class functions{

    public static function sf_storage_data_insert( $insert_json )
    {
        //print "SELECT * FROM sf_storage_data_insert('".$insert_json."')";
        
        $results = db::query("SELECT * FROM sf_storage_data_insert('". pg_escape_string($insert_json)."')");

        $return = $results[0]->{"sf_storage_data_insert"};

        /*$result = [];

        foreach( $results as $key=>$value )
        {
            $result = $value;
        }*/

        return $return;
    }

    /*
    public static function submitSampleSpectraJSON( $lab_number, $lab_user, $lab_pass,  $ip_access, $browser_access, $so_access, $insert_json)
    {
        $validate_login_user = functions::sp_api_validate_login_user( $lab_number, $lab_user, $lab_pass,  $ip_access, $browser_access, $so_access);

        if($validate_login_user->{"r_login_error"} == 0){
        
            //print "SELECT * FROM sp_api_submitSampleSpectroJSON(".$validate_login_user->{"r_pk_partner"}.", ".$validate_login_user->{"r_pk_user"}.", '".$lab_pass."', '".$ip_access."', '".$insert_json."')";
            $result = db::query("SELECT * FROM sp_api_submitSampleSpectroJSON(".$validate_login_user->{"r_pk_partner"}.", ".$validate_login_user->{"r_pk_user"}.", '".$lab_pass."', '".$ip_access."', '".$insert_json."')");
        
            $return = $result[0]->{"sp_api_submitsamplespectrojson"};
        }else{
            $jsonReturn = "{\"submit_error\" : {\"sucess\" : \"".$validate_login_user->{"r_login_ok"}."\", \"message\" : \"".$validate_login_user->{"r_login_message"}."\", \"errorcode\" : \"".$validate_login_user->{"r_login_error"}."\"}}";
            $return = $jsonReturn;
        }

        return $return;
    }


    public static function getSamplesNotDownloadedJSON( $lab_number, $lab_user, $lab_pass,  $ip_access, $qnt_limit)
    {
        $validate_login_user = functions::sp_api_validate_login_user( $lab_number, $lab_user, $lab_pass,  $ip_access, '', '');

        if($validate_login_user->{"r_login_error"} == 0){
        
            $result = db::query("SELECT * FROM sp_api_getSamplesNotDownloaded(".$validate_login_user->{"r_pk_partner"}.", ".$validate_login_user->{"r_pk_user"}.", '".$lab_pass."', '".$ip_access."', ".$qnt_limit.")");
            
            //print_r($return);

            $return = $result[0]->{"sp_api_getsamplesnotdownloaded"};
        }else{
            $jsonReturn = "{\"submit_error\" : {\"sucess\" : \"".$validate_login_user->{"r_login_ok"}."\", \"message\" : \"".$validate_login_user->{"r_login_message"}."\", \"errorcode\" : \"".$validate_login_user->{"r_login_error"}."\"}}";
            $return = $jsonReturn;
        }

        print($return);
    }


    public static function getSamplesPredictionsJSON( $lab_number, $lab_user, $lab_pass,  $ip_access, $browser_access, $mark_downloaded, $json_samples_id)
    {
        $validate_login_user = functions::sp_api_validate_login_user( $lab_number, $lab_user, $lab_pass,  $ip_access, $browser_access, '');

        if($validate_login_user->{"r_login_error"} == 0){
        
            $result = db::query("SELECT * FROM sp_api_getSamplesPredictionsJson(".$validate_login_user->{"r_pk_partner"}.", ".$validate_login_user->{"r_pk_user"}.", '".$lab_pass."', '".$ip_access."', ".$mark_downloaded.", '".$json_samples_id."')");
        
            $return = $result[0]->{"sp_api_getsamplespredictionsjson"};
        }else{
            $jsonReturn = "{\"submit_error\" : {\"sucess\" : \"".$validate_login_user->{"r_login_ok"}."\", \"message\" : \"".$validate_login_user->{"r_login_message"}."\", \"errorcode\" : \"".$validate_login_user->{"r_login_error"}."\"}}";
            $return = $jsonReturn;
        }

        print($return);
    }

    public static function setSamplesDownloaded( $lab_number, $lab_user, $lab_pass,  $ip_access, $insert_json)
    {
        $validate_login_user = functions::sp_api_validate_login_user( $lab_number, $lab_user, $lab_pass,  $ip_access, '', '');

        if($validate_login_user->{"r_login_error"} == 0){
            
            $result = db::query("SELECT * FROM sp_api_setSamplesDownloaded(".$validate_login_user->{"r_pk_partner"}.", ".$validate_login_user->{"r_pk_user"}.", '".$lab_pass."', '".$ip_access."', '".$insert_json."')");
        
            $return = $result[0]->{"sp_api_setsamplesdownloaded"};
        }else{
            $jsonReturn = "{\"submit_error\" : {\"sucess\" : \"".$validate_login_user->{"r_login_ok"}."\", \"message\" : \"".$validate_login_user->{"r_login_message"}."\", \"errorcode\" : \"".$validate_login_user->{"r_login_error"}."\"}}";
            $return = $jsonReturn;
        }

        print($return);
    }*/
}
?>
