<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$commonObj->load_class('userFunctions');
$userFunc = new userFunctions();
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    if ($userFunc->addUser(true)) {
        $userFunc->redirectUrl('userManagement');
    }
}
$udetail = '';
if (isset($_REQUEST['idu']) && trim($_REQUEST['idu']) != '') {
    $uid = trim($_REQUEST['idu']);
    $udetail = $userFunc->getUserdetail($uid);
}
?>
<script type="text/javascript">
    /**
     * validate form
     */
    function validateuserfrm() {
        var name = document.getElementById('ename');
        var uname = document.getElementById('uname');
        var upassword = document.getElementById('upassword');
        var cpassword = document.getElementById('cpassword');
        var ugroup = document.getElementById('ugroup');
        var email = document.getElementById('email');
        var mobile = document.getElementById('mobile');

        if (name.value == '' || name.value.replace(/\s+$/, '') == '') {
            alert('Please enter name.');
            name.focus();
            return false;
        }
        if (uname.value == '' || uname.value.replace(/\s+$/, '') == '') {
            alert('Please enter username.');
            uname.focus();
            return false;
        }
        if (upassword.value == '' || upassword.value.replace(/\s+$/, '') == '') {
            alert('Please enter password.');
            upassword.focus();
            return false;
        }
        if (cpassword.value == '' || cpassword.value.replace(/\s+$/, '') == '') {
            alert('Please enter confirm password.');
            cpassword.focus();
            return false;
        }
        if (upassword.value.replace(/\s+$/, '') != '' && cpassword.value.replace(/\s+$/, '') != '') {
            if (upassword.value != cpassword.value) {
                alert('Password not match.');
                upassword.focus();
                return false;
            }
        }
        if (ugroup.value == '' || ugroup.value.replace(/\s+$/, '') == '') {
            alert('Please select usergroup.');
            ugroup.focus();
            return false;
        }
        if (email.value == '' || email.value.replace(/\s+$/, '') == '') {
            alert('Please enter email.');
            email.focus();
            return false;
        }
        else {
            if (!checkEmail('email')) {
                alert('Please enter valid email.');
                email.focus();
                return false;
            }
        }
        if (mobile.value == '' || mobile.value.replace(/\s+$/, '') == '') {
            alert('Please enter mobile no.');
            mobile.focus();
            return false;
        }
        else {
            regexp = /^[0-9]+$/;
            if (!mobile.value.match(regexp)) {
                alert('Please enter valid mobile no.');
                return false;
            }
        }
        window.auserfrm.submit();
    }

    function checkEmail(elementid) {
        var email = document.getElementById(elementid);
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(email.value)) {
            return false;
        }
        else {
            return true;
        }
    }
</script>
<div class="container_12">
    <!-- Form elements -->
    <?php
    if ($userFunc->getMessage()) {
        echo $userFunc->getMessage();
    }
    ?>
    <?php
    if (count($userFunc->getErrors()) > 0) {
        echo '<span class="notification n-error">';
        foreach ($userFunc->getErrors() as $val) {
            echo $val;
            echo '<br/>';
        }
        echo '</span>';
    }
    ?>
    <div class="module">
        <h2><span>Edit User Form</span></h2>
        <div class="module-body">
            <form action="" method="post" name="auserfrm" id="auserfrm" onsubmit="return validateuserfrm();">
                <?php
                if (is_array($udetail) && $udetail != '') {
                    foreach ($udetail as $detail) {
                        ?>
                        <p>
                            <label>Name <span class="red">*</span></label>
                            <input type="text" name="ename" id="ename" class="input-short" value="<?php echo $detail['name']; ?>" />
                        </p>
                        <p>
                            <label>Username <span class="red">*</span></label>
                            <input type="text" name="uname" id="uname" class="input-short" value="<?php echo $detail['username']; ?>" />
                        </p>
                        <p>
                            <label>Select Usergroup <span class="red">*</span></label>
                            <select class="input-short" name="ugroup" id="ugroup">
                                <?php
                                $usergrp = $userFunc->getUserGroup();
                                if (is_array($usergrp) && count($usergrp) > 0) {
                                    echo '<option value=" ">Select Usergroup</option>';
                                    echo $userFunc->createSelectOption($usergrp, 'id', 'group_name', 1, $detail['user_group']);
                                }
                                else {
                                    echo '<option value=" ">Select Usergroup</option>';
                                }
                                ?>
                            </select>
                        </p>
                        <p>
                            <label>Email <span class="red">*</span></label>
                            <input type="text" name="email" id="email" class="input-short" value="<?php echo $detail['email']; ?>"/>
                        </p>
                        <p>
                            <label>Mobile <span class="red">*</span></label>
                            <input type="text" name="mobile" id="mobile" class="input-short" value="<?php echo $detail['mobile_no']; ?>"/>
                        </p>
                        <p>
                            <label>Address </label>
                            <textarea name="address" id="address" rows="7" cols="90" class="input-short"><?php echo $detail['address']; ?></textarea>
                        </p>
                        <fieldset>
                            <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $detail['id'] ?>" />
                            <input class="submit-gray" type="reset" value="Cancel" />
                        </fieldset>
                    <?php
                    }
                }
                ?>
            </form>
        </div> <!-- End .module-body -->
    </div>  <!-- End .module -->
</div>