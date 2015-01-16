<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
define('SITE_URL', 'http://localhost/plrscrm/');
define('BASE_PATH', 'C:/xampp/htdocs/plrscrm/');
define('CRM_TITLE', 'Helpline for Punjab Land & Property Services');
define('CSS_URL', SITE_URL . 'css/');
define('IMAGE_URL', SITE_URL . 'images/');
define('JS_URL', SITE_URL . 'js/');
define('PAGES_URL', SITE_URL . 'modules/?');
define('CORE_FOLDER_URL', BASE_PATH . 'core/');
define('INCLUDE_URL', BASE_PATH . 'includes/');
define('FUNCTIONS_URL', BASE_PATH . 'functions/');
define('CLASSES_URL', BASE_PATH . 'classes/');
define('MODULES_PATH', BASE_PATH . 'modules/');
define('LOGIN_URL', SITE_URL . 'login.php');
define('HEADER', INCLUDE_URL . 'header.php');
define('FOOTER', INCLUDE_URL . 'footer.php');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'plrscrm');

define('PHOTO_UPLOAD_DIRECTORY', 'uploads/docs/');
require (FUNCTIONS_URL . 'commonFxn.php');
$commonObj = new commonFxn();
?>