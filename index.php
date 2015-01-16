<?php
include('./core/config.php');//config file stores all configuration
ob_start();
if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

if(!isset($_SESSION['uid']) && empty($_SESSION['uid'])) exit(header ('Location: '.LOGIN_URL));

$pagename = 'home.php';
if (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) {
    $pagename = $_REQUEST['page'] . '.php';
}
if (!isset($_REQUEST['ajx']) && file_exists(MODULES_PATH . $pagename)) {
    include_once(INCLUDE_URL . "header.php");
    include_once MODULES_PATH . $pagename;
    include_once(INCLUDE_URL . "footer.php");
} 
elseif (isset($_REQUEST['ajx']) && file_exists(FUNCTIONS_URL.$pagename)) {
    include_once FUNCTIONS_URL.$pagename;
}
else{
    include_once(INCLUDE_URL."error.php");
}
?>

