<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$commonObj->load_class('userFunctions');
$userFunc = new userFunctions();
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $userFunc->updateUserprofile();
}
?>
<script type="text/javascript">
    /**
     * validate form
     */
    function validateprofilefrm() {
        var ename = document.getElementById('ename');
        var mobile = document.getElementById('mobile');
        var address = document.getElementById('address');


        if (ename.value == '' || ename.value.replace(/\s+$/, '') == '') {
            alert('Please enter name.');
            ename.focus();
            return false;
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
        if (address.value == '' || address.value.replace(/\s+$/, '') == '') {
            alert('Please enter address.');
            address.focus();
            return false;
        }
        window.profilefrm.submit();
    }

</script>
<div class="container_12">
    <!-- Form elements -->
    <?php
    if ($userFunc->getMessage()) {
        echo $userFunc->getMessage();
    }
    ?>
    <div id="userfrm" class="grid_12">
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
            <h2><span>User Profile</span></h2>

            <div class="module-body">
                <?php
                $userdetails = $userFunc->getUserDetail($_SESSION['uid']);
                if (is_array($userdetails) && count($userdetails) > 0) {
                    foreach ($userdetails as $details) {
                        $userName = $details['username'];
                        $name = $details['name'];
                        $email = $details['email'];
                        $mobile = $details['mobile_no'];
                        $address = $details['address'];
                        $uid = $details['id'];
                    }
                }
                ?>
                <form action="" method="post" name="profilefrm" id="profilefrm" onsubmit="return validateprofilefrm();">
                    <p>
                        <label><strong>Username</strong> : <?php echo $_SESSION['username'] ?></label>
                    </p>
                    <p>
                        <label><strong>Email</strong> : <?php echo $email; ?></label>
                    </p>
                    <p>
                        <label>Name :<span class="red">*</span></label>
                        <input type="text" class="input-short" name="ename" value="<?php echo ($name != '') ? $name : $_REQUEST['ename']; ?>" id="ename" />
                    </p>
                    <p>
                        <label>Mobile :<span class="red">*</span></label>
                        <input type="text" class="input-short" name="mobile" value="<?php echo ($mobile != '') ? $mobile : $_REQUEST['mobile']; ?>" id="mobile" />
                    </p>
                    <p>
                        <label>Address <span class="red">*</span></label>
                        <textarea name="address" id="address" rows="7" cols="90" class="input-short"><?php echo ($address != '') ? $address : $_REQUEST['address']; ?></textarea>
                    </p>
                    <fieldset>
                        <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                        <input class="submit-green" type="submit" name="updateSubmit" value="Submit" />
                        <input class="submit-gray" type="reset" value="Cancel" />
                    </fieldset>
                </form>
            </div> <!-- End .module-body -->
        </div>  <!-- End .module -->
        <div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div>