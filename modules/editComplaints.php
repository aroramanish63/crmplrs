<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');


$complaintFunc = $commonObj->load_class_object('complaintFunctions');
$userFunc = $commonObj->load_class_object('userFunctions');

if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['compidu'] !== '')) {
    if ($complaintFunc->addComplaint(true)) {
        $complaintFunc->redirectUrl('viewComplaints');
    }
}

$details = '';
if (isset($_REQUEST['idu']) && trim($_REQUEST['idu']) != '') {
    $id = trim($_REQUEST['idu']);
    $details = $complaintFunc->getPLRSComplaint($id);
}
?>
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
    if (count($complaintFunc->getErrors()) > 0) {
        echo '<span class="notification n-error">';
        foreach ($complaintFunc->getErrors() as $val) {
            echo $val;
            echo '<br/>';
        }
        echo '</span>';
    }
    ?>
    <div class="module">
        <h2><span>Edit Complaint</span></h2>

        <div class="module-body">
            <?php
            if (is_array($details) && count($details) > 0) {
                $userFunc = $complaintFunc->load_class_object('userFunctions');
                foreach ($details as $detail) {
                    ?>
                    <form action="" onsubmit="return validatecomplaintfrm();" method="post" name="abillfrm" id="abillfrm">
                        <fieldset>
                            <h3>Personal Information</h3>
                            <div class="mainsection">
                                <div class="leftsection">
                                    <p>
                                        <label>Name <span class="red">*</span></label>
                                        <input type="text" name="cname" class="input-short" readonly="readonly" id="cname" value="<?php echo (isset($detail['name'])) ? $detail['name'] : ''; ?>" />
                                    </p>
                                    <p>
                                        <label>Email <span class="red">*</span></label>
                                        <input type="text" name="cemail" class="input-short" readonly="readonly" id="cemail" value="<?php echo (isset($detail['email'])) ? $detail['email'] : ''; ?>" />
                                    </p>
                                    <p>
                                        <label>City <span class="red">*</span></label>
                                        <input type="text" name="city" class="input-short" readonly="readonly" id="city" value="<?php echo (isset($detail['city'])) ? $detail['city'] : ''; ?>" />
                                    </p>
                                </div>
                                <div class="rightsection">
                                    <p>
                                        <label>Contact No. <span class="red">*</span></label>
                                        <input type="text" name="contactno" class="input-short" maxlength="10" readonly="readonly" onkeypress="return checknum(event);" id="contactno" value="<?php echo (isset($detail['contactno'])) ? $detail['contactno'] : ''; ?>" />
                                    </p>
                                    <p>
                                        <label>Address <span class="red">*</span></label>
                                        <textarea name="caddress" class="input-short" readonly="readonly" id="caddress"><?php echo (isset($detail['address'])) ? $detail['address'] : ''; ?></textarea>
                                    </p>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <h3>Complaint Information</h3>
                            <div class="mainsection">
                                <div class="leftsection">
                                    <p>
                                        <label>Complaint No. <span class="red">*</span></label>
                                        <input type="text" name="complaintno" class="input-short" maxlength="10" readonly="readonly" id="complaintno" value="<?php echo (isset($detail['ticket_no'])) ? $detail['ticket_no'] : ''; ?>" />
                                    </p>
                                    <p>
                                        <label>Complaint Date <span class="red">*</span></label>
                                        <input type="text" name="complaintdate" class="input-short" maxlength="10" readonly="readonly" id="complaintdate" value="<?php echo (isset($detail['add_date'])) ? date('d-M-Y', strtotime($detail['add_date'])) : ''; ?>" />
                                    </p>
                                    <p>
                                        <label>Created By <span class="red">*</span></label>
                                        <input type="text" name="createdby" class="input-short" maxlength="10" readonly="readonly" id="createdby" value="<?php echo (isset($detail['created_by'])) ? $userFunc->getUsername($detail['created_by']) : ''; ?>" />
                                    </p>
                                </div>
                                <div class="rightsection">
                                    <p>
                                        <label for="fromdate">Complaint Type <span class="red">*</span></label>
                                        <select name="complainttype" id="complainttype" class="input-short" disabled="disabled">
                                            <option value="">Select Complaint type</option>
                                            <?php
                                            $selected = '';
                                            $complaint_type = $complaintFunc->getPLRSComplaintType();
                                            if (is_array($complaint_type) && count($complaint_type) > 0) {
                                                foreach ($complaint_type as $type) {
                                                    if (isset($detail['complaint_type']) && ($type['id'] === $detail['complaint_type'])) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="' . $type['id'] . '" ' . $selected . '>' . $type['complaint_type'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </p>
                                    <p>
                                        <label>Complaint Description <span class="red">*</span></label>
                                        <textarea name="cdescription" class="input-short" readonly="readonly" id="cdescription"><?php echo (isset($detail['complaint_remarks'])) ? $detail['complaint_remarks'] : ''; ?></textarea>
                                    </p>
                                    <?php
                                    if (isset($detail['complaint_type']) && !empty($detail['complaint_type']) && ($detail['complaint_type'] !== '2')) {
                                        if ($complaintFunc->isCaseCoordinator($_SESSION['uid'])) {
                                            ?>
                                            <script type="text/javascript">
                                                /**
                                                 * function for close the complaint
                                                 */
                                                function complaintStatus(val) {
                                                    if (val !== '0') {
                                                        var status = confirm('Are you sure you want to close Complaint ?');
                                                        if (!status) {
                                                            document.getElementById('status').value = 0;
                                                        }
                                                        else if (status) {
                                                            document.getElementById('closebtn').style.display = 'block';
                                                        }

                                                    }
                                                }
                                            </script>
                                            <p>
                                                <label>Status <span class="red">*</span></label>
                                                <select name="status" id="status" onchange="complaintStatus(this.value);" class="input-short" <?php echo (isset($detail['status']) && ($detail['status'] == '1')) ? 'disabled="disabled"' : ''; ?>>
                                                    <option value="">Select Status</option>
                                                    <option value="0" <?php echo (isset($detail['status']) && ($detail['status'] == '0')) ? 'selected="selected"' : ''; ?>>Open</option>
                                                    <option value="1" <?php echo (isset($detail['status']) && ($detail['status'] == '1')) ? 'selected="selected"' : ''; ?>>Close</option>
                                                </select>
                                            </p>
                                            <?php
                                        }
                                        else {
                                            echo '<input type="hidden" name="status" id="status" value="0" />';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                        <?php
                        $commentUser = false;
                        $plrsRemarks = $complaintFunc->getPLRSRemarks($detail['id']);
                        ?>
                        <?php if (isset($detail['complaint_type']) && !empty($detail['complaint_type']) && ($detail['complaint_type'] === '2')) { ?>
                            <fieldset>
                                <h3>Remarks</h3>
                                <p>
                                    <label>Complaint Remarks <span class="red">*</span></label>
                                    <textarea name="comp_remarks" <?php echo (is_array($plrsRemarks) && count($plrsRemarks) > 0) ? 'readonly="readonly"' : ''; ?>class="input-short" id="comp_remarks"><?php echo (isset($_REQUEST['comp_remarks'])) ? $_REQUEST['comp_remarks'] : ((is_array($plrsRemarks) && count($plrsRemarks) > 0) ? $complaintFunc->search_in_array($plrsRemarks, 'remarks') : ''); ?></textarea>
                                    <input type="hidden" name="comp_type" value="<?php echo $detail['complaint_type']; ?>" />
                                </p>
                            </fieldset>
                            <?php
                        }
                        else {
                            ?>
                            <fieldset>
                                <h3>Remarks</h3>
                                <?php
                                $user_comments = $complaintFunc->getuserComments($detail['id']);

                                if (is_array($user_comments) && count($user_comments) > 0) {
                                    ?>
                                    <table border="1">
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Remarks By</th>
                                            <!--<th>Bill Status</th>-->
                                            <th>Remarks</th>
                                            <th>Remarks Date</th>
                                        </tr>
                                        <?php
                                        $s_no = 1;
                                        foreach ($user_comments as $comments) {
                                            ?>
                                            <tr>
                                                <td><?php echo $s_no; ?></td>
                                                <td><?php echo $userFunc->getUsername($comments['created_by']) . ' ( ' . $complaintFunc->search_in_array($userFunc->getUserGroup($comments['user_group']), 'group_name') . ' ) '; ?></td>
                                                <td><?php echo $comments['remarks']; ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($comments['add_date'])); ?></td>
                                            </tr>
                                            <?php
                                            $s_no++;
                                        }
                                        ?>
                                    </table>
                                    <?php
                                }



                                if (!$complaintFunc->isCallCentreStaff($_SESSION['uid']) && !$complaintFunc->commentUser($_SESSION['user_group'], $detail['id'])) {
                                    $commentUser = true;

                                    if (!$complaintFunc->isSDM($_SESSION['uid'])) {
                                        ?>
                                        <p>
                                            <label>Transferred to <span class="red">*</span></label>
                                            <?php
                                            $post_array = array('btnsearch' => 1, 'u_group' => $_SESSION['transferred_to']);
                                            $usergroup = $complaintFunc->search_in_array($userFunc->getUserGroup($_SESSION['transferred_to']), 'group_name');
                                            $transferred_by = $complaintFunc->search_in_array($userFunc->getUserGroup($_SESSION['user_group']), 'group_name');
                                            $group_arra = $userFunc->getUserListingBySearch($post_array);
                                            ?>
                                            <select name="transferred_to" id="transferred_to">
                                                <option value="">Select <?php echo $usergroup; ?></option>
                                                <?php
                                                $select = '';
                                                if (is_array($group_arra) && count($group_arra) > 0) {
                                                    foreach ($group_arra as $ugroup) {
                                                        echo '<option value="' . $ugroup['id'] . '">' . $ugroup['name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </p>
                                    <?php } ?>
                                    <p>
                                        <label>Complaint Remarks by <?php echo $transferred_by; ?><span class="red">*</span></label>
                                        <textarea name="comp_remarks" class="input-short" id="comp_remarks"><?php echo (isset($_REQUEST['comp_remarks'])) ? $_REQUEST['comp_remarks'] : ''; ?></textarea>
                                        <input type="hidden" name="comp_type" value="<?php echo $detail['complaint_type']; ?>" />
                                        <input type="hidden" name="transferred_by_group" id="transferred_by_group" value="<?php echo $transferred_by; ?>" />
                                    </p>
                                <?php } ?>
                            </fieldset>
                        <?php }
                        ?>
                        <fieldset>
                            <input class="submit-gray" type="button" style="float:left" value="Back" onclick="gotopage('viewComplaints');" />
                            <?php
                            if (!$complaintFunc->isCallCentreStaff($_SESSION['uid'])) {
                                if ((isset($detail['status']) && ($detail['status'] == '0')) && ($detail['complaint_type'] === '1') && ($commentUser == true)) {
                                    ?>
                                    <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                                    <?php
                                }
                                else if ((isset($detail['status']) && ($detail['status'] == '0')) && ($detail['complaint_type'] === '1') && ($commentUser == false) && ($commentUser == false) && $complaintFunc->isCaseCoordinator($_SESSION['uid'])) {
                                    ?>
                                    <input id="closebtn" style="display:none;" class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                                    <input type="hidden" name="comp_type" value="<?php echo $detail['complaint_type']; ?>" />
                                    <?php
                                }
                                else if (isset($detail['status']) && ($detail['status'] == '0') && ($detail['complaint_type'] === '2')) {
                                    ?>
                                    <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                                    <?php
                                }
                            }
                            ?>
                            <input type="hidden" name="compidu" id="compidu" value="<?php echo $detail['id']; ?>" />
                        </fieldset>
                    </form>
                    <?php
                }
            }
            else {
                $complaintFunc->redirectUrl('viewComplaints');
            }
            ?>
        </div> <!-- End .module-body -->
    </div>  <!-- End .module -->
</div>