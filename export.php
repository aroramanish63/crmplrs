<?php

include('./core/config.php'); //config file stores all configuration

if (!defined('BASE_PATH'))
    exit('No direct script access allowed');

if (!isset($_SESSION['uid']) && empty($_SESSION['uid']))
    exit(header('Location: ' . LOGIN_URL));

$commonObj->load_class('complaintFunctions');
$complaintFunc = new complaintFunctions();

if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['export']) && ($_POST['export'] == 'Yes')) {
    $_POST['btnsearch'] = 1;
    $listingarr = $complaintFunc->getPLRSComplaintbyCriteria();
}
else
    $listingarr = $complaintFunc->getPLRSComplaint();

$complaintFunc->exportReport($listingarr);


