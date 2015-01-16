<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$commonObj->load_class('userFunctions');
$userFunc = new userFunctions();
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    if ($userFunc->resetPassword()) {
        $userFunc->redirectUrl('userManagement');
    }
}
?>
<script type="text/javascript">

    /**
     * function for go to back page
     */
    function back() {
        window.location = '<?php echo SITE_URL ?>?page=viewComplaints';
    }

    /**
     * validate form
     */
    function validateuserfrm() {
        var upassword = document.getElementById('upassword');
        var cpassword = document.getElementById('cpassword');

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
        window.auserfrm.submit();
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
        <h2><span>Reset Password</span></h2>

        <div class="module-body">
            <?php if (isset($_REQUEST['idu']) && !empty($_REQUEST['idu'])) { ?>
                <form action="" method="post" name="auserfrm" id="auserfrm" onsubmit="return validateuserfrm();">
                    <p>
                        <label>New Password <span class="red">*</span></label>
                        <input type="password" name="upassword" id="upassword" class="input-short" />
                    </p>
                    <p>
                        <label>Confirm Password <span class="red">*</span></label>
                        <input type="password" name="cpassword" id="cpassword" class="input-short" />
                    </p>

                    <fieldset>
                        <input type="hidden" name="uid" id="uid" value="<?php echo trim($_REQUEST['idu']) ?>" />
                        <input class="submit-gray" type="button" value="Back" onclick="back();" />
                        <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                    </fieldset>
                </form>
            <?php } ?>
        </div> <!-- End .module-body -->
    </div>  <!-- End .module -->
</div>