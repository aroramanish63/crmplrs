<?php
include('./core/config.php');
if (isset($_SESSION['uid']) && !empty($_SESSION['uid'])) {
    $commonObj->redirectUrl();
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
            $userUpdate = "update tbl_user set login_attempts = '0' where username = '" . $uname . "'";
            $resultSet = mysql_query($userUpdate) or die(mysql_error());
            if ($commonObj->isCallCentreStaff($_SESSION['uid'])) {
                $commonObj->redirectUrl('viewComplaints');
            }
            else {
                $commonObj->redirectUrl();
            }
            exit();
        }
        else {
            $unamemsg = $commonObj->getMessage();
            $loginAttempts = $commonObj->getLoginAttempts($uname);

            if ($loginAttempts['login_attempts'] == '5') {
                $userUpdate = "update tbl_user set status = '0' where username = '" . $uname . "'";
                $resultSet = mysql_query($userUpdate) or die(mysql_error());
                $username = $loginAttempts['username'];
                $email = $loginAttempts['email'];

                sendmailtoadmin($username, $email);
            }
            else {
                $commonObj->updateLoginAttempts($uname);
            }
        }
    }
    else {

        $unamemsg = $commonObj->getMessage();
    }
}

function sendmailtoadmin($username, $email) {

    require 'PHPMailer/class.phpmailer.php';
    $html = '';
    $subject = 'PLRSCRM User Deactivated';

    $sentfrom = 'plrscrm';
    $sentname = 'plrscrm';

    $mail = new PHPMailer();
    $mail->IsSMTP();                           // tell the class to use SMTP
    $mail->SMTPAuth = true;                  // enable SMTP authentication
    $mail->SMTPSecure = 'tls';
    $mail->Port = 25;                    // set the SMTP server port
    $mail->Host = "mail.cloudoye.in";
    $mail->Username = "admin@cloudoye.in";
    $mail->Password = "Sghdwsw$3231";
    // SMTP server password
    $mail->IsHTML(true);
    $mail->SetFrom($sentfrom, $sentname);

    $mail->AddAddress("harpreet.kaur@cyfuture.com");

    $mail->Subject = $subject;
    $mail->SMTPDebug = 2;
    $html = 'User with username : ' . $username . ' and Email : ' . $email . ' has been deactivated due to wrong login attempts!';

    $mail->Body = $html;
    //$mail->WordWrap = 50;

    if ($mail->Send()) {
        //echo '<!-- Mail sent -->';
    }
}
?>
<!doctype html>
<head>
    <!-- General Metas -->
    <meta charset="utf-8" />
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> Force Latest IE rendering engine -->
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