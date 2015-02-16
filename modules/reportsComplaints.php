<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$complaintFunc = $commonObj->load_class_object('complaintFunctions');
?>
<script type="text/javascript">
    function validatefilter() {
        var complaintno = document.getElementById('complaintno');
        var email = document.getElementById('email');
        var contact_no = document.getElementById('contact_no');
        if (complaintno.value.replace(/\s+$/, '') == '' && email.value.replace(/\s+$/, '') == '' && contact_no.value.replace(/\s+$/, '') == '') {
            alert('Please enter atleast one filter value.');
            complaintno.focus();
            return false;
        }
        window.searchfrm.submit();
    }
</script>
<style type="text/css">
    .input-short {
        width: 19%;
        margin-right: 25px;
    }
    label{
        width:120px;
    }
</style>
<div class="container_12">
    <?php
    $Adduserbtn = '<a title="Add Complaint/Bill" href="' . SITE_URL . '?page=addComplaints" class="submit-green" style="float:right;color:#fff;padding:0px 12px;">Add</a>';
    ?>
    <div class="bottom-spacing" style="width:<?php echo (isset($_POST['btnsearch'])) ? '100%' : '96%'; ?>;margin: 0 auto; float: right;">
        <form name="searchfrm" id="searchfrm" method="post" action="" onsubmit="return validatefilter();">
            <p>
                <!--                <label style="float:left;margin-right: 10px;">Complaint No.:</label>
                                <input style="float:left;margin-right: 10px;width:160px;" type="text" name="complaintno" class="input-short" id="complaintno" value="<?php echo (isset($_REQUEST['complaintno'])) ? $_REQUEST['complaintno'] : ''; ?>" />-->
                <label style="float:left;">Select Caller</label>
                <select style="float:left;width:160px;" name="caller" id="caller" class="input-short" onchange="getCallercountries(this.value, 'country');">
                    <option value="">Select Caller</option>
                    <?php
                    $selected = '';
                    $caller_type = $complaintFunc->getCallerType();
                    if (is_array($caller_type) && count($caller_type) > 0) {
                        foreach ($caller_type as $callers) {
                            if (isset($_REQUEST['caller']) && ($callers['id'] === $_REQUEST['caller'])) {
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
                <label style="float:left;">Complaint Status:</label>
                <select style="float:left;width:160px;" name="status" id="status" class="input-short">
                    <option value="">Select Status</option>
                    <option value="0" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '0')) ? 'selected="selected"' : ''; ?>>Open</option>
                    <option value="1" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '1')) ? 'selected="selected"' : ''; ?>>Close</option>
                    <option value="2" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '2')) ? 'selected="selected"' : ''; ?>>Forward</option>
                    <option value="3" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '3')) ? 'selected="selected"' : ''; ?>>Assign / Under Process</option>
                    <option value="4" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '4')) ? 'selected="selected"' : ''; ?>>Completed</option>
                </select>
                <label style="float:left;">Complaint No.:</label>
                <input style="float:left;width:150px;" type="text" name="complaint_no" id="complaint_no" class="input-short" value="<?php echo (isset($_REQUEST['complaint_no'])) ? $_REQUEST['complaint_no'] : '' ?>"/>
                <br/>
                <br/>
                <label style="float:left;">District</label>
                <select style="float:left;width:160px;" name="district" id="district" class="input-short" onchange="getTehsilbyAjax(this.value, 'tehsil', '<?php echo get_class($complaintFunc); ?>');">
                    <option value="">Select District</option>
                    <?php
                    $selected = '';
                    $district_list = $complaintFunc->getDistricts();
                    if (is_array($district_list) && count($district_list) > 0) {
                        foreach ($district_list as $district) {
                            if (isset($_REQUEST['district']) && ($district['id'] === $_REQUEST['district'])) {
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
                <label style="float:left;">Tehsil</label>
                <select style="float:left;width:160px;" name="tehsil" id="tehsil" class="input-short"  onchange="getSubTehsilbyAjax(this.value, 'subtehsil', '<?php echo get_class($complaintFunc); ?>');">
                    <option value="">Select Tehsil</option>
                    <?php
                    $selected = '';
                    $tehsil_list = $complaintFunc->getTehsils();
                    if (is_array($tehsil_list) && count($tehsil_list) > 0) {
                        foreach ($tehsil_list as $tehsil) {
                            if (isset($_REQUEST['tehsil']) && ($tehsil['id'] === $_REQUEST['tehsil'])) {
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
                <label style="float: left;">Sub Tehsil</label>
                <select style="float: left;width:160px;" name="subtehsil" id="subtehsil" class="input-short">
                    <option value="">Select Sub Tehsil</option>
                    <?php
                    $selected = '';
                    if (isset($_REQUEST['tehsil'])) {
                        $subtehsil_list = $complaintFunc->getSubTehsils(array('tehsil_id' => $_REQUEST['tehsil']));
                        if (is_array($subtehsil_list) && count($subtehsil_list) > 0) {
                            foreach ($subtehsil_list as $subtehsil) {
                                if (isset($_REQUEST['subtehsil']) && ($subtehsil['id'] === $_REQUEST['subtehsil'])) {
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
                <br/>
                <br/>
                <label style="float:left;">Email:</label>
                <input style="float:left;width:150px;" type="text" name="email" id="email" class="input-short" value="<?php echo (isset($_REQUEST['email'])) ? $_REQUEST['email'] : '' ?>"/>
                <label style="float:left;">Contact No.:</label>
                <input style="float:left;width:150px;" type="text" name="contact_no" id="contact_no" class="input-short" value="<?php echo (isset($_REQUEST['contact_no'])) ? $_REQUEST['contact_no'] : '' ?>"/>
                <input type="submit" name="btnsearch" value="Search" id="btnsearch" class="submit-green" style="float:left;">
                <input type="button" value="Export Report" id="btnsearch" onclick="exportCheck();" class="submit-gray" style="float:left;">
                <input type="hidden" name="export" id="export" value="no" />
                <?php
                if (isset($_POST['btnsearch']) && $complaintFunc->isCallCentreStaff($_SESSION['uid'])) {
                    echo '<input type="button" name="btnsearch" value="Back" onclick="gotopage(\'reportsComplaints\')" class="submit-gray" style="float:left;">';
                }
                ?>
                <?php // echo (isset($_SESSION['role']['addComplaints']) && !empty($_SESSION['role']['addComplaints'])) ? $Adduserbtn : ''; ?>
            </p>
            <p>&nbsp;</p>

        </form>
    </div>

    <div style="clear:both;"></div>
    <?php
    echo $complaintFunc->getSessionMessage();
    $complaintFunc->unsetSessionMessage();
    ?>
    <div class="module">
        <h2><span>Complaints Report</span></h2>
        <div class="module-table-body">
            <table id="myTable" class="tablesorter">
                <thead>
                    <tr>
                        <th style="width:5%">S.No.</th>
                        <th style="width:10%">Complaint No.</th>
                        <th style="width:10%">Caller</th>
                        <th style="width:10%">Complaint Type</th>
                        <th style="width:10%">Name</th>
                        <th style="width:10%">Email</th>
                        <th style="width:10%">Contact No.</th>
                        <th style="width:10%">District</th>
                        <th style="width:10%">Tehsil</th>
                        <th style="width:10%">Sub Tehsil</th>
                        <th style="width:10%">Created By</th>
                        <th style="width:15%">Create Date</th>
                        <th style="width:10%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $returnString = '';
                    if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['btnsearch'])) {
                        $listingarr = $complaintFunc->getPLRSComplaintbyCriteria();
                    }
                    else
                        $listingarr = $complaintFunc->getPLRSComplaint();

                    if (is_array($listingarr) && count($listingarr) > 0) {
                        $userFunc = $complaintFunc->load_class_object('userFunctions');


                        $i = 1;
                        foreach ($listingarr as $list) {

                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . $list['ticket_no'] . '</td>';
                            echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getCallerType(array('id' => $list['caller_type'])), 'caller_type') . '</td>';
                            echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getPLRSComplaintType($list['complaint_type']), 'complaint_type') . '</td>';
                            echo '<td>' . $list['name'] . '</td>';
                            echo '<td>' . $list['email'] . '</td>';
                            echo '<td>' . $list['contactno'] . '</td>';
                            echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getDistricts(array('id' => $list['district'])), 'district_name') . '</td>';
                            echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getTehsils(array('id' => $list['tehsil'])), 'tehsil_name') . '</td>';
                            echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getSubTehsils(array('id' => $list['sub_tehsil'])), 'name') . '</td>';
                            echo '<td>' . $userFunc->getUsername($list['created_by']) . '</td>';
                            echo '<td>' . date('d-m-Y H:i:s', strtotime($list['add_date'])) . '</td>';
                            echo (isset($list['status']) && ($list['status'] == 0)) ? '<td>Open</td>' : (($list['status'] == 1) ? '<td>Close</td>' : (($list['status'] == 2) ? '<td>Forwarded</td>' : (($list['status'] == 3) ? '<td>Assign / Under Process</td>' : '<td>Completed</td>')));
                            echo '</tr>';
                            $i++;
                        }
                    }
                    else
                        echo '<tr><td colspan="15" style="text-align:center">' . $complaintFunc->getMessage() . '</td>';
                    ?>
                </tbody>
            </table>

            <div class="pager" id="pager">
                <form action="">
                    <div>
                        <img class="first" src="<?php echo IMAGE_URL; ?>arrow-stop-180.gif" alt="first"/>
                        <img class="prev" src="<?php echo IMAGE_URL; ?>arrow-180.gif" alt="prev"/>
                        <input type="text" class="pagedisplay input-short align-center"/>
                        <img class="next" src="<?php echo IMAGE_URL; ?>arrow.gif" alt="next"/>
                        <img class="last" src="<?php echo IMAGE_URL; ?>arrow-stop.gif" alt="last"/>
                        <select class="pagesize input-short align-center">
                            <option value="10" selected="selected">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                        </select>
                    </div>
                </form>
            </div>
            <!--                        <div class="table-apply">
                                        <form action="">
                                        <div>
                                        <span>Apply action to selected:</span>
                                        <select class="input-medium">
                                            <option value="1" selected="selected">Select action</option>
                                            <option value="2">Publish</option>
                                            <option value="3">Unpublish</option>
                                            <option value="4">Delete</option>
                                        </select>
                                        </div>
                                    </div>-->
            <div style="clear: both"></div>
        </div> <!-- End .module-table-body -->
    </div> <!-- End .module -->

</div>