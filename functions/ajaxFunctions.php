<?php
if ( ! defined('BASE_PATH')) exit('No direct script access allowed');
// For Ajax Requests
if($_SERVER['REQUEST_METHOD'] == 'POST'){    
    if(isset($_POST['ajx']) && ($_POST['ajx'] == 'Yes') && isset($_POST['func_name']) && !empty($_POST['func_name']) && isset($_POST['class']) && !empty($_POST['class'])){
        $class = $_POST['class'];
            $commonObj->load_class($class);  
            if(class_exists($class)){                
                $obj = new $class();                                    
                $func_name = $_POST['func_name']; 
                if(method_exists($obj, $func_name)){
                    switch($func_name){                        
                        case "statusActiveInactive": 
                            echo ($obj->$func_name(trim($_POST['id']))) ? json_encode($obj->getStatus(trim($_POST['id']))) : $obj->getMessage();
                                break;
                    }
                }
                else
                    echo "Class: $class method $func_name not exists.";
            }
            else {
                echo 'class not exists.';
            }
    }
    else
        echo 'Proper Values not Sent.';
}


