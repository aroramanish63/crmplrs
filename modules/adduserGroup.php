<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$commonObj->load_class('userFunctions');
$userFunc = new userFunctions();
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    if ($userFunc->addUserGroup()) {
        $userFunc->redirectUrl('userGroup');
    }
}
?>
<script type="text/javascript">
    /**
     * validate form
     */
    function validateusergrpfrm() {
        var gname = document.getElementById('gname');
        var group_level = document.getElementById('group_level');
        var description = document.getElementById('description');



        if (gname.value == '' || gname.value.replace(/\s+$/, '') == '') {
            alert('Please enter user group name.');
            gname.focus();
            return false;
        }
        if (group_level.value == '' || group_level.value.replace(/\s+$/, '') == '') {
            alert('Please select user group level.');
            group_level.focus();
            return false;
        }
        if (description.value == '' || description.value.replace(/\s+$/, '') == '') {
            alert('Please enter description.');
            description.focus();
            return false;
        }

        if ($('input:checkbox:checked').length == 0) {
            alert('Please assign roles.');
            return false;
        }

        window.auserfrm.submit();
    }

</script>
<div class="container_12">
    <!-- Form elements -->
    <?php
    if ($userFunc->getMessage()) {
        if ($userFunc->getMessageType() == 'success') {
//                        echo '<script type="text/javascript">document.getElementById(\'auserfrm\').reset();</script>';
        }
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
            <h2><span>Add User Group</span></h2>

            <div class="module-body">
                <form action="" method="post" name="auserfrm" id="auserfrm">
                    <p>
                        <label>Group Name <span class="red">*</span></label>
                        <input type="text" name="gname" id="gname" class="input-short" value="<?php echo (isset($_REQUEST['gname'])) ? $_REQUEST['gname'] : ''; ?>" />
                    </p>
                    <p>
                        <label>Group Level <span class="red">*</span></label>
                        <select name="group_level" id="group_level" class="input-short">
                            <option value="">Select group level</option>
                            <option value="-1">No Level</option>
                            <option value="0">Level 0</option>
                            <option value="1">Level 1</option>
                            <option value="2">Level 2</option>
                            <option value="3">Level 3</option>
                            <option value="4">Level 4</option>
                            <option value="5">Level 5</option>
                            <option value="6">Level 6</option>
                        </select>
                    </p>
                    <p>
                        <label>Group Description <span class="red">*</span></label>
                        <textarea name="description" id="description" rows="7" cols="90" class="input-short"><?php echo (isset($_REQUEST['description'])) ? $_REQUEST['description'] : ''; ?></textarea>
                    </p>
                    <p>
                        <label>Complaint Transferred <span class="red">*</span></label>
                    <table border="1">
                        <tr><th>Complaint Transferred To</th><th>Apply</th></tr>
                        <?php
                        $group_arr = array();
                        $checked = '';
                        $group_arr = isset($detail['transferred_to']) ? explode(',', $detail['transferred_to']) : '';
                        $ugroups = $userFunc->getUserGroup();
                        if (is_array($ugroups) && count($ugroups) > 0) {
                            echo '<tr><td>None</td><td><input type="checkbox" onclick="disabledTransfer();" id="transferred_none" name="transferred_to[]" value="0" /></td></tr>';
                            foreach ($ugroups as $group) {
                                if (is_array($group_arr) && count($group_arr) > 0) {
                                    if (in_array($group['id'], $group_arr)) {
                                        $checked = 'checked="checked"';
                                    }
                                    else {
                                        $checked = '';
                                    }
                                }
                                echo '<tr><td>' . $group['group_name'] . '</td><td><input type="checkbox" id="transferred_' . str_replace(array(' ', '-'), '_', $group['group_name']) . '" name="transferred_to[]" value="' . $group['id'] . '" ' . $checked . ' /></td></tr>';
                            }
                        }
                        ?>
                    </table>
                    </p>
                    <p>
                        <label>Assign Roles <span class="red">*</span></label>
                    <table border="1">
                        <tr><th>Roles</th><th>Role Description</th><th>Apply</th></tr>
                        <?php
                        $userRole = $userFunc->getUserRoles();
                        if (is_array($userRole) && count($userRole) > 0) {
                            foreach ($userRole as $role) {
                                echo '<tr><td>' . $role['role_name'] . '</td><td>' . $role['role_description'] . '</td><td><input type="checkbox" id="role" name="rolesid[]" value="' . $role['id'] . '" /></td></tr>';
                            }
                        }
                        ?>
                    </table>
                    </p>
                    <fieldset>
                        <input class="submit-gray" type="button" value="Back" onclick="gotopage('userGroup');" />
                        <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                    </fieldset>
                </form>
            </div> <!-- End .module-body -->
        </div>  <!-- End .module -->
        <div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div>