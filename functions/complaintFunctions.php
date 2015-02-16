<?php

if (!defined('BASE_PATH'))
    exit('No direct script access allowed');

class complaintFunctions extends commonFxn {

    public function getPLRSComplaint($id = '', $orderby = false) {
        $returnArr = array();
        $condition = '';
        $order = '';
        if (trim($id) != '') {
            $condition = " where id='$id'";
        }

        if (!$orderby) {
            $order = " order by id desc";
        }

        $selectData = mysql_query("select * from $this->plrs_complaint $condition $order") or die(mysql_error());
        if ($this->countTablerows($selectData) > 0) {
            while ($rows = mysql_fetch_assoc($selectData)) {
                $returnArr[] = $rows;
            }
            return $returnArr;
        }
        else {
            $this->setMessage('No Records Found.');
        }
    }

    public function getPLRSComplaintbyCriteria() {
        $returnArr = array();
        $condition = 'where 1';
        $order = ' order by id desc';
        if (!isset($_POST['btnsearch'])) {
            return false;
        }

        if (isset($_POST['statusclearance']) && $_POST['statusclearance'] !== '') {
            $condition .= " and complaint_type='" . $this->real_escape_string($_POST['statusclearance']) . "'";
        }

        if (isset($_POST['caller']) && $_POST['caller'] !== '') {
            $condition .= " and caller_type='" . $this->real_escape_string($_POST['caller']) . "'";
        }

        if (isset($_POST['district']) && $_POST['district'] !== '') {
            $condition .= " and district='" . $this->real_escape_string($_POST['district']) . "'";
        }

        if (isset($_POST['tehsil']) && $_POST['tehsil'] !== '') {
            $condition .= " and tehsil='" . $this->real_escape_string($_POST['tehsil']) . "'";
        }

        if (isset($_POST['subtehsil']) && $_POST['subtehsil'] !== '') {
            $condition .= " and sub_tehsil='" . $this->real_escape_string($_POST['subtehsil']) . "'";
        }

        if (isset($_POST['complaintno']) && $_POST['complaintno'] !== '') {
            $condition .= " and ticket_no='" . $this->real_escape_string($_POST['complaintno']) . "'";
        }

        if (isset($_POST['status']) && $_POST['status'] !== '') {
            $condition .= " and status='" . $this->real_escape_string($_POST['status']) . "'";
        }

        if (isset($_POST['email']) && $_POST['email'] !== '') {
            $condition .= " and email='" . $this->real_escape_string($_POST['email']) . "'";
        }

        if (isset($_POST['contact_no']) && $_POST['contact_no'] !== '') {
            $condition .= " and contactno='" . $this->real_escape_string($_POST['contact_no']) . "'";
        }

        $selectData = mysql_query("select * from $this->plrs_complaint $condition $order") or die(mysql_error());
        if ($this->countTablerows($selectData) > 0) {
            while ($rows = mysql_fetch_assoc($selectData)) {
                $returnArr[] = $rows;
            }
            return $returnArr;
        }
        else {
            $this->setMessage('No Records Found.');
        }
    }

    public function getPLRSComplaintType($id = '', $orderby = false) {
        $returnArr = array();
        $condition = '';
        $order = '';
        if (trim($id) != '') {
            $condition = " where id='$id'";
        }

        if ($orderby) {
            $order = " order by id desc";
        }
        $selectData = mysql_query("select * from $this->plrs_complaint_type $condition $order") or die(mysql_error());
        if ($this->countTablerows($selectData) > 0) {
            while ($rows = mysql_fetch_assoc($selectData)) {
                $returnArr[] = $rows;
            }
            return $returnArr;
        }
        else {
            $this->setMessage('No Records Found.');
        }
    }

    public function getPLRSRemarks($id = '', $orderby = false) {
        $returnArr = array();
        $condition = '';
        $order = '';
        if (trim($id) != '') {
            $condition = " where complaint_id='$id'";
        }

        if ($orderby) {
            $order = " order by id desc";
        }
        $selectData = mysql_query("select * from $this->plrs_user_comment $condition $order") or die(mysql_error());
        if ($this->countTablerows($selectData) > 0) {
            while ($rows = mysql_fetch_assoc($selectData)) {
                $returnArr[] = $rows;
            }
            return $returnArr;
        }
        else {
            $this->setMessage('No Records Found.');
        }
    }

    public function addComplaint($edit = false) {
        if (!isset($_POST['auserSubmit'])) {
            return false;
        }

        $errors = array();
        if (!isset($_POST['caller']) && $_POST['caller'] == '') {
            $errors['caller'] = 'Caller field required.';
        }

        if (!isset($_POST['country_id']) && $_POST['country_id'] == '') {
            $errors['country_id'] = 'Country field required.';
        }

        if (!isset($_POST['cname']) && $_POST['cname'] == '') {
            $errors['cname'] = 'Name field required.';
        }

        if (!isset($_POST['cemail']) && $_POST['cemail'] == '') {
            $errors['cemail'] = 'Email field required.';
        }
        else {
            if (!filter_var($_POST['cemail'], FILTER_VALIDATE_EMAIL)) {
                $errors['cemail'] = 'Valid email required.';
            }
        }

        if (!isset($_POST['contactno']) && $_POST['contactno'] == '') {
            $errors['contactno'] = 'Contact No. field required.';
        }
        else {
            if (!is_numeric($_POST['contactno'])) {
                $errors['contactno'] = 'Valid contact no. required.';
            }
        }

        if (!isset($_POST['caddress']) && $_POST['caddress'] == '') {
            $errors['caddress'] = 'Address field required.';
        }

        if (!isset($_POST['city']) && $_POST['city'] == '') {
            $errors['city'] = 'City field required.';
        }

        if (array_key_exists('district', $_POST)) {
            if (!isset($_POST['district']) && $_POST['district'] == '') {
                $errors['district'] = 'District field required.';
            }
        }
        if (array_key_exists('tehsil', $_POST)) {
            if (!isset($_POST['tehsil']) && $_POST['tehsil'] == '') {
                $errors['tehsil'] = 'Tehsil field required.';
            }
        }
        if (array_key_exists('subtehsil', $_POST)) {
            if (!isset($_POST['subtehsil']) && $_POST['subtehsil'] == '') {
                $errors['subtehsil'] = 'Sub Tehsil field required.';
            }
        }

        if (array_key_exists('complainttype', $_POST)) {
            if (!isset($_POST['complainttype']) && $_POST['complainttype'] == '') {
                $errors['complainttype'] = 'Complaint type field required.';
            }
        }

        if (!isset($_POST['cdescription']) && $_POST['cdescription'] == '') {
            $errors['cdescription'] = 'Complaint Description field required.';
        }

        if (array_key_exists('transferred_to', $_POST)) {
            if (!isset($_POST['transferred_to']) && empty($_POST['transferred_to'])) {
                $errors['comp_remarks'] = 'Transferred to field required.';
            }
        }

        if (array_key_exists('comp_remarks', $_POST)) {
            if (!isset($_POST['comp_remarks']) && empty($_POST['comp_remarks'])) {
                $errors['comp_remarks'] = 'Complaint remarks field required.';
            }
        }

        if (array_key_exists('is_sms', $_POST)) {
            if (!isset($_POST['txt_content']) && empty($_POST['txt_content'])) {
                $errors['txt_content'] = 'Content field required.';
            }
        }

        if (array_key_exists('is_email', $_POST)) {
            if (!isset($_POST['txt_content']) && empty($_POST['txt_content'])) {
                $errors['txt_content'] = 'Content field required.';
            }
        }

        if (count($errors) == 0) {
            $emailFunc = $this->load_class_object('emailFunctions');

            $caller = $this->real_escape_string($_POST['caller']);
            $country_id = $this->real_escape_string($_POST['country_id']);
            $cname = $this->real_escape_string($_POST['cname']);
            $cemail = $this->real_escape_string($_POST['cemail']);
            $city = $this->real_escape_string($_POST['city']);
            $contactno = $this->real_escape_string($_POST['contactno']);
            $district = $this->real_escape_string($_POST['district']);
            $tehsil = $this->real_escape_string($_POST['tehsil']);
            $subtehsil = $this->real_escape_string($_POST['subtehsil']);
            $caddress = $this->real_escape_string($_POST['caddress']);
            if (array_key_exists('complainttype', $_POST)) {
                $complainttype = $this->real_escape_string($_POST['complainttype']);
            }
            $cdescription = $this->real_escape_string($_POST['cdescription']);
            $ticket_no = $this->getLastTicket();
            $created_by = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : '';
            $user_group = (isset($_SESSION['user_group'])) ? $_SESSION['user_group'] : '';
            $txt_content = '';
            $is_sms = '0';
            $is_email = '0';
            if (array_key_exists('is_sms', $_POST)) {
                $is_sms = $_POST['is_sms'];
                $txt_content = $_POST['txt_content'];
            }
            if (array_key_exists('is_email', $_POST)) {
                $is_email = $_POST['is_email'];
                $txt_content = $_POST['txt_content'];
            }
            $add_date = date('Y-m-d H:i:s');

            if ($edit === true) {
                $comp_id = $this->real_escape_string($_POST['compidu']);
                $complaintno = $this->real_escape_string($_POST['complaintno']);
                $remarks = $this->real_escape_string($_POST['comp_remarks']);

                if (isset($_POST['status']) && $_POST['status'] == '1' && ($_POST['comp_type'] == '1')) {

                    $status = $this->real_escape_string($_POST['status']);

                    $qry = mysql_query("UPDATE `$this->plrs_complaint` SET `status`='$status',`closed_by`='$created_by',`update_date`='$add_date' where `id` = '$comp_id'") or die(mysql_error());

                    if (is_a($emailFunc, 'emailFunctions')) {
                        $emailFieldarry = array($cname, $cemail, $complaintno);
                        $emailFunc->onComplaintClose($emailFieldarry);
                    }
                    $this->setSessionMessage('Complaint closed successfully.', 'success');
                    return true;
                }
                else if (isset($_POST['status']) && ($_POST['status'] == '2' || $_POST['status'] == '3' || $_POST['status'] == '4') && ($_POST['comp_type'] == '1')) {
                    if (array_key_exists('comp_remarks', $_POST)) {
                        if (isset($_POST['comp_remarks']) && !empty($_POST['comp_remarks'])) {
                            $qry_str = '';
                            mysql_query("INSERT INTO `$this->plrs_user_comment`(`created_by`, `user_group`, `complaint_id`, `remarks`, `is_open`, `add_date`) VALUES ('$created_by','$user_group','$comp_id','$remarks','" . $_POST['status'] . "','$add_date')") or die(mysql_error());

                            if (isset($_SESSION['transferred_to']) && isset($_POST['transferred_by_group']) && isset($_POST['transferred_to'])) {
                                $transferredtogrouparray = $this->select('tbl_usergroup', 'group_name', array('id' => $_SESSION['transferred_to']));
                                if (is_array($transferredtogrouparray) && count($transferredtogrouparray) > 0) {
                                    foreach ($transferredtogrouparray as $group_name) {
                                        $transferGroupname = $group_name['group_name'];
                                    }
                                }
                                $transferred_to = $this->real_escape_string($_POST['transferred_to']);
                                if ($_POST['transferred_by_group'] == 'Call Centre Staff' && $transferGroupname == 'Counsellor') {
                                    $qry_str = ", `callcenter_id` = '$created_by', `counseller_stateco_id` = '$transferred_to', `is_counseller` = '1'";
                                }
                                else if ($_POST['transferred_by_group'] == 'Call Centre Staff' && $transferGroupname == 'State Co-ordinator') {
                                    $qry_str = ", `callcenter_id` = '$created_by', `counseller_stateco_id` = '$transferred_to', `is_counseller` = '2'";
                                }
                                else if ($_POST['transferred_by_group'] == 'Counsellor' && $transferGroupname == 'SDM') {
                                    $qry_str = ", `counseller_stateco_id` = '$created_by', `sdm_id` = '$transferred_to'";
                                }
                                else if ($_POST['transferred_by_group'] == 'State Co-ordinator' && $transferGroupname == 'SDM') {
                                    $qry_str = ", `counseller_stateco_id` = '$created_by', `sdm_id` = '$transferred_to'";
                                }
                            }

                            $qry = mysql_query("UPDATE `$this->plrs_complaint` SET `status`='" . $_POST['status'] . "' $qry_str where `id` = '$comp_id'") or die(mysql_error());

                            $this->setSessionMessage('Complaint forwarded successfully.', 'success');
                            return true;
                        }
                        else {
                            $errors['comp_remarks'] = 'Complaint remarks field required.';
                            $this->setErrors($errors);
                            return false;
                        }
                    }
                    else {
                        return true;
                    }
                }
                else if (array_key_exists('comp_remarks', $_POST) && ($_POST['comp_type'] == '2' || $_POST['comp_type'] == '3' || $_POST['comp_type'] == '4')) {
                    if (isset($_POST['comp_remarks']) && !empty($_POST['comp_remarks'])) {
                        mysql_query("INSERT INTO `$this->plrs_user_comment`(`created_by`, `complaint_id`, `remarks`, `is_open`, `add_date`) VALUES ('$created_by','$comp_id','$remarks','1','$add_date')") or die(mysql_error());
                        $qry = mysql_query("UPDATE `$this->plrs_complaint` SET `status`='1' where `id` = '$comp_id'") or die(mysql_error());

                        if (is_a($emailFunc, 'emailFunctions')) {
                            $emailFieldarry = array($cname, $cemail, $complaintno, $remarks);
                            $emailFunc->onFeedback($emailFieldarry);
                        }
                        if ($_POST['comp_type'] == '2') {
                            $this->setSessionMessage('Feedback updated successfully.', 'success');
                        }
                        else if ($_POST['comp_type'] == '3' || $_POST['comp_type'] == '4') {
                            $this->setSessionMessage('Enquiry updated successfully.', 'success');
                        }
                        return true;
                    }
                    else {
                        $errors['comp_remarks'] = 'Complaint remarks field required.';
                        $this->setErrors($errors);
                        return false;
                    }
                }
                else {
                    return true;
                }
            }
            else {
                $insertQry = mysql_query("INSERT INTO `$this->plrs_complaint`(`name`, `email`, `contactno`, `address`, `city`, `district`, `tehsil`, `sub_tehsil`, `country`, `complaint_type`, `caller_type`, `ticket_no`, `complaint_remarks`, `created_by`, `add_date`, `status`) VALUES ('$cname','$cemail','$contactno','$caddress','$city','$district','$tehsil','$subtehsil','$country_id','$complainttype','$caller','$ticket_no','$cdescription','$created_by','$add_date','0')") or die(mysql_error());
                if ($insertQry) {
                    $emailFieldarry = array('cname' => $cname, 'cemail' => $cemail, 'ticket_no' => $ticket_no);
                    if ($is_sms !== '0' || $is_email !== '0') {
                        $last_insert_id = mysql_insert_id();
                        mysql_query("INSERT INTO `$this->plrs_sms_content`(`complaint_id`, `is_sms`,`is_email`, `content`, `add_date`) VALUES ('$last_insert_id','$is_sms','$is_email','$txt_content','$add_date')");
                        $emailFieldarry['txt_content'] = $txt_content;
                    }
                    if (is_a($emailFunc, 'emailFunctions')) {
                        $emailFunc->onComplaintRegistered($emailFieldarry);
                    }
                    $this->setSessionMessage('Complaint added successfully with Complaint No.' . $ticket_no, 'success');
                    return true;
                }
            }
        }
        else {
            $this->setErrors($errors);
            return false;
        }
    }

    public function getLastTicket() {
        $ticketNo = '';
        $sqlticket = mysql_query("SELECT ticket_no FROM $this->plrs_complaint ORDER BY id DESC LIMIT 1");
        if (mysql_num_rows($sqlticket) > 0) {
            $rowticket = mysql_fetch_array($sqlticket);
            $lastTicketNo = $rowticket['ticket_no'];
            $splitlastTicketNo = explode("PLRS", $lastTicketNo);
            $ticketDate = $splitlastTicketNo[0];
            $ticketNoAfterMN = $splitlastTicketNo[1];
            if ($ticketDate == date('ymd')) {
                $ticketNoAfterMN++;
                $ticketNoAfterMN = str_pad($ticketNoAfterMN, 4, "0", STR_PAD_LEFT); // Add 0 prefix to make 4 digit number
                $ticketNo = date('ymd') . 'PLRS' . $ticketNoAfterMN;
            }
            else {
                $ticketNo = date('ymd') . 'PLRS' . '0001';
            }
        }
        else {
            $ticketNo = date('ymd') . 'PLRS' . '0001';
        }
        return $ticketNo;
    }

    public function getuserComments($id = '') {
        $returnArr = array();
        $condition = '';
        if (trim($id) != '') {
            $condition = " where complaint_id='$id'";
        }
        $selectData = mysql_query("select * from $this->plrs_user_comment $condition") or die(mysql_error());
        if ($this->countTablerows($selectData) > 0) {
            while ($rows = mysql_fetch_assoc($selectData)) {
                $returnArr[] = $rows;
            }
            return $returnArr;
        }
        else {
            $this->setMessage('No Records Found.');
        }
    }

    public function commentUser($usergroup, $compid) {
        if ($usergroup != '') {
            $condition = '';
            if (trim($usergroup) != '' && trim($compid) != '') {
                $condition = " where user_group='$usergroup' and `complaint_id` = '$compid'";
            }
            $selectData = mysql_query("select user_group from $this->plrs_user_comment $condition") or die(mysql_error());
            if ($this->countTablerows($selectData) > 0) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function exportReport($dataArray) {
        if (is_array($dataArray) && count($dataArray) > 0) {
            $file_ending = "xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="ComplaintsReport.xls"');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $exportString = '';

            $exportString .= '<table border="1px solid">
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
                <tbody>';

            $userFunc = $this->load_class_object('userFunctions');


            $i = 1;
            foreach ($dataArray as $list) {

                $exportString .= '<tr>';
                $exportString .= '<td>' . $i . '</td>';
                $exportString .= '<td>' . $list['ticket_no'] . '</td>';
                $exportString .= '<td>' . $this->search_in_array($this->getCallerType(array('id' => $list['caller_type'])), 'caller_type') . '</td>';
                $exportString .= '<td>' . $this->search_in_array($this->getPLRSComplaintType($list['complaint_type']), 'complaint_type') . '</td>';
                $exportString .= '<td>' . $list['name'] . '</td>';
                $exportString .= '<td>' . $list['email'] . '</td>';
                $exportString .= '<td>' . $list['contactno'] . '</td>';
                $exportString .= '<td>' . $this->search_in_array($this->getDistricts(array('id' => $list['district'])), 'district_name') . '</td>';
                $exportString .= '<td>' . $this->search_in_array($this->getTehsils(array('id' => $list['tehsil'])), 'tehsil_name') . '</td>';
                $exportString .= '<td>' . $this->search_in_array($this->getSubTehsils(array('id' => $list['sub_tehsil'])), 'name') . '</td>';
                $exportString .= '<td>' . $userFunc->getUsername($list['created_by']) . '</td>';
                $exportString .= '<td>' . date('d-m-Y H:i:s', strtotime($list['add_date'])) . '</td>';
                $exportString .= (isset($list['status']) && ($list['status'] == 0)) ? '<td>Open</td>' : (($list['status'] == 1) ? '<td>Close</td>' : (($list['status'] == 2) ? '<td>Forwarded</td>' : (($list['status'] == 3) ? '<td>Assign / Under Process</td>' : '<td>Completed</td>')));
                $exportString .= '</tr>';
                $i++;
            }
        }
        else
            $exportString .= '<tr><td colspan="15" style="text-align:center">' . $this->getMessage() . '</td>';

        echo $exportString;
        exit();
    }

}
