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
                            <legend><h3>Caller Information</h3></legend>
                            <p>
                                <label>Select Caller <span class="red">*</span></label>
                                <select id="caller" class="input-short" disabled="disabled">
                                    <option value="">Select Caller</option>
                                    <?php
                                    $selected = '';
                                    $caller_type = $complaintFunc->getCallerType();
                                    if (is_array($caller_type) && count($caller_type) > 0) {
                                        foreach ($caller_type as $callers) {
                                            if (isset($detail['caller_type']) && ($callers['id'] === $detail['caller_type'])) {
                                                $selected = 'selected="selected"';
                                            }
                                            else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . $callers['id'] . '" ' . $selected . '>' . $callers['caller_type'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="caller" value="<?php echo $detail['caller_type']; ?>" />
                            </p>
                            <p>
                                <label>Select Country <span class="red">*</span></label>
                                <select name="country" disabled="disabled" id="country" class="input-short" onchange="document.getElementById('country_id').value = this.value;">
                                    <option value="">Select Country</option>
                                    <?php
                                    $selected = '';
                                    $countries = $complaintFunc->getCountries();
                                    if (is_array($countries) && count($countries) > 0) {
                                        foreach ($countries as $country) {

                                            if (isset($detail['country']) && ($country['id'] === $detail ['country'] )) {
                                                $selected = 'selected="selected"';
                                            }
                                            else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . $country['id'] . '" ' . $selected . '>' . $country ['country_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="country_id" id="country_id" value="<?php echo $detail['country']; ?>" />
                            </p>
                        </fieldset>
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
                                        <label>Contact No. <span class="red">*</span></label>
                                        <input type="text" name="contactno" class="input-short" maxlength="10" readonly="readonly" onkeypress="return checknum(event);" id="contactno" value="<?php echo (isset($detail['contactno'])) ? $detail['contactno'] : ''; ?>" />
                                    </p>
                                    <p>
                                        <label>Address <span class="red">*</span></label>
                                        <textarea name="caddress" class="input-short" readonly="readonly" id="caddress"><?php echo (isset($detail['address'])) ? $detail['address'] : ''; ?></textarea>
                                    </p>
                                </div>
                                <div class="rightsection">
                                    <p>
                                        <label>City <span class="red">*</span></label>
                                        <input type="text" name="city" class="input-short" readonly="readonly" id="city" value="<?php echo (isset($detail['city'])) ? $detail['city'] : ''; ?>" />
                                    </p>
                                    <p>
                                        <label>District <span class="red">*</span></label>
                                        <select name="district" id="district" class="input-short" disabled="disabled" onchange="getTehsilbyAjax(this.value, 'tehsil', '<?php echo get_class($complaintFunc); ?>');">
                                            <option value="">Select District</option>
                                            <?php
                                            $selected = '';
                                            $district_list = $complaintFunc->getDistricts();
                                            if (is_array($district_list) && count($district_list) > 0) {
                                                foreach ($district_list as $district) {
                                                    if (isset($detail['district']) && ($district['id'] === $detail['district'])) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="' . $district['id'] . '" ' . $selected . '>' . $district['district_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </p>
                                    <p>
                                        <label>Tehsil <span class="red">*</span></label>
                                        <select name="tehsil" id="tehsil" class="input-short" disabled="disabled">
                                            <option value="">Select Tehsil</option>
                                            <?php
                                            $selected = '';
                                            $tehsil_list = $complaintFunc->getTehsils(array('district_id' => $detail['district']));
                                            if (is_array($tehsil_list) && count($tehsil_list) > 0) {
                                                foreach ($tehsil_list as $tehsil) {
                                                    if (isset($detail['tehsil']) && ($tehsil['id'] === $detail['tehsil'])) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="' . $tehsil['id'] . '" ' . $selected . '>' . $tehsil['tehsil_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </p>
                                    <p>
                                        <label>Sub Tehsil <span class="red">*</span></label>
                                        <select name="subtehsil" id="subtehsil" class="input-short" disabled="disabled">
                                            <option value="">Select Sub Tehsil</option>
                                            <?php
                                            $selected = '';
                                            if (isset($detail['tehsil'])) {
                                                $subtehsil_list = $complaintFunc->getSubTehsils(array('tehsil_id' => $detail['tehsil']));
                                                if (is_array($subtehsil_list) && count($subtehsil_list) > 0) {
                                                    foreach ($subtehsil_list as $subtehsil) {
                                                        if (isset($detail['tehsil']) && ($subtehsil['id'] === $detail['tehsil'])) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                        else {
                                                            $selected = '';
                                                        }
                                                        echo '<option value="' . $subtehsil['id'] . '" ' . $selected . '>' . $subtehsil['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
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
//                                        if (!$complaintFunc->isCaseCoordinator($_SESSION['uid'])) {
                                        ?>
                                        <script type="text/javascript">
                                            /**
                                             * function for close the complaint
                                             */
                                            function complaintStatus(val) {

                                                if (val.checked) {
                                                    var status = confirm('Are you sure you want to close Complaint ?');
                                                    if (!status) {
                                                        document.getElementById('status').value = 2;
                                                        document.getElementById('statusselect').value = 2;
                                                        val.checked = false;
                                                        return false;
                                                    }
                                                    else if (status) {
                                                        document.getElementById('status').value = val.value;
                                                        document.getElementById('statusselect').value = val.value;
                                                        window.abillfrm.submit();
                                                    }

                                                }
                                                else {
                                                    alert('Please select action.');
                                                    document.getElementById('status').value = '';
                                                    document.getElementById('statusselect').value = '';
                                                    val.checked = false;
                                                    return false;
                                                }
                                            }

                                            /**
                                             * function for validate form SDM
                                             */
                                            function validateAction() {
                                                //                                                var action = document.getElementById('action').checked;
                                                //                                                var action = document.getElementsByName('action').checked;
                                                var comp_remarks = document.getElementById('comp_remarks');
                                                if (!getCheckedRadioId('action')) {
                                                    alert('Please select action.');
                                                    return false;
                                                }
                                                var transferred_to = document.getElementById('transferred_to');
                                                var transferdiv = document.getElementById('transferdiv');

                                                if (typeof (transferdiv) != 'undefined' && transferdiv != null) {
                                                    if (transferdiv.style.display === 'block')
                                                    {
                                                        if (transferred_to.value == '' || transferred_to.value.replace(/\s+$/, '') == '') {
                                                            alert('Please select Transferred to.');
                                                            transferred_to.focus();
                                                            return false;
                                                        }
                                                    }
                                                }
                                                if (typeof (comp_remarks) != 'undefined' && comp_remarks != null) {
                                                    if (comp_remarks.value == '' || comp_remarks.value.replace(/\s+$/, '') == '') {
                                                        alert('Please enter complaint remarks.');
                                                        comp_remarks.focus();
                                                        return false;
                                                    }
                                                }
                                                window.abillfrm.submit();
                                            }
                                        </script>
                                        <p>
                                            <label>Status <span class="red">*</span></label>
                                            <select name="statusselect" id="statusselect" onchange="complaintStatus(this.value);" disabled="disabled" class="input-short" <?php echo (isset($detail['status']) && ($detail['status'] == '1')) ? 'disabled="disabled"' : ''; ?>>
                                                <option value="">Select Status</option>
                                                <option value="0" <?php echo (isset($detail['status']) && ($detail['status'] == '0')) ? 'selected="selected"' : ''; ?>>Open</option>
                                                <option value="1" <?php echo (isset($detail['status']) && ($detail['status'] == '1')) ? 'selected="selected"' : ''; ?>>Close</option>
                                                <?php if (isset($detail['complaint_type']) && !empty($detail['complaint_type']) && ($detail['complaint_type'] === '1')) { ?>
                                                    <option value="2" <?php echo (isset($detail['status']) && ($detail['status'] == '2')) ? 'selected="selected"' : ''; ?>>Forward</option>
                                                    <option value="3" <?php echo (isset($detail['status']) && ($detail['status'] == '3')) ? 'selected="selected"' : ''; ?>>Assign / Under Process</option>
                                                    <option value="4" <?php echo (isset($detail['status']) && ($detail['status'] == '4')) ? 'selected="selected"' : ''; ?>>Completed</option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="status" id="status" value="<?php echo $detail['status']; ?>" />
                                        </p>
                                        <?php
//                                        }
//                                        else {
//                                            echo '<input type="hidden" name="status" id="status" value="0" />';
//                                        }
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
                        else if (isset($detail['complaint_type']) && !empty($detail['complaint_type']) && ($detail['complaint_type'] === '3' || $detail['complaint_type'] === '4')) {
                            ?>
                            <fieldset>
                                <h3>Remarks</h3>
                                <p>
                                    <label>Select Action <span class="red">*</span></label>
                                    <input type="radio" <?php echo ($detail['status'] === '1') ? 'checked="checked"' : ''; ?> name="action" id="action" value="1" onclick="document.getElementById('status').value = this.value;
                                                        document.getElementById('statusselect').value = this.value;" /> Close
                                </p>
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



                                if (!$complaintFunc->commentUser($_SESSION['user_group'], $detail['id'])) {
                                    $commentUser = true;

                                    if (!$complaintFunc->isSDM($_SESSION['uid'])) {
                                        ?>
                                        <p>
                                            <label>Select Action <span class="red">*</span></label>
                                            <input type="radio" name="action" id="action" value="1" onclick="enableTransfer(this.value);" /> Close
                                            &nbsp;
                                            <?php if (isset($detail['status']) && $detail['status'] == '0') { ?>
                                                <input type="radio" name="action" id="forward" value="2" onclick="enableTransfer(this.value);" /> Forward
                                                <?php
                                            }
                                            else if (isset($detail['status']) && $detail['status'] == '2') {
                                                ?>
                                                <input type="radio" name="action" id="assign" value="3" onclick="enableTransfer(this.value);" /> Assign / Under Process
                                            <?php } ?>
                                        </p>
                                        <p id="transferdiv" style="display:none;">
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
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <p>
                                            <label>Select Action <span class="red">*</span></label>
                                            <input type="radio" name="action" id="action" value="4" onclick="enableTransfer(this.value);" /> Completed
                                        </p>
                                    <?php } ?>
                                    <p>
                                        <label>Complaint Remarks by <?php echo $transferred_by; ?><span class="red">*</span></label>
                                        <textarea name="comp_remarks" class="input-short" id="comp_remarks"><?php echo (isset($_REQUEST['comp_remarks'])) ? $_REQUEST['comp_remarks'] : ''; ?></textarea>
                                        <input type="hidden" name="comp_type" value="<?php echo $detail['complaint_type']; ?>" />
                                        <input type="hidden" name="transferred_by_group" id="transferred_by_group" value="<?php echo $transferred_by; ?>" />
                                    </p>
                                    <?php
                                }
// For Close Complaint by Selected counseller or state co ordinator
                                if ((isset($detail['status']) && ($detail['status'] == '4')) && ($detail['complaint_type'] === '1') && ($detail['counseller_stateco_id'] == $_SESSION['uid']) && ($commentUser == false)) {
                                    ?>
                                    <p>
                                        <label>Select Action <span class="red">*</span></label>
                                        <input type="radio" name="action" id="action" value="1" onclick="document.getElementById('status').value = this.value;
                                                                document.getElementById('statusselect').value = this.value;" /> Close
                                    </p>
                                <?php } ?>

                            </fieldset>
                        <?php }
                        ?>
                        <fieldset>
                            <input class="submit-gray" type="button" style="float:left" value="Back" onclick="gotopage('viewComplaints');" />
                            <?php
//                            echo $commentUser;
//                            if (!$complaintFunc->isCallCentreStaff($_SESSION['uid'])) {
                            if ((isset($detail['status']) && ($detail['status'] == '0' || $detail['status'] == '2' || $detail['status'] == '3')) && ($detail['complaint_type'] === '1') && ($commentUser == true)) {
                                ?>
                                <input type="hidden" name="auserSubmit" value="1" />
                                <input class="submit-green" type="button" value="Submit" onclick="validateAction();" />
                                <input type="hidden" name="comp_type" value="<?php echo $detail['complaint_type']; ?>" />
                                <?php
                            }
                            else if ((isset($detail['status']) && ($detail['status'] == '2' || $detail['status'] == '4')) && ($detail['complaint_type'] === '1') && ($detail['counseller_stateco_id'] == $_SESSION['uid']) && ($commentUser == false)) {
                                ?>
                                <input id="closebtn" class="submit-green" type="button" value="Submit" onclick="complaintStatus(document.getElementById('action'));" />
                                <input type="hidden" name="auserSubmit" value="1" />
                                <input type="hidden" name="comp_type" value="<?php echo $detail['complaint_type']; ?>" />
                                <?php
                            }
                            else if (isset($detail['status']) && ($detail['status'] == '0') && ($detail['complaint_type'] === '2') && !$complaintFunc->isCallCentreStaff($_SESSION['uid'])) {
                                ?>
                                <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                                <?php
                            }
                            if ((isset($detail['status']) && ($detail['status'] == '0')) && ($detail['complaint_type'] === '3')) {
                                ?>
                                <input type="hidden" name="auserSubmit" value="1" />
                                <input class="submit-green" type="button" onclick="validateEnquiry();" value="Submit" />
                                <?php
                            }
//                            }
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
