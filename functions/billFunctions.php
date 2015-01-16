<?php
if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

class billFunctions extends commonFxn{        
    
    public function __construct() {     
        
    }
    
    public function getClearanceStatus($id = ''){        
            $returnArr = array();
            $condition = '';
            if(trim($id) != ''){
                $condition = " where id='$id'";
            }
            $selectData = mysql_query("select * from $this->clearanceStatusTable $condition") or die(mysql_error());
            if($this->countTablerows($selectData) > 0){
                while($rows = mysql_fetch_assoc($selectData)){
                    $returnArr[] = $rows;
                }
                return $returnArr;
            }
            else{
                $this->setMessage('No Records Found.');
            }        
    }
    
    public function getClearanceStatusById($id = ''){        
            $returnArr = array();
            $condition = '';
            if(trim($id) != ''){
                $condition = " where id='$id'";
            }
            $selectData = mysql_query("select clearance_type from $this->clearanceStatusTable $condition") or die(mysql_error());
            if($this->countTablerows($selectData) > 0){
                $rows = mysql_fetch_assoc($selectData);
                return $rows['clearance_type'];
            }
            else{
                $this->setMessage('No Records Found.');
            }        
    }
    
    public function getClearanceUpload($id = ''){        
            $returnArr = array();
            $condition = '';
            if(trim($id) != ''){
                $condition = " where clearance_id='$id'";
            }
            $selectData = mysql_query("select * from $this->clearanceUploadTable $condition") or die(mysql_error());
            if($this->countTablerows($selectData) > 0){
                while($rows = mysql_fetch_assoc($selectData)){
                    $returnArr[] = $rows;
                }
                return $returnArr;
            }
            else{
                $this->setMessage('No Records Found.');
            }        
    }
    
    public function getClearanceComments($id = ''){        
            $returnArr = array();
            $condition = '';
            if(trim($id) != ''){
                $condition = " where clearance_id='$id'";
            }
            $selectData = mysql_query("select * from $this->clearanceCommentTable $condition") or die(mysql_error());
            if($this->countTablerows($selectData) > 0){
                while($rows = mysql_fetch_assoc($selectData)){
                    $returnArr[] = $rows;
                }
                return $returnArr;
            }
            else{
                $this->setMessage('No Records Found.');
            }        
    }

        public function getBillsListing($id=''){
			$returnArr = array();
            $condition = '';
            if(trim($id) != ''){
                $condition = " where id='$id'";
            }
            $selectData = mysql_query("select * from $this->clearanceBillsTable $condition order by id desc") or die(mysql_error());
            if($this->countTablerows($selectData) > 0){
                while($rows = mysql_fetch_assoc($selectData)){
                    $returnArr[] = $rows;
                }
                return $returnArr;
            }
            else{
                $this->setMessage('No Records Found.');
            } 
    }  

	public function getBillsListingbyStatus($statusid=''){
		$returnArr = array();
		$condition = '';
		if(trim($statusid) != ''){
			$condition = " where clearance_status_id='$statusid'";
		}
		$selectData = mysql_query("select * from $this->clearanceBillsTable $condition order by id desc") or die(mysql_error());
		if($this->countTablerows($selectData) > 0){
			while($rows = mysql_fetch_assoc($selectData)){
				$returnArr[] = $rows;
			}
			return $returnArr;
		}
		else{
			$this->setMessage('No Records Found.');
		} 
    }
    
    public function commentUser($usergroup,$clearanceid){
        if($usergroup != ''){            
            $condition = '';
            if(trim($usergroup) != '' && trim($clearanceid) != ''){
                $condition = " where user_group='$usergroup' and `clearance_id` = '$clearanceid'";
            }
            $selectData = mysql_query("select user_group from $this->clearanceCommentTable $condition") or die(mysql_error());
            if($this->countTablerows($selectData) > 0){
                return true;
            }
            else{
                return false;
            }
        }
    }
    
    public function addBills(){                 
            if(!isset($_POST['auserSubmit'])){
                return false;
            }
            $errors = array();
            if(!isset($_POST['verifier']) && $_POST['verifier'] == ''){
                $errors['verifier'] = 'Verifier field required.';
            }
            
            if(!isset($_POST['bdescription']) && $_POST['bdescription'] == ''){
                $errors['bdescription'] = 'Description field required.';
            }
            
            if($this->is_array_empty($_FILES['upload_bills']['name'])){
                $errors['upload_bills'] = 'Upload bills required.';
            }            
            if(count($errors) == 0){
                $emailFunc = $this->load_class_object('emailFunctions');
                $verifier = $this->real_escape_string($_POST['verifier']);
                $bdescription = $this->real_escape_string($_POST['bdescription']);
                $created_by = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : '';
                $user_group = (isset($_SESSION['user_group'])) ? $this->real_escape_string($_SESSION['user_group']) : '';
                $clearance_status_id = '1';
                $last_bill_id = '';
                $add_date = date('Y-m-d H:i:s');                                    
                    $insertQry = mysql_query("INSERT INTO `$this->clearanceBillsTable`(`created_by`, `assigned_to`, `bill_description`, `clearance_status_id`, `create_date`, `status`) VALUES ('$created_by','$verifier','$bdescription','$clearance_status_id','$add_date','0')") or die(mysql_error());
                    $last_bill_id = mysql_insert_id();
                    if($last_bill_id != ''){                                
                                foreach($_FILES['upload_bills']['tmp_name'] as $key => $tmp_name ){
                                        $file_name = $key.$_FILES['upload_bills']['name'][$key];
                                        $file_tmp =$_FILES['upload_bills']['tmp_name'][$key];                                                                                        
                                        $upload_dir = PHOTO_UPLOAD_DIRECTORY;                                        
                                        if (!is_dir($upload_dir)) {
                                                mkdir($upload_dir, 0777);
                                        }
                                        $upload = false;
                                        $uploadfilename = '';
                                        if ($file_name != '' && is_uploaded_file($file_tmp)) {
                                                if (in_array($this->get_extension($file_name), $this->extensionarr)) {
                                                        $uploadfilename = $upload_dir . date('YmdHis').'_'.$file_name;
                                                        if (move_uploaded_file($file_tmp, $uploadfilename)){
                                                               $upload = true;
                                                         }
                                                }
                                                else {			
                                                        $errors['upload_bills'] = 'Invalid file type.'; 
                                                }
                                        }
                                        else{
                                            $errors['upload_bills'] = 'Invalid Files.';
                                        }

                                         if(count($errors) == 0 && ($upload == true)){                                             
                                             $insertQry = mysql_query("INSERT INTO `$this->clearanceUploadTable`(`clearance_id`, `upload_file_path`, `add_date`, `status`) VALUES ('$last_bill_id','$uploadfilename','$add_date','1')") or die(mysql_error());                                                                                                                                                                                      
//                                             return true;
                                         }
                                         else{
                                              $this->setErrors($errors);
//                                              return false;
                                         }
                            }
                            $emailFunc->saveMailbeforeSend(3); 
                            $insertQry = mysql_query("INSERT INTO `$this->clearanceCommentTable`(`created_by`, `user_group`, `clearance_id`, `clearance_status`, `comments`, `add_date`) VALUES ('$created_by','$user_group','$last_bill_id','$clearance_status_id','$bdescription','$add_date')") or die(mysql_error()); 
                            $this->setMessage('Bill added successfully', 'success');
                    }                    
             }
             else{                 
                 $this->setErrors($errors);
//                 return false;
             }        
    }
    
	public function addBillsComment(){                 
		if(!isset($_POST['auserSubmit'])){
			return false;
		}
		$errors = array();
		if(!isset($_POST['clearance_status']) && $_POST['clearance_status'] == ''){
			$errors['clearance_status'] = 'Clearance status field required.';
		}
		else{
			if(trim($_POST['clearance_status']) == '6'){
				if(!isset($_POST['paymentby']) && $_POST['paymentby'] == ''){
					$errors['paymentby'] = 'Payment by field required.';
				}
				else{
					if(trim($_POST['paymentby']) == 'Cheque'){
						if(!isset($_POST['ddno']) && $_POST['ddno'] == ''){
							$errors['ddno'] = 'D.D no or Cheque no. field required.';
						}
					}	
				}
				if(!isset($_POST['paidamt']) && $_POST['paidamt'] == ''){
					$errors['paidamt'] = 'Amount field required.';
				}				
			}
		}
		
		if(!isset($_POST['comments']) && $_POST['comments'] == ''){
			$errors['comments'] = 'Clearance comments field required.';
		}
		
		if(count($errors) == 0){
			$emailFunc = $this->load_class_object('emailFunctions');        
			$clearance_status = $this->real_escape_string($_POST['clearance_status']);
			$comments = $this->real_escape_string($_POST['comments']);
			$clearance_id = $this->real_escape_string($_POST['clearance_id']);
			$user_group = (isset($_SESSION['user_group'])) ? $this->real_escape_string($_SESSION['user_group']) : '';
			$created_by = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : '';                             
			$add_date = date('Y-m-d H:i:s');                                    
			$threadStatus = '0';
			$insertQry = mysql_query("INSERT INTO `$this->clearanceCommentTable`(`created_by`, `user_group`, `clearance_id`, `clearance_status`, `comments`, `add_date`) VALUES ('$created_by','$user_group','$clearance_id','$clearance_status','$comments','$add_date')") or die(mysql_error());                    
			if($clearance_status == '6' || $clearance_status == '5' || $clearance_status == '3'){
				$status = '1';
				$threadStatus = '1';
			}
			else{
				$status = '0';				
				if($clearance_status == '2'){
					$threadStatus = '1';
					$emailFunc->saveMailbeforeSend(4);
				}
				else if($clearance_status == '4'){
					$threadStatus = '1';
					$emailFunc->saveMailbeforeSend(5);
				}
			}
			
			if($clearance_status == '6'){
				$paymentby = $this->real_escape_string($_POST['paymentby']);
				$ddno = (isset($_POST['ddno'])) ? $this->real_escape_string($_POST['ddno']) : '';
				$paidamt = $this->real_escape_string($_POST['paidamt']);				
				$insertPayment = mysql_query("INSERT INTO `$this->clearancePaymentTable`(`clearance_id`, `paymentby`, `payment_no`, `amount`, `paymentdate`) VALUES ('$clearance_id','$paymentby','$ddno','$paidamt','$add_date')") or die(mysql_error());
			}			
			$clearance_update = mysql_query("Update `$this->clearanceBillsTable` Set `clearance_status_id` = '$clearance_status', `update_date` = '$add_date', `status` = '$status', `isThread` = '$threadStatus' where `id` = '$clearance_id'") or die(mysql_error());
			$this->setMessage('Comment added successfully', 'success');       
		}
		else{                  
			$this->setErrors($errors);
		}        
    }
    
    public function addMoreuploads(){
        if(!isset($_POST['uploadsubmit'])){
                return false;
            }
            $errors = array();           
            if($this->is_array_empty($_FILES['upload_bills']['name'])){
                $errors['upload_bills'] = 'Upload bills required.';
            }
	
            if(count($errors) == 0){             
                $clearanceid = $this->real_escape_string($_POST['clearanceid']);
                $created_by = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : '';                             
                $add_date = date('Y-m-d H:i:s'); 
                
                foreach($_FILES['upload_bills']['tmp_name'] as $key => $tmp_name ){
                                        $file_name = $key.$_FILES['upload_bills']['name'][$key];
                                        $file_tmp =$_FILES['upload_bills']['tmp_name'][$key];                                                                                        
                                        $upload_dir = PHOTO_UPLOAD_DIRECTORY;                                        
                                        if (!is_dir($upload_dir)) {
                                                mkdir($upload_dir, 0777);
                                        }
                                        $upload = false;
                                        $uploadfilename = '';
                                        if ($file_name != '' && is_uploaded_file($file_tmp)) {
                                                if (in_array($this->get_extension($file_name), $this->extensionarr)) {
                                                        $uploadfilename = $upload_dir . date('YmdHis').'_'.$file_name;
                                                        if (move_uploaded_file($file_tmp, $uploadfilename)){
                                                               $upload = true;
                                                         }
                                                }
                                                else {			
                                                        $errors['upload_bills'] = 'Invalid file type.'; 
                                                }
                                        }
                                        else{
                                            $errors['upload_bills'] = 'Invalid Files.';
                                        }

                                         if(count($errors) == 0 && ($upload == true)){                                             
                                             $insertQry = mysql_query("INSERT INTO `$this->clearanceUploadTable`(`clearance_id`, `upload_file_path`, `add_date`, `status`) VALUES ('$clearanceid','$uploadfilename','$add_date','1')") or die(mysql_error());                                                                                                                                                                                      
                                         }
                                         else{
                                              $this->setErrors($errors);
                                         }
                            }
                
                $this->setMessage('Bills uploaded successfully', 'success');       
             }
             else{                 
                 $this->setErrors($errors);
             } 
    }
    
    public function addThreads(){        
        if(!isset($_POST['threadsubmit'])){
                return false;
            }
            
            $errors = array();                        
            
			if(!isset($_POST['remarks']) && trim($_POST['remarks']) == ''){
				$errors['remarks'] = 'Ask Question field required.';
			}
                        
            if(count($errors) == 0){                              
                $remarks = $this->real_escape_string($_POST['remarks']);
                $clearance_id = $this->real_escape_string($_POST['clearance_id']);                
                $created_by = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : '';                             
                $add_date = date('Y-m-d H:i:s');                                    
                    $insertQry = mysql_query("INSERT INTO `$this->clearanceQuesTable`(`clearance_id`, `ask_by`, `remarks`, `add_date`) VALUES ('$clearance_id','$created_by','$remarks','$add_date')") or die(mysql_error());                                        
					$updateQry = mysql_query("Update `$this->clearanceBillsTable` Set `isThread` = '0' where `id` = '$clearance_id'") or die(mysql_error());
                    $this->setMessage('Threads added successfully', 'success');       
             }
             else{                 
                 $this->setErrors($errors);
             }
    }
    
    public function viewThreads($clearanceId){
        if($clearanceId != ''){
            $returnArray = array();
            $resultSet = mysql_query("select * from `$this->clearanceQuesTable` where clearance_id = '$clearanceId'") or die(mysql_error());
            if(mysql_num_rows($resultSet) > 0){
                while($row = mysql_fetch_assoc($resultSet)){
                        $returnArray[] = $row;
                }
                return $returnArray;
            }
            else{
                $this->setMessage('No Record Found');
            }
        }
    }
	
	public function viewPaymentdetails($clearanceId){
        if($clearanceId != ''){
            $returnArray = array();
            $resultSet = mysql_query("select * from `$this->clearancePaymentTable` where clearance_id = '$clearanceId'") or die(mysql_error());
            if(mysql_num_rows($resultSet) > 0){
                while($row = mysql_fetch_assoc($resultSet)){
					$returnArray[] = $row;
                }
                return $returnArray;
            }
            else{
                $this->setMessage('No Record Found');
            }
        }
    }
	
	public function isThreadShow($userId,$clearanceId){
		if($userId != '' && $clearanceId != ''){			
			$resultSet = mysql_query("select * from `$this->clearanceBillsTable` where `created_by` = '$userId' and id = '$clearanceId'") or die(mysql_error());
			if(mysql_num_rows($resultSet) > 0){
                return true;
            }
			else{
				$resultSet1 = mysql_query("select * from `$this->clearanceBillsTable` where `assigned_to` = '$userId' and id = '$clearanceId'") or die(mysql_error());
				if(mysql_num_rows($resultSet1) > 0){
					return true;
				}
				else{
					return false;
				}
			}
				
		}
	}
       
}
