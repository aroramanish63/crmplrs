<?php

die;
include('./core/config.php'); //config file stores all configuration

$emailFunc = $commonObj->load_class_object('emailFunctions');

//
//echo $emailFunc->saveMailbeforeSend(3);
echo $emailFunc->sendEmail(array('aroramanish63@gmail.com'), 'for test only', 'Hello Testinmg');
//echo $emailFunc->getMessage();
echo '<pre>';
print_r($emailFunc);
echo '</pre>';
//echo 'Manish:   '.preg_match("/^[A-Z|a-z]{4}[a-zA-Z0-9]{7}$/", 'mani1251245');


