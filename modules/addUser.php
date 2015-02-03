<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$commonObj->load_class('userFunctions');
$userFunc = new userFunctions();
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    if ($userFunc->addUser()) {
        $userFunc->redirectUrl('userManagement');
    }
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
	
    /**
     * function for go to back page
     */
    function back() {
        window.location = 'http://49.50.76.128/plrscrm/?page=userManagement';
    }


</script>

<style type="text/css">

    .leftsection{
        width: 40%;
        float: left;

    }
    .leftsection .input-short, .rightsection .input-short { width: 70% !important; }
    .rightsection{
        width: 40%;
        float: right;

    }

</style>

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
        <h2><span>Add User Form</span></h2>

        <div class="module-body">
         <form action="" method="post" name="auserfrm" id="auserfrm" onsubmit="return validateuserfrm();">
         		<fieldset>
      				<div class="mainsection">
                  <div class="leftsection">
                	 <p>
                    <label>Name <span class="red">*</span></label>
                    <input type="text" name="ename" id="ename" class="input-short" value="<?php echo (isset($_REQUEST['ename'])) ? $_REQUEST['ename'] : ''; ?>" />
                    </p>
                    <p>
                        <label>Username <span class="red">*</span></label>
                        <input type="text" name="uname" id="uname" class="input-short" value="<?php echo (isset($_REQUEST['uname'])) ? $_REQUEST['uname'] : ''; ?>" />
                    </p>
                    <p>
                        <label>Password <span class="red">*</span></label>
                        <input type="password" name="upassword" id="upassword" class="input-short" />
                    </p>
                    <p>
                        <label>Confirm Password <span class="red">*</span></label>
                        <input type="password" name="cpassword" id="cpassword" class="input-short" />
                    </p>
                    <p>
                        <label>Select Usergroup <span class="red">*</span></label>
                        <select class="input-short" name="ugroup" id="ugroup">
                            <?php
                            $usergrp = $userFunc->getUserGroup();
                            if (is_array($usergrp) && count($usergrp) > 0) {
                                echo '<option value=" ">Select Usergroup</option>';
                                foreach ($usergrp as $grp) {
                                    if (isset($_SESSION['user_group']) && $userFunc->isAdmin($_SESSION['uid'])) {
                                        if ($grp['id'] != 1) {
                                            echo '<option value="' . $grp['id'] . '">' . $grp['group_name'] . '</option>';
                                        }
                                    }
                                    else
                                        echo '<option value="' . $grp['id'] . '">' . $grp['group_name'] . '</option>';
                                }
    //                                       echo $userFunc->createSelectOption($usergrp,'id','group_name',1);
                            }
                            else {
                                echo '<option value=" ">Select Usergroup</option>';
                            }
                            ?>
                        </select>
                    </p>
                </div>
                 <div class="rightsection">
                	  <p>
                    	<label>Email <span class="red">*</span></label>
                        <input type="text" name="email" id="email" class="input-short" value="<?php echo (isset($_REQUEST['email'])) ? $_REQUEST['email'] : ''; ?>"/>
                    </p>
                    <p>
                        <label>Mobile <span class="red">*</span></label>
                        <input type="text" name="mobile" id="mobile" class="input-short" value="<?php echo (isset($_REQUEST['mobile'])) ? $_REQUEST['mobile'] : ''; ?>"/>
                    </p>
                    <p>
                        <label>Address </label>
                        <textarea name="address" id="address" rows="7" cols="90" class="input-short"><?php echo (isset($_REQUEST['address'])) ? $_REQUEST['address'] : ''; ?></textarea>
                    </p>
                </div>
              </div>
           		</fieldset>
                <fieldset>
                	<input class="submit-gray" type="button" value="Back" onclick="back();" />
                    
                    <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                </fieldset>
            </form>
        </div> <!-- End .module-body -->
    </div>  <!-- End .module -->
</div>