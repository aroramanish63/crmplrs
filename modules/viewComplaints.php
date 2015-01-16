<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$complaintFunc = $commonObj->load_class_object('complaintFunctions');
?>
<script type="text/javascript">
    function validatefilter() {
        var statusclearance = document.getElementById('statusclearance');
//        if (statusclearance.value == '') {
//            alert('Please select filter.');
//            statusclearance.focus();
//            return false;
//        }
        window.searchfrm.submit();
    }
</script>
<style type="text/css">
    .input-short {
        width: 19%;
    }
</style>
<div class="container_12">
    <?php
    $Adduserbtn = '<a title="Add Complaint/Bill" href="' . SITE_URL . '?page=addComplaints"><input class="submit-green" style="float:right" type="button" value="Add" /></a>';
    ?>
    <div class="bottom-spacing">
        <div>
            <form name="searchfrm" id="searchfrm" method="post" action="" onsubmit="return validatefilter();">
                <p>
                    <label style="float:left;margin-right: 10px;" for="fromdate">Complaint Type: </label>&nbsp;&nbsp;
                    <select name="statusclearance" id="statusclearance" class="input-short" style="float:left;margin-right: 10px">
                        <option value="">Select Complaint type</option>
                        <?php
                        $selected = '';
                        $complaint_type = $complaintFunc->getPLRSComplaintType();
                        if (is_array($complaint_type) && count($complaint_type) > 0) {
                            foreach ($complaint_type as $type) {
                                if (isset($_REQUEST['statusclearance']) && ($type['id'] === $_REQUEST['statusclearance'])) {
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
                    <label style="float:left;margin-right: 10px;">Complaint No.:</label>
                    <input style="float:left;margin-right: 10px;" type="text" name="complaintno" class="input-short" id="complaintno" value="<?php echo (isset($_REQUEST['complaintno'])) ? $_REQUEST['complaintno'] : ''; ?>" />
                    <label style="float:left;margin-right: 10px;">Complaint Status.:</label>
                    <select style="float:left;margin-right: 10px;" name="status" id="status" class="input-short">
                        <option value="">Select Status</option>
                        <option value="0" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '0')) ? 'selected="selected"' : ''; ?>>Open</option>
                        <option value="1" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '1')) ? 'selected="selected"' : ''; ?>>Close</option>
                    </select>
                    &nbsp;&nbsp;
                    <input type="submit" name="btnsearch" value="Search" id="btnsearch" class="submit-green">
                    <?php echo (isset($_SESSION['role']['addComplaints']) && !empty($_SESSION['role']['addComplaints'])) ? $Adduserbtn : ''; ?>
                </p>

            </form>
        </div>
    </div>
    <div style="clear:both;"></div>
    <?php
    echo $complaintFunc->getSessionMessage();
    $complaintFunc->unsetSessionMessage();
    ?>
    <div class="module">
        <h2><span>Complaints</span></h2>
        <div class="module-table-body">
            <table id="myTable" class="tablesorter">
                <thead>
                    <tr>
                        <th style="width:5%">S.No.</th>
                        <th style="width:10%">Complaint No.</th>
                        <th style="width:10%">Complaint Type</th>
                        <th style="width:10%">Name</th>
                        <th style="width:15%">Email</th>
                        <th style="width:10%">Created By</th>
                        <th style="width:13%">Create Date</th>
                        <th style="width:13%">Status</th>
                        <th style="width:5%">Action</th>
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

                    if (is_array($listingarr)) {
                        $userFunc = $complaintFunc->load_class_object('userFunctions');


                        $i = 1;
                        foreach ($listingarr as $list) {
                            if (($complaintFunc->isCounsellor($_SESSION['uid']) || $complaintFunc->isStateCoordinator($_SESSION['uid'])) && ($list['status'] == 0)) {
                                if ($complaintFunc->isStateCoordinator($_SESSION['uid']) && $list['complaint_type'] !== '2' && $list['status'] != 1 && (($list['counseller_stateco_id'] == $_SESSION['uid']) || ($list['counseller_stateco_id'] == 0))) {
                                    echo '<tr>';
                                    echo '<td>' . $i . '</td>';
                                    echo '<td>' . $list['ticket_no'] . '</td>';
                                    echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getPLRSComplaintType($list['complaint_type']), 'complaint_type') . '</td>';
                                    echo '<td>' . $list['name'] . '</td>';
                                    echo '<td>' . $list['email'] . '</td>';
                                    echo '<td>' . $userFunc->getUsername($list['created_by']) . '</td>';
                                    echo '<td>' . date('d-m-Y', strtotime($list['add_date'])) . '</td>';
                                    echo (isset($list['status']) && ($list['status'] == 0)) ? '<td>Open</td>' : '<td>Close</td>';
                                    echo '<td><a href="' . SITE_URL . '?page=editComplaints&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'bin.gif" width="16" title="Edit" height="16" alt="Edit" /></a></td>';
                                    echo '</tr>';
                                    $i++;
                                }
                                else if (!$complaintFunc->isStateCoordinator($_SESSION['uid']) && $list['status'] != 1 && (($list['counseller_stateco_id'] == $_SESSION['uid']) || ($list['counseller_stateco_id'] == 0))) {
                                    echo '<tr>';
                                    echo '<td>' . $i . '</td>';
                                    echo '<td>' . $list['ticket_no'] . '</td>';
                                    echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getPLRSComplaintType($list['complaint_type']), 'complaint_type') . '</td>';
                                    echo '<td>' . $list['name'] . '</td>';
                                    echo '<td>' . $list['email'] . '</td>';
                                    echo '<td>' . $userFunc->getUsername($list['created_by']) . '</td>';
                                    echo '<td>' . date('d-m-Y', strtotime($list['add_date'])) . '</td>';
                                    echo (isset($list['status']) && ($list['status'] == 0)) ? '<td>Open</td>' : '<td>Close</td>';
                                    echo '<td><a href="' . SITE_URL . '?page=editComplaints&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'bin.gif" width="16" title="Edit" height="16" alt="Edit" /></a></td>';
                                    echo '</tr>';
                                    $i++;
                                }
                            }
                            else if ($complaintFunc->isCaseCoordinator($_SESSION['uid']) && $list['status'] != 1) {
                                if (($list['case_cordinator_id'] == $_SESSION['uid'])) {
                                    echo '<tr>';
                                    echo '<td>' . $i . '</td>';
                                    echo '<td>' . $list['ticket_no'] . '</td>';
                                    echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getPLRSComplaintType($list['complaint_type']), 'complaint_type') . '</td>';
                                    echo '<td>' . $list['name'] . '</td>';
                                    echo '<td>' . $list['email'] . '</td>';
                                    echo '<td>' . $userFunc->getUsername($list['created_by']) . '</td>';
                                    echo '<td>' . date('d-m-Y', strtotime($list['add_date'])) . '</td>';
                                    echo (isset($list['status']) && ($list['status'] == 0)) ? '<td>Open</td>' : '<td>Close</td>';
                                    echo '<td><a href="' . SITE_URL . '?page=editComplaints&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'bin.gif" width="16" title="Edit" height="16" alt="Edit" /></a></td>';
                                    echo '</tr>';
                                    $i++;
                                }
                            }
                            else if ($complaintFunc->isSDM($_SESSION['uid']) && $list['status'] != 1) {
                                if (($list['sdm_id'] == $_SESSION['uid'])) {
                                    echo '<tr>';
                                    echo '<td>' . $i . '</td>';
                                    echo '<td>' . $list['ticket_no'] . '</td>';
                                    echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getPLRSComplaintType($list['complaint_type']), 'complaint_type') . '</td>';
                                    echo '<td>' . $list['name'] . '</td>';
                                    echo '<td>' . $list['email'] . '</td>';
                                    echo '<td>' . $userFunc->getUsername($list['created_by']) . '</td>';
                                    echo '<td>' . date('d-m-Y', strtotime($list['add_date'])) . '</td>';
                                    echo (isset($list['status']) && ($list['status'] == 0)) ? '<td>Open</td>' : '<td>Close</td>';
                                    echo '<td><a href="' . SITE_URL . '?page=editComplaints&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'bin.gif" width="16" title="Edit" height="16" alt="Edit" /></a></td>';
                                    echo '</tr>';
                                    $i++;
                                }
                            }
                            else if ($complaintFunc->isSuperAdmin($_SESSION['uid']) || $complaintFunc->isCallCentreStaff($_SESSION['uid'])) {
                                echo '<tr>';
                                echo '<td>' . $i . '</td>';
                                echo '<td>' . $list['ticket_no'] . '</td>';
                                echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getPLRSComplaintType($list['complaint_type']), 'complaint_type') . '</td>';
                                echo '<td>' . $list['name'] . '</td>';
                                echo '<td>' . $list['email'] . '</td>';
                                echo '<td>' . $userFunc->getUsername($list['created_by']) . '</td>';
                                echo '<td>' . date('d-m-Y', strtotime($list['add_date'])) . '</td>';
                                echo (isset($list['status']) && ($list['status'] == 0)) ? '<td>Open</td>' : '<td>Close</td>';
                                echo '<td><a href="' . SITE_URL . '?page=editComplaints&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'bin.gif" width="16" title="Edit" height="16" alt="Edit" /></a></td>';
                                echo '</tr>';
                                $i++;
                            }
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