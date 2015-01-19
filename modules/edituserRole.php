<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$commonObj->load_class('userFunctions');
$userFunc = new userFunctions();
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    if ($userFunc->addUserRole(true)) {
        $userFunc->redirectUrl('userRole');
    }
}

$udetail = '';
if (isset($_REQUEST['idu']) && trim($_REQUEST['idu']) != '') {
    $uid = trim($_REQUEST['idu']);
    $udetail = $userFunc->getUserRoles($uid);
}
?>
<script type="text/javascript">
    /**
     * validate form
     */
    function validateuserrolefrm() {
        var rname = document.getElementById('rname');
        var pname = document.getElementById('pname');
        var description = document.getElementById('description');

        if (rname.value == '' || rname.value.replace(/\s+$/, '') == '') {
            alert('Please enter role name.');
            rname.focus();
            return false;
        }
        if (pname.value == '' || pname.value.replace(/\s+$/, '') == '') {
            alert('Please enter page name.');
            pname.focus();
            return false;
        }
        if (description.value == '' || description.value.replace(/\s+$/, '') == '') {
            alert('Please enter description.');
            description.focus();
            return false;
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
    <div id="userfrm" class="grid_12" style="display:block;">
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
            <h2><span>Add User Role</span></h2>

            <div class="module-body">
                <form action="" method="post" name="auserfrm" id="auserfrm" onsubmit="return validateuserrolefrm();">
                    <?php
                    if (is_array($udetail) && $udetail != '') {
                        foreach ($udetail as $detail) {
                            ?>
                            <p>
                                <label>Role Name <span class="red">*</span></label>
                                <input type="text" name="rname" id="rname" class="input-short" value="<?php echo isset($detail['role_name']) ? $detail['role_name'] : ''; ?>" />
                            </p>
                            <p>
                                <label>Page Name <span class="red">*</span></label>
                                <input type="text" name="pname" id="pname" <?php echo (isset($_SESSION['user_group']) && ($_SESSION['user_group'] == '1')) ? '' : 'readonly="readonly"'; ?> class="input-short" value="<?php echo isset($detail['page_name']) ? $detail['page_name'] : ''; ?>" />
                            </p>
                            <p>
                                <label>Parent</label>
                                <select class="input-short" name="parentId">
                                    <?php
                                    $roles = $userFunc->getUserRoles();
                                    if (is_array($roles) && count($roles)) {
                                        echo '<option value="">Select Parent</option>';
                                        echo $userFunc->createSelectOption($roles, 'id', 'role_name', '', $detail['parentId']);
                                    }
                                    else {
                                        echo '<option value="">Select Parent</option>';
                                    }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <label>Role Description <span class="red">*</span></label>
                                <textarea name="description" id="description" rows="7" cols="90" class="input-short"><?php echo isset($detail['role_description']) ? $detail['role_description'] : ''; ?></textarea>
                            </p>
                            <fieldset>
                                <input class="submit-gray" type="button" value="Back" onclick="gotopage('userRole');" />
                                <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                                <input type="hidden" name="role_id" id="role_id" value="<?php echo isset($detail['id']) ? $detail['id'] : ''; ?>" />
                            </fieldset>
                            <?php
                        }
                    }
                    ?>
                </form>
            </div> <!-- End .module-body -->
        </div>  <!-- End .module -->
        <div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div>