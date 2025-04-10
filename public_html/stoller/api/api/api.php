<?php

    require('../_helpers/functions.php');

//    print "\n";
//    print_r( $_SERVER['REQUEST_METHOD'] );
//    print "\n\n";
//    print_r( $_POST );
//    print "\n\n";

    $method = $_SERVER['REQUEST_METHOD'];
    //header('Content-Type: application/json');
    //header('Content-type:application/json;charset=utf-8');

    switch ($method) {
        case 'PUT':
            //print 'put';
            parse_str(file_get_contents("php://input"),$post_vars);
            //print_r($post_vars);
            $users = new functions();
            $return = $users::confirmData($post_vars["labId"], $post_vars["labUser"], $post_vars["labPass"],  "192.168.0.8", "Chrome", "Windows", $post_vars["jsonString"]);
            print $return;
            break;
        case 'POST':
            //print 'post';
            //print_r($_POST);

            header('Content-type:application/json;charset=utf-8');

            $users = new functions();

            switch( trim(strtolower($_GET['api_function'])) ) 
            {
                case 'sf_storage_data_insert':
                    $return = $users::sf_storage_data_insert($_POST["json_string"]);
                    print $return;
                    break;

               /* case 'getsamplesnotdownloadedjson':
                    $return = $users::getSamplesNotDownloadedJSON( $_POST["labId"], $_POST["labUser"], $_POST["labPass"],  "192.168.0.8", $_POST["qntLimit"] );
                    print $return;
                    break;

                case 'getsamplespredictionsjson':
                    $return = $users::getSamplesPredictionsJSON($_POST["labId"], $_POST["labUser"], $_POST["labPass"],  "192.168.0.8", $_POST['markAsDownloaded'],  $_POST["jsonString"]);
                    print $return;
                    break;

                case 'setsamplesdownloaded':
                    $return = $users::setSamplesDownloaded($_POST["labId"], $_POST["labUser"], $_POST["labPass"],  "192.168.0.8", $_POST["jsonString"]);
                    print $return;
                    break;*/
                
                default:
                    //print $_GET['api_function'].'00';
                    print "{\"submit_error\" : {\"sucess\" : false, \"message\" : \"Função não encontrada. " . $_GET['api_function'] . " \", \"errorcode\" : \"-9998\"}}"; 

                    break;
            }

            break;


            /*header('Content-type:application/json;charset=utf-8');

            $users = new functions();
            $return = $users::confirmData($_POST["labId"], $_POST["labUser"], $_POST["labPass"],  "192.168.0.8", "Chrome", "Windows", $_POST["jsonString"]);
	    print $return;*/
            break;

        case 'GET':

            header('Content-type:application/json;charset=utf-8');
            //print 'get';
           // print_r($_GET);


            $users = new functions();

            switch( trim(strtolower($_GET['api_function'])) ) 
            {
                case 'sf_storage_data':
                    $return = $users::sf_storage_data($_GET["json_string"]);
                    print $return;
                    break;

                /*case 'getsamplesnotdownloadedjson':
                    $return = $users::getSamplesNotDownloadedJSON( $_GET["labId"], $_GET["labUser"], $_GET["labPass"],  "192.168.0.8", $_GET["qntLimit"] );
                    print $return;
                    break;

                case 'getsamplespredictionsjson':
                    $return = $users::getSamplesPredictionsJSON($_GET["labId"], $_GET["labUser"], $_GET["labPass"],  "192.168.0.8", $_GET['markAsDownloaded'],  $_GET["jsonString"]);
                    print $return;
                    break;

                case 'setsamplesdownloaded':
                    $return = $users::setSamplesDownloaded($_GET["labId"], $_GET["labUser"], $_GET["labPass"],  "192.168.0.8", $_GET["jsonString"]);
                    print $return;
                    break;*/
                
                default:
                    
                    break;
            }

            break;
            
        default:
            //print 'default';
            switch( trim(strtolower($_REQUEST['api_function'])) ) 
            {
                case 'sf_storage_data':
                    $return = $users::sf_storage_data($_REQUEST["json_string"]);
                    print $return;
                    break;

                /*case 'getsamplesnotdownloadedjson':
                    $return = $users::getSamplesNotDownloadedJSON( $_GET["labId"], $_GET["labUser"], $_GET["labPass"],  "192.168.0.8", $_GET["qntLimit"] );
                    print $return;
                    break;

                case 'getsamplespredictionsjson':
                    $return = $users::getSamplesPredictionsJSON($_GET["labId"], $_GET["labUser"], $_GET["labPass"],  "192.168.0.8", $_GET['markAsDownloaded'],  $_GET["jsonString"]);
                    print $return;
                    break;

                case 'setsamplesdownloaded':
                    $return = $users::setSamplesDownloaded($_GET["labId"], $_GET["labUser"], $_GET["labPass"],  "192.168.0.8", $_GET["jsonString"]);
                    print $return;
                    break;*/
                
                default:
                    
                    break;
            }


        break;
}
?>