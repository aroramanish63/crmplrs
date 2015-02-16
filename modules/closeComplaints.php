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
    }
</style>
<div class="container_12">

    <div class="bottom-spacing" style="width:<?php echo (isset($_POST['btnsearch'])) ? '100%' : '96%'; ?>;margin: 0 auto; float: right;">
        <form name="searchfrm" id="searchfrm" method="post" action="" onsubmit="return validatefilter();">
            <p>
                <label style="float:left;margin-right: 10px;">Complaint No.:</label>
                <input style="float:left;margin-right: 10px;width:160px;" type="text" name="complaintno" class="input-short" id="complaintno" value="<?php echo (isset($_REQUEST['complaintno'])) ? $_REQUEST['complaintno'] : ''; ?>" />
                <!--                <label style="float:left;margin-right: 10px;">Complaint Status:</label>
                                <select style="float:left;margin-right: 10px;width:160px;" name="status" id="status" class="input-short">
                                    <option value="">Select Status</option>
                                    <option value="0" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '0')) ? 'selected="selected"' : ''; ?>>Open</option>
                                    <option value="1" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '1')) ? 'selected="selected"' : ''; ?>>Close</option>
                                </select>-->
                <label style="float:left;margin-right: 10px;">Email:</label>
                <input style="float:left;margin-right: 10px;width:160px;" type="text" name="email" id="email" class="input-short" value="<?php echo (isset($_REQUEST['email'])) ? $_REQUEST['email'] : '' ?>"/>
                <label style="float:left;margin-right: 10px;">Contact No.:</label>
                <input style="float:left;margin-right: 10px;width:160px;" type="text" name="contact_no" id="contact_no" class="input-short" value="<?php echo (isset($_REQUEST['contact_no'])) ? $_REQUEST['contact_no'] : '' ?>"/>
                <input type="submit" name="btnsearch" value="Search" id="btnsearch" class="submit-green" style="float:left;">


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
        <h2><span>Enquiries</span></h2>
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
                            if ($complaintFunc->isCallCentreStaff($_SESSION['uid']) && $list['status'] == '1' && $list['complaint_type'] == '3') {
                                echo '<tr>';
                                echo '<td>' . $i . '</td>';
                                echo '<td>' . $list['ticket_no'] . '</td>';
                                echo '<td>' . $complaintFunc->search_in_array($complaintFunc->getPLRSComplaintType($list['complaint_type']), 'complaint_type') . '</td>';
                                echo '<td>' . $list['name'] . '</td>';
                                echo '<td>' . $list['email'] . '</td>';
                                echo '<td>' . $userFunc->getUsername($list['created_by']) . '</td>';
                                echo '<td>' . date('d-m-Y H:i:s', strtotime($list['add_date'])) . '</td>';
                                echo (isset($list['status']) && ($list['status'] == 0)) ? '<td>Open</td>' : (($list['status'] == 1) ? '<td>Close</td>' : '<td>Forwarded</td>');
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