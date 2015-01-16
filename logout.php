<?php
include('./core/config.php');
if(isset($_SESSION['uid']) && ($_SESSION['uid'])){
    $sessionarr = $_SESSION;
    $commonObj->logout($sessionarr);
    header('Location:'.LOGIN_URL);
    exit();
}
else{
    header('Location:'.SITE_URL);
    exit();
}