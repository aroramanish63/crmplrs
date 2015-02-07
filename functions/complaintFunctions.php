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

        if (!isset($_POST['city']) && $_POST['city'] == '') {
            $errors['city'] = 'City field required.';
        }

        if (!isset($_POST['contactno']) && $_POST['contactno'] == '') {
            $errors['contactno'] = 'Contact No. field required.';
        }
        else {
            if (!is_numeric($_POST['contactno'])) {
                $errors['contactno'] = 'Valid contact no. required.';
            }
        }

        if (!isset($_POST['district']) && $_POST['district'] == '') {
            $errors['district'] = 'District field required.';
        }

        if (!isset($_POST['tehsil']) && $_POST['tehsil'] == '') {
            $errors['tehsil'] = 'Tehsil field required.';
        }

        if (!isset($_POST['caddress']) && $_POST['caddress'] == '') {
            $errors['caddress'] = 'Address field required.';
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

                    $qry = mysql_query("UPDATE `$this->plrs_complaint` SET `status`='$status' where `id` = '$comp_id'") or die(mysql_error());

                    if (is_a($emailFunc, 'emailFunctions')) {
                        $emailFieldarry = array($cname, $cemail, $complaintno);
                        $emailFunc->onComplaintClose($emailFieldarry);
                    }
                    $this->setSessionMessage('Complaint closed successfully.', 'success');
                    return true;
                }
                else if (isset($_POST['status']) && ($_POST['status'] == '0') && ($_POST['comp_type'] == '1')) {
                    if (array_key_exists('comp_remarks', $_POST)) {
                        if (isset($_POST['comp_remarks']) && !empty($_POST['comp_remarks'])) {
                            $qry_str = '';
                            mysql_query("INSERT INTO `$this->plrs_user_comment`(`created_by`, `user_group`, `complaint_id`, `remarks`, `is_open`, `add_date`) VALUES ('$created_by','$user_group','$comp_id','$remarks','" . $_POST['status'] . "','$add_date')") or die(mysql_error());
                            if (isset($_POST['transferred_by_group']) && isset($_POST['transferred_to']) && ($_POST['transferred_by_group'] == 'Counsellor')) {
                                $is_counseller = 1;
                                $transferred_to = $this->real_escape_string($_POST['transferred_to']);
                                $qry_str = ", `counseller_stateco_id` = '$created_by', `case_cordinator_id` = '$transferred_to', `is_counseller` = '$is_counseller'";
                            }
                            else if (isset($_POST['transferred_by_group']) && ($_POST['transferred_by_group'] == 'State Co-ordinator')) {
                                $is_counseller = 2;
                                $transferred_to = $this->real_escape_string($_POST['transferred_to']);
                                $qry_str = ", `counseller_stateco_id` = '$created_by', `case_cordinator_id` = '$transferred_to', `is_counseller` = '$is_counseller'";
                            }
                            else if (isset($_POST['transferred_by_group']) && ($_POST['transferred_by_group'] == 'Case Co-ordinator')) {
                                $transferred_to = $this->real_escape_string($_POST['transferred_to']);
                                $qry_str = ", `case_cordinator_id` = '$created_by', `sdm_id` = '$transferred_to'";
                            }

                            $qry = mysql_query("UPDATE `$this->plrs_complaint` SET `status`='0' $qry_str where `id` = '$comp_id'") or die(mysql_error());

                            $this->setSessionMessage('Complaint updated successfully.', 'success');
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
                else if (array_key_exists('comp_remarks', $_POST) && ($_POST['comp_type'] == '2')) {
                    if (isset($_POST['comp_remarks']) && !empty($_POST['comp_remarks'])) {
                        mysql_query("INSERT INTO `$this->plrs_user_comment`(`created_by`, `complaint_id`, `remarks`, `is_open`, `add_date`) VALUES ('$created_by','$comp_id','$remarks','1','$add_date')") or die(mysql_error());
                        $qry = mysql_query("UPDATE `$this->plrs_complaint` SET `status`='1' where `id` = '$comp_id'") or die(mysql_error());

                        if (is_a($emailFunc, 'emailFunctions')) {
                            $emailFieldarry = array($cname, $cemail, $complaintno, $remarks);
                            $emailFunc->onFeedback($emailFieldarry);
                        }
                        $this->setSessionMessage('Feedback updated successfully.', 'success');
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
                $insertQry = mysql_query("INSERT INTO `$this->plrs_complaint`(`name`, `email`, `contactno`, `address`, `city`, `district`, `tehsil`, `country`, `complaint_type`, `caller_type`, `ticket_no`, `complaint_remarks`, `created_by`, `add_date`, `status`) VALUES ('$cname','$cemail','$contactno','$caddress','$city','$district','$tehsil','$country_id','$complainttype','$caller','$ticket_no','$cdescription','$created_by','$add_date','0')") or die(mysql_error());
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
                    $this->setSessionMessage('Complaint added successfully', 'success');
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

}
