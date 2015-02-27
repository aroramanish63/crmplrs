<?php

if (!defined('BASE_PATH'))
    exit('No direct script access allowed');

class userFunctions extends commonFxn {

    public function __construct() {

    }

    public function getUserdetail($uid) {
        if ($uid != '') {
            $returnArr = array();
            $selectUsers = mysql_query("select * from $this->userTable where id = '" . $uid . "'") or die(mysql_error());
            if ($this->countTablerows($selectUsers) > 0) {
                while ($rows = mysql_fetch_assoc($selectUsers)) {
                    $returnArr[] = $rows;
                }
                return $returnArr;
            }
            else {
                $this->setMessage('No Records Found.');
            }
        }
    }

    public function getUsername($uid) {
        if ($uid != '') {
            $returnArr = array();
            $selectUsers = mysql_query("select username from $this->userTable where id = '" . $uid . "'") or die(mysql_error());
            if ($this->countTablerows($selectUsers) > 0) {
                $rows = mysql_fetch_assoc($selectUsers);
                return $rows['username'];
            }
            else {
                $this->setMessage('No Records Found.');
            }
        }
    }

    public function getUserListingBySearch($poarray) {
        $returnArr = array();
        $condition = 'where 1';
        $order = '';
        if (!isset($poarray['btnsearch'])) {
            return false;
        }
        if (isset($poarray['uid']) && $poarray['uid'] !== '') {
            $condition .= " and id='" . $this->real_escape_string($poarray['uid']) . "'";
        }

        if (isset($poarray['u_group']) && $poarray['u_group'] !== '') {
            $condition .= " and user_group='" . $this->real_escape_string($poarray['u_group']) . "'";
        }

        if (isset($poarray['status']) && $poarray['status'] !== '') {
            $condition .= " and status='" . $this->real_escape_string($poarray['status']) . "'";
        }
        if (isset($poarray['email']) && $poarray['email'] !== '') {
            $condition .= " and email='" . $this->real_escape_string($poarray['email']) . "'";
        }
        if (isset($poarray['mobile']) && $poarray['mobile'] !== '') {
            $condition .= " and mobile_no='" . $this->real_escape_string($poarray['mobile']) . "'";
        }


        $selectData = mysql_query("select * from $this->userTable $condition $order") or die(mysql_error());
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

    public function getUserListing() {
        $returnArr = array();
        $selectUsers = mysql_query("select * from $this->userTable") or die(mysql_error());
        if ($this->countTablerows($selectUsers) > 0) {
            while ($rows = mysql_fetch_assoc($selectUsers)) {
                $returnArr[] = $rows;
            }
            return $returnArr;
        }
        else {
            $this->setMessage('No Records Found.');
        }
    }

    public function getUserGroup($uid = '') {
        $returnArr = array();
        $condition = '';
        if (trim($uid) != '') {
            $condition = " where id='$uid'";
        }
        $selectUsersgrp = mysql_query("select * from $this->userGrpTable $condition") or die(mysql_error());
        if ($this->countTablerows($selectUsersgrp) > 0) {
            while ($rows = mysql_fetch_assoc($selectUsersgrp)) {
                $returnArr[] = $rows;
            }
            return $returnArr;
        }
    }

    public function getUserRoles($uid = '') {
        $returnArr = array();
        $condition = '';
        if (trim($uid) != '') {
            $condition = " where id='$uid'";
        }
        $selectUsersrole = mysql_query("select * from $this->userRoleTable $condition") or die(mysql_error());
        if ($this->countTablerows($selectUsersrole) > 0) {
            while ($rows = mysql_fetch_assoc($selectUsersrole)) {
                $returnArr[] = $rows;
            }
            return $returnArr;
        }
        else {
            $this->setMessage('No Record Found');
        }
    }

    public function addUser($edit = false) {
        if (!isset($_POST['auserSubmit'])) {
            return false;
        }
        $errors = array();
        if ($_POST['ename'] == '') {
            $errors['ename'] = 'Name field required.';
        }
        if ($_POST['uname'] == '') {
            $errors['uname'] = 'Username field required.';
        }

        if ($edit != true) {
            if ($_POST['upassword'] == '') {
                $errors['upassword'] = 'Password field required.';
            }
            if ($_POST['cpassword'] == '') {
                $errors['cpassword'] = 'Confirm Password field required.';
            }
            if (trim($_POST['upassword']) != '' && trim($_POST['cpassword']) != '') {
                if ($_POST['cpassword'] != $_POST['upassword']) {
                    $errors['cpassword'] = 'Password not match.';
                }
            }
        }

        if ($_POST['ugroup'] == '') {
            $errors['ugroup'] = 'Usergroup field required.';
        }
        if ($_POST['email'] == '') {
            $errors['email'] = 'Email field required.';
        }
        else {
            if ($_POST['email'] != '') {
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Invalid email address.';
                }
            }
        }
        if ($_POST['mobile'] == '') {
            $errors['mobile'] = 'Mobile No. required.';
        }
        else if (!is_numeric($_POST['mobile'])) {
            $errors['mobile'] = 'Invalid Mobile No.';
        }

        if (count($errors) == 0) {
            $name = $this->real_escape_string($_POST['ename']);
            $uname = $this->real_escape_string($_POST['uname']);
            $address = $this->real_escape_string($_POST['address']);
            $ugroup = $this->real_escape_string($_POST['ugroup']);
            $email = $this->real_escape_string($_POST['email']);
            $mobile = $this->real_escape_string($_POST['mobile']);
            $add_date = date('Y-m-d H:i:s');
            if ($edit != true) {
                $password = md5($_POST['upassword']);
                $insertQry = mysql_query("INSERT INTO `$this->userTable`(`username`, `password`, `user_group`, `name`, `email`, `mobile_no`, `address`, `add_date`) VALUES ('$uname','$password','$ugroup','$name','$email','$mobile','$address','$add_date')") or die(mysql_error());
                $this->setSessionMessage('User created successfully', 'success');
                return true;
            }
            else {
                $uid = $this->real_escape_string($_POST['user_id']);
                $result = mysql_query("UPDATE `$this->userTable` SET `username` = '$uname', `user_group` = '$ugroup', `name` = '$name', `email` = '$email', `mobile_no` = '$mobile', `address` = '$address', `update_date` = '$add_date' where `id` = '$uid'") or die(mysql_error());
                if ($result) {
                    $this->setSessionMessage('User updated successfully', 'success');
                    return true;
                }
            }
        }
        else {
            $this->setErrors($errors);
            return false;
        }
    }

    public function addUserRole($edit = false) {

        if (!isset($_POST['auserSubmit'])) {
            return false;
        }
        $errors = array();
        if ($_POST['rname'] == '') {
            $errors['rname'] = 'Role name field required.';
        }
        if ($_POST['pname'] == '') {
            $errors['pname'] = 'Page name field required.';
        }
        if ($_POST['description'] == '') {
            $errors['description'] = 'Description field required.';
        }

        if (count($errors) == 0) {
            $rname = $this->real_escape_string($_POST['rname']);
            $pname = $this->real_escape_string($_POST['pname']);
            $description = $this->real_escape_string($_POST['description']);
            $add_date = date('Y-m-d H:i:s');
            if ($_POST['parentId'] != '') {
                $parentId = $this->real_escape_string($_POST['parentId']);
            }
            else {
                $parentId = 0;
            }

            if ($edit != true) {
                $insertQry = mysql_query("INSERT INTO `$this->userRoleTable`(`role_name`, `page_name`, `parentId`, `role_description`, `add_date`, `status`) VALUES ('$rname','$pname','$parentId','$description','$add_date','1')") or die(mysql_error());
                $this->setSessionMessage('User role created successfully', 'success');
                return true;
            }
            else {
                $role_id = isset($_POST['role_id']) ? $this->real_escape_string($_POST['role_id']) : '';
                if ($role_id != '') {
                    $update = mysql_query("Update `$this->userRoleTable` Set `role_name` = '$rname',`page_name` = '$pname',`parentId` = '$parentId',`role_description` = '$description' where `id` = '$role_id'") or die(mysql_error());
                    $this->setSessionMessage('User role updated successfully', 'success');
                    return true;
                }
                else {
                    $this->setMessage('Role id not found', 'error');
                    return false;
                }
            }
        }
        else {
            $this->setErrors($errors);
        }
    }

    public function addUserGroup($edit = false) {

        if (!isset($_POST['auserSubmit'])) {
            return false;
        }
        $errors = array();
        if ($_POST['gname'] == '') {
            $errors['gname'] = 'Group name field required.';
        }
        if ($_POST['group_level'] == '') {
            $errors['group_level'] = 'Group level field required.';
        }
        if ($_POST['description'] == '') {
            $errors['description'] = 'Description field required.';
        }
        if (!array_key_exists("transferred_to", $_POST)) {
            if (!isset($_POST['transferred_to']) && !is_array($_POST['transferred_to']) && count($_POST['transferred_to']) == 0) {
                $errors['transferred_to'] = 'Complaint Transferred required.';
            }
        }
        if (!array_key_exists("rolesid", $_POST)) {
//                if(!is_array($_POST['rolesid']) && count($_POST['rolesid']) == 0){
            $errors['roles'] = 'Assign roles required.';
//                }
        }


        if (count($errors) == 0) {
            $gname = $this->real_escape_string($_POST['gname']);
            $group_level = $this->real_escape_string($_POST['group_level']);
            $description = $this->real_escape_string($_POST['description']);
            $created_by = ($_SESSION['uid'] != '') ? $_SESSION['uid'] : 0;
            $roles = implode(',', $_POST['rolesid']);
            $transferred_to = implode(',', $_POST['transferred_to']);
            $created_date = date('Y-m-d');
            if ($edit != true) {
                mysql_query("INSERT INTO `$this->userGrpTable`(`group_name`, `group_description`, `role_id`, `transferred_to`, `level`, `created_by`, `created_date`) VALUES ('$gname','$description','$roles','$transferred_to','$group_level','$created_by','$created_date')") or die(mysql_error());
                $this->setSessionMessage('User group created successfully', 'success');
                return true;
            }
            else {
                $group_id = isset($_POST['group_id']) ? $this->real_escape_string($_POST['group_id']) : '';
                mysql_query("Update `$this->userGrpTable` Set `group_name` = '$gname',`group_description` = '$description',`role_id` = '$roles',`transferred_to` = '$transferred_to',`level` = '$group_level' where id = '$group_id'") or die(mysql_error());

                $this->setSessionMessage('User group updated successfully', 'success');
                return true;
            }
        }
        else {
            $this->setErrors($errors);
            return false;
        }
    }

    public function resetPassword() {
        if (!isset($_POST['auserSubmit'])) {
            return false;
        }
        $errors = array();
        if ($_POST['upassword'] == '') {
            $errors['upassword'] = 'Password field required.';
        }
        if ($_POST['cpassword'] == '') {
            $errors['cpassword'] = 'Confirm Password field required.';
        }
        if (trim($_POST['upassword']) != '' && trim($_POST['cpassword']) != '') {
            if ($_POST['cpassword'] != $_POST['upassword']) {
                $errors['cpassword'] = 'Password not match.';
            }
        }
        if (trim($_POST['uid']) && ($_POST['uid'] == '')) {
            $errors['uid'] = 'Invalid User.';
        }
        else {

        }
        if (count($errors) == 0) {
            $password = md5($_POST['upassword']);
            $uid = $_POST['uid'];
            $userDetail = $this->getUserdetail($uid);

            if (count($userDetail) > 0) {
                $pass_changed = $this->search_in_array($userDetail, 'pass_changed');
                $pass_changed++;
                $pass_modified_date = date('Y-m-d H:i:s');
                $result = mysql_query("UPDATE `$this->userTable` SET `password` = '$password',`pass_changed` = '$pass_changed',`pass_modified_date` = '$pass_modified_date' where `id` = '$uid'") or die(mysql_error());
                if ($result) {
                    $this->setSessionMessage('Password reset successfully', 'success');
                    return true;
                }
                else {
                    $this->setMessage('Some technical error password reset. Please try again later.', 'error');
                    return false;
                }
            }
            else {
                $this->setMessage('Invalid user', 'error');
                return false;
            }
        }
        else {
            $this->setErrors($errors);
            return false;
        }
    }

    public function updateUserprofile() {

        if (!isset($_POST['updateSubmit'])) {
            return false;
        }
        $errors = array();
        if ($_POST['ename'] == '') {
            $errors['ename'] = 'Name field required.';
        }
        if ($_POST['mobile'] == '') {
            $errors['mobile'] = 'Mobile field required.';
        }
        if ($_POST['address'] == '') {
            $errors['address'] = 'Address field required.';
        }

        if (count($errors) == 0) {
            $ename = $this->real_escape_string($_POST['ename']);
            $mobile = $this->real_escape_string($_POST['mobile']);
            $address = $this->real_escape_string($_POST['address']);
            $uid = $this->real_escape_string($_POST['uid']);
            $update_date = date('Y-m-d H:i:s');
            $updateQry = mysql_query("UPDATE `$this->userTable` SET `name`='$ename', `mobile_no`='$mobile',`address`='$address', `update_date`='$update_date' WHERE id = '$uid'") or die(mysql_error());
            $this->setMessage('User profile updated successfully', 'success');
        }
        else {
            $this->setErrors($errors);
        }
    }

    public function statusActiveInactive($uid) {
        if ($uid != '') {
            $st = ($this->getStatus($uid) == '0') ? '1' : '0';
            $status = mysql_query("Update $this->userTable Set `status` = '" . $this->real_escape_string($st) . "' where id = '" . $this->real_escape_string($uid) . "'") or die(mysql_error());
            if ($status) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function getStatus($uid) {
        if ($uid != '') {
            $status = mysql_query("select status from $this->userTable where id = '" . mysql_real_escape_string($uid) . "'") or die(mysql_error());
            if ($this->countTablerows($status) > 0) {
                $rows = mysql_fetch_assoc($status);
                return $rows['status'];
            }
            else {
                $this->setMessage('No Records Found.');
            }
        }
    }

}
