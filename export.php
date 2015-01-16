<?php
include('./core/config.php');//config file stores all configuration

if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

if(!isset($_SESSION['uid']) && empty($_SESSION['uid'])) exit(header ('Location: '.LOGIN_URL));

$commonObj->load_class('complaintFunctions');
$complaintFunc = new complaintFunctions();
if(isset($_REQUEST['complaint']) && !empty($_REQUEST['complaint']) && isset($_REQUEST['complaintType_dist']) && !empty($_REQUEST['complaintType_dist']) && isset($_REQUEST['complaintType_retail']) && !empty($_REQUEST['complaintType_retail']) ){
    $complaint = $_REQUEST['complaint'];
    $complaintType_dist = $_REQUEST['complaintType_dist'];
    $complaintType_retail = $_REQUEST['complaintType_retail']; 
    if($complaint == 'dist'){        
        $fromdate = date('Y-m-d',  strtotime($_REQUEST['fromdate']));
        $todate = date('Y-m-d',  strtotime($_REQUEST['todate']));        
        $complaintFunc->exportDistributorreport($complaintType_dist, $fromdate, $todate);        
    }
    else if($complaint == 'retail'){        
        $fromdate = date('Y-m-d',  strtotime($_REQUEST['fromdate']));
        $todate = date('Y-m-d',  strtotime($_REQUEST['todate']));               
         $complaintFunc->exportRetailreport($complaintType_retail,$fromdate,$todate);       
    }
}