<?php
include('./core/config.php');
if (isset($_SESSION['uid']) && !empty($_SESSION['uid'])) {
    header('Location:' . SITE_URL);
    exit();
}

if ((isset($_REQUEST['txtusername']) && !empty($_REQUEST['txtusername'])) && (isset($_REQUEST['txtpassword']) && !empty($_REQUEST['txtpassword']))) {
    $uname = $_REQUEST['txtusername'];
    $pass = md5($_REQUEST['txtpassword']);
    if ($commonObj->userNameExist($uname)) {
        $loginarr = $commonObj->checkLogin($uname, $pass);
        if (is_array($loginarr)) {
            $_SESSION['uid'] = $loginarr['id'];
            $_SESSION['username'] = $loginarr['username'];
            $_SESSION['user_group'] = $loginarr['user_group'];
            $_SESSION['name'] = $loginarr['name'];
            $_SESSION['useremail'] = $loginarr['email'];
            $_SESSION['status'] = $loginarr['status'];

            if ($_SESSION['user_group'] != '') {
                $usergroupid = $_SESSION['user_group'];
                $roles_ids = '';
                $groupsid = $commonObj->select('tbl_usergroup', array('role_id', 'transferred_to'), array('id' => $usergroupid));
                if (is_array($groupsid) && count($groupsid) > 0) {
                    foreach ($groupsid as $group) {
                        $roles_ids = $group['role_id'];
                        $transferred_to = $group['transferred_to'];
                    }
                    $_SESSION['roles_id'] = $roles_ids;
                    $_SESSION['transferred_to'] = $transferred_to;
//                        $_SESSION['user_level'] = $level;
                    if (isset($_SESSION['roles_id']) && !empty($_SESSION['roles_id'])) {
                        $rolesArr = array();
                        $rolesArr = explode(',', $_SESSION['roles_id']);
                        $_SESSION['role'] = array();
                        $userRoles = $commonObj->selectWhereIn('tbl_userrole', array('page_name'), array('id' => $_SESSION['roles_id'], 'status' => '1'));
                        if (is_array($userRoles) && count($userRoles) > 0) {
                            foreach ($userRoles as $roles) {
                                $_SESSION['role'][$roles['page_name']] = TRUE;
                            }
                        }
                    }
                }
            }

            header('Location:' . SITE_URL);
            exit();
        }
        else {
            $unamemsg = $commonObj->getMessage();
        }
    }
    else {
        $unamemsg = $commonObj->getMessage();
    }
}
?>
<!doctype html>
<head>
    <!-- General Metas -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!-- Force Latest IE rendering engine -->
    <title>Login<?php echo defined('CRM_TITLE') ? ' - ' . CRM_TITLE : ''; ?></title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>login.css">

</head>
<body>

    <?php if (isset($unamemsg) && !empty($unamemsg)) { ?>
        <div class="notice">
            <p class="warn"><?php echo $unamemsg; ?></p>
        </div>
        <?php
        unset($unamemsg);
    }
    ?>

    <!-- Primary Page Layout -->
    <div class="container">
    <div style="height:150px;"></div>
    <div class="plrslogo" style="text-align:center;"> <img src="images/logo-plrs.png" alt="" /> </div>
        <div class="form-bg" style="margin-top:0px !important;">
            <form name="loginForm" id="loginForm" action="" method="post">
                <h2>Login</h2>
                <p><input type="text" name="txtusername" placeholder="Username"></p>
                <p><input type="password" name="txtpassword" placeholder="Password"></p>
                <button type="submit"></button>
            </form>
        </div>

         <!--<p class="forgot">Forgot your password? <a href="">Click here to reset it.</a></p>-->

    </div><!-- container -->

    <!-- End Document -->
</body>
</html>