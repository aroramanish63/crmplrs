<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');

$billFunc = $commonObj->load_class_object('billFunctions');
$userFunc = $billFunc->load_class_object('userFunctions');
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    if(isset($_POST['uploadsubmit']) && !empty($_POST['uploadsubmit'])){
        $billFunc->addMoreuploads();
    }
    else if(isset($_POST['threadsubmit']) && !empty($_POST['threadsubmit'])){
        $billFunc->addThreads();
    }
    else{
        $billFunc->addBillsComment();
	}
}

$details = '';
if(isset($_REQUEST['idu']) && trim($_REQUEST['idu']) != ''){
    $id = trim($_REQUEST['idu']);
    $details = $billFunc->getBillsListing($id);
}

$buttonName = ($billFunc->isApprover($_SESSION['uid'])) ? "Ask a Question" : "Reply" ;
?>
<script type="text/javascript">
    /**
     * validate form
     */
    function validateuserfrm() {
        var clearance_status = document.getElementById('clearance_status');
        var comments = document.getElementById('comments');       

        if (clearance_status.value == '' || clearance_status.value.replace(/\s+$/, '') == '') {
            alert('Please select clearance status.');
            clearance_status.focus();
            return false;
        }
		else{
			if(clearance_status.value == '6'){
				var paymentby = document.getElementById('paymentby');
				var paidamt = document.getElementById('paidamt');
				if (paymentby.value == '' || paymentby.value.replace(/\s+$/, '') == '') {
					alert('Please select payment by.');
					paymentby.focus();
					return false;
				}
				else{					
					if(paymentby.value == 'Cheque'){
						var ddno = document.getElementById('ddno');
						if (ddno.value == '' || ddno.value.replace(/\s+$/, '') == ''){
							alert('Please enter D.D. or Cheque No.');
							ddno.focus();
							return false;
						}
					}
				}
				
				if (paidamt.value == '' || paidamt.value.replace(/\s+$/, '') == '') {
					alert('Please enter amount.');
					paidamt.focus();
					return false;
				}
			}
		}
        
        if (comments.value == '' || comments.value.replace(/\s+$/, '') == '') {
            alert('Please enter comments.');
            comments.focus();
            return false;
        }
        
        window.commentfrm.submit();
    }
    
    /**
 * Function for validate thread form
 */
function validateThreadfrm() {
    var remarks = document.getElementById('remarks');  
    
        // if ($('input:radio[type=radio]:checked').length == 0){
            // alert('Ask from field required.');
            // return false;
        // }        
        if (remarks.value == '' || remarks.value.replace(/\s+$/, '') == '') {
            alert('<?php echo $buttonName; ?> field required.');
            remarks.focus();
            return false;
        }            
        window.threadfrm.submit();
}

function shownodiv(val){
	if(val != ''){
		if(val == 'Cheque'){
			document.getElementById('nodiv').style.display = 'block';			
		}
		else{
			document.getElementById('nodiv').style.display = 'none';			
		}
	}
	else{
		document.getElementById('nodiv').style.display = 'none';			
	}
}

function showpaymentdiv(status){
	if(status != ''){
		if(status == '6'){
			document.getElementById('paymentdiv').style.display = 'block';			
		}
		else{
			document.getElementById('paymentdiv').style.display = 'none';			
		}
	}
	else{
		document.getElementById('paymentdiv').style.display = 'none';			
	}
} 

function validateupload(){
	var attachphoto = document.getElementById('upload_bills');   
	if(attachphoto.value == '' || attachphoto.value.replace(/\s+$/, '') == ''){
            alert('Please select file for upload.');
			return false;
        }
        else{                    
            var re = /(\.jpg|\.jpeg|\.gif|\.bmp|\.png|\.pdf|\.doc|\.docx|\.xls|\.xlsx)$/i;
            if(!re.exec(attachphoto.value))
            {
                alert('Please upload images(.jpg,.jpeg,.gif,.bmp,.png), .pdf and document(.doc,.docx,.xls,.xlsx) extension file.');
                return false;
            }
        }
	window.uploadfrm.submit();
}
</script>
 
    <div id="fade" class="black_overlay"></div>
<div class="container_12">
    <!-- Form elements -->  
    <?php
    if ($billFunc->getMessage()) {
        echo $billFunc->getMessage();
    }
    ?>                     
    <?php
    if (count($billFunc->getErrors()) > 0) {
        echo '<span class="notification n-error">';
        foreach ($billFunc->getErrors() as $val) {
            echo $val;
            echo '<br/>';
        }
        echo '</span>';
    }
    ?>
    <?php echo ($billFunc->isAdmin($_SESSION['uid'])) ? '<input type="button" name="addMoreimages" id="addMoreimages" onclick = "document.getElementById(\'light\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'" class="submit-green" style="float:right; margin-bottom:10px;" value="Add more files" />' : ''; ?>    
   
    <div class="module">
        <h2><span>Edit Bill Form</span></h2>

        <div class="module-body">            
                <?php 
                    if(is_array($details) && $details != ''){
                             foreach($details as $detail){                                 
                            ?>					
                            <div id="light" class="white_content">
								<a style="float:right;position: relative;top: -15px;left: 16px;`" href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><img src="<?php echo IMAGE_URL.'cross-on-white.gif'; ?>"></a>
                                <form action="" name="uploadfrm" id="uploadfrm" method="post" enctype="multipart/form-data" onsubmit="return validateupload();">
                                    <p>
                                       <label>Upload Files <span class="red">*</span></label>
                                       <input type="file" name="upload_bills[]" id="upload_bills" multiple="multiple" />
                                   </p>
                                   <input type="hidden" name="clearanceid" id="clearanceid" value="<?php echo $detail['id']; ?>" />
                                   <input type="submit" class="submit-green" name="uploadsubmit" id="uploadsubmit" value="Submit" />
                                </form>
                            </div>
            
                <p>
                    <label>Bill Description <span class="red">*</span></label>
                    <textarea name="bdescription" disabled id="bdescription"><?php echo (isset($detail['bill_description'])) ? $detail['bill_description'] : ''; ?></textarea>                                
                </p>
                <p>
                    <label>Bill Created By <span class="red">*</span></label>
                    <?php $created_by =  (isset($detail['created_by'])) ? $detail['created_by'] : '';                     
                    ?>
                    <input type="text" class="input-short" name="created_by" id="created_by" disabled value="<?php echo $userFunc->getUsername($created_by); ?>" />
                </p>
				<p>
					<label>Bill Assigned To <span class="red">*</span></label>
					<?php $assigned_to =  (isset($detail['assigned_to'])) ? $detail['assigned_to'] : '';                     
					?>
					<input type="text" class="input-short" name="assigned_to" id="assigned_to" disabled value="<?php echo $userFunc->getUsername($assigned_to); ?>" />
				</p>
                <p>
                    <label>Previous Clearance Status <span class="red">*</span></label>                    
                    <input type="text" class="input-short" name="prev_status" id="prev_status" disabled value="<?php echo $billFunc->getClearanceStatusById($detail['clearance_status_id']); ?>" />
                </p>
                <?php $clearance_upload = $billFunc->getClearanceUpload($detail['id']);
                if(is_array($clearance_upload) && count($clearance_upload) > 0){
                ?>
                    <p>
                        <label>Clearance upload files <span class="red">*</span></label>
                    <table>
                        <?php  
                        $rowImg = 1;
                            foreach ($clearance_upload as $cupload){                             
                            echo ($rowImg == 1) ? '<tr>' : '';
                            
                            $imgtitle = str_replace( "uploads/docs/", '', $cupload['upload_file_path']);
                            if($billFunc->get_extension($cupload['upload_file_path']) == 'pdf'){                                
                                $imagepath = '<img src="'.IMAGE_URL.'iconpdf-download.jpg" title="'.$imgtitle.'">';
                            }
                            else if($billFunc->get_extension($cupload['upload_file_path']) == 'doc' || $billFunc->get_extension($cupload['upload_file_path']) == 'docx'){                                
                                $imagepath = '<img src="'.IMAGE_URL.'icon-worddoc.jpg" title="'.$imgtitle.'">';
                            }
                            else if($billFunc->get_extension($cupload['upload_file_path']) == 'xls' || $billFunc->get_extension($cupload['upload_file_path']) == 'xlsx'){                                
                                $imagepath = '<img src="'.IMAGE_URL.'icon-excel.jpg" title="'.$imgtitle.'">';
                            }
                            else{
                                $imagepath = '<img src="'.SITE_URL.$cupload['upload_file_path'].'" style="width:60px; height:60px;">';
                            }
                            ?>
                                    <td style="border-top: 1px solid #d9d9d9; border-bottom:  1px solid #d9d9d9; width:50px; text-align: center;"><a href="<?php echo SITE_URL.$cupload['upload_file_path'] ?>" target="_blank"><?php echo $imagepath; ?></a></td>
                        <?php   echo ($rowImg == 5) ? '</tr>' : ''; 
                                $rowImg++; 
                          
                          if($rowImg > 5){
                              $rowImg = 1;
                          }
                          
                            } ?>
                    </table>
                    </p>
                <?php } ?>
                    <?php $clearance_comments = $billFunc->getClearanceComments($detail['id']);
                if(is_array($clearance_comments) && count($clearance_comments) > 0){
                    $s_no = 1;
                ?>
                    <p>
                        <label>Clearance Comments <span class="red">*</span></label>
                    <table border="1">
                        <tr>
                            <th>S.No.</th>
                            <th>Created By</th>                            
                            <th>Bill Status</th>
                            <th>Comments</th>
                            <th>Comment Date</th>
                        </tr>
                        <?php                                                 
                            foreach ($clearance_comments as $comments){                             
                            ?>
                        <tr>
                                <td><?php echo $s_no; ?></td>
                                <td><?php echo $userFunc->getUsername($comments['created_by']); ?></td>                                
                                <td><?php echo $billFunc->getClearanceStatusById($comments['clearance_status']); ?></td>
                                <td><?php echo $comments['comments']; ?></td>
                                <td><?php echo date('d-m-Y',  strtotime($comments['add_date'])); ?></td>
                        </tr>
                        <?php $s_no++; } ?>
                    </table>
                    </p>
                <?php } ?>
                   <?php 				   
					if($billFunc->isApprover($_SESSION['uid']) || $billFunc->isThreadShow($_SESSION['uid'],$detail['id'])){
				   $threaddetails = $billFunc->viewThreads($detail['id']); 
                    if(is_array($threaddetails) && count($threaddetails) > 0){ ?>
                        <p>
                        <label>Bill Threads <span class="red">*</span></label>
                    <table border="1">
                        <tr>
                            <th>S.No.</th>
                            <th>Ask By</th>                                                        
                            <th>Remarks</th>							
                            <th>Remarks Date</th>							
                        </tr>
                        <?php 
							$no = 1;						
                            foreach ($threaddetails as $thread){                             
                            ?>
							<tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $userFunc->getUsername($thread['ask_by']); ?></td>                                
                                <td><?php echo $thread['remarks']; ?></td>                                								                             
                                <td><?php echo date('d-m-Y',  strtotime($comments['add_date'])); ?></td>								
							</tr>
                        <?php $no++; } ?>
                    </table>
                    </p>
                   <?php
				   }
				   }
                   ?>
				   
						<?php 				   							
								$paydetails = $billFunc->viewPaymentdetails($detail['id']); 
								if(is_array($paydetails) && count($paydetails) > 0){ ?>
								<p>
									<label>Bill Payment <span class="red">*</span></label>
									<table border="1">
										<tr>
											<th>Payment By</th>
											<th>D.D. / Cheque No.</th>                                                        
											<th>Amount</th>							
											<th>Payment Date</th>							
										</tr>
										<?php 																
											foreach ($paydetails as $pay){                             
											?>
											<tr>
												<td><?php echo $pay['paymentby']; ?></td>
												<td><?php echo ($pay['paymentby'] == 'Cheque') ? $pay['payment_no'] : '-'; ?></td>                                
												<td><?php echo $pay['amount']; ?></td>                                								                             
												<td><?php echo date('d-m-Y',  strtotime($pay['paymentdate'])); ?></td>								
											</tr>
										<?php } ?>
									</table>
								</p>
								<?php
								}							
						?>
				   
				   <div id="buttonDiv">
				   <?php                                    
                                   echo (($billFunc->isApprover($_SESSION['uid']) || ($billFunc->isThreadShow($_SESSION['uid'],$detail['id']) && (isset($detail['isThread']) && ($detail['isThread'] == 0))))) ? '<input type="button" name="askQues" id="askQues" value="'.$buttonName.'" class="submit-gray" onclick="showDiv(\'threadDiv\');" />' : '' ; ?>
                <?php 
                    if(!$billFunc->commentUser($_SESSION['user_group'],$detail['id']) && ($detail['status'] == 0) && (isset($_SESSION['uid']) && !$billFunc->isSuperAdmin($_SESSION['uid']))){
                ?>                    
                        <input type="button" name="updateStatus" id="updateStatus" value="Update Status" class="submit-green" onclick="showDiv('statusDiv');" />                        
                    </div>
                    <div id="statusDiv" style="display:none;">
                    <form action="" name="commentfrm" id="commentfrm" method="post" onsubmit="return validateuserfrm();">
                <p>
                    <label>Clearance Status <span class="red">*</span></label>
                    <select class="input-short" name="clearance_status" id="clearance_status" <?php echo ($billFunc->isFinance($_SESSION['uid'])) ? 'onchange="showpaymentdiv(this.value);"' : ''; ?>>
                        <option value="">Select clearance status</option>
                        <?php 
                        $clearanceArray =  $billFunc->getClearanceStatus(); 
                        $userClearance = '';
                        if(isset($_SESSION['clearance_status']) && !empty($_SESSION['clearance_status'])){
                            $userClearance = explode(',', $_SESSION['clearance_status']);
                        }
                        
                        if(is_array($clearanceArray) && count($clearanceArray) > 0){
                            $selected = '';
                            foreach($clearanceArray as $val){                                                                    
                                if(is_array($userClearance) && count($userClearance) > 0){
                                    if($detail['clearance_status_id'] != '' && ($val['id'] == $detail['clearance_status_id'])){
                                        $selected = 'selected = "selected"';
                                    }
                                    else{
                                        $selected = '';
                                    }
                                    if(in_array($val['id'], $userClearance) && ($val['id'] != $detail['clearance_status_id'])){
                                        echo '<option value="'.$val['id'].'" '.$selected.'>'.$val['clearance_type'].'</option>';
                                    }
                                }
                            }
                        }
                        
                        ?>
                    </select>
                </p>
				<div id="paymentdiv" style="display:none;">
					<p>
						<label>Payment By <span class="red">*</span></label>
						<select name="paymentby" id="paymentby" class="input-short" onchange="shownodiv(this.value);">
							<option value="">Select payment by</option>
							<option value="Cheque">Demand Draft/Cheque</option>
							<option value="Cash">Cash</option>
						</select>
					</p>
					<p id="nodiv" style="display:none;">
						<label>D.D. or Cheque No. <span class="red">*</span></label>
						<input type="text" name="ddno" id="ddno" class="input-short" />
					</p>
					<p>
						<label>Amount <span class="red">*</span></label>
						<input type="text" name="paidamt" id="paidamt" class="input-short" />
					</p>
				</div>
                <p>
                    <label>Comments <span class="red">*</span></label>
                    <textarea name="comments" class="input-short" id="comments"><?php echo (isset($_REQUEST['comments'])) ? $_REQUEST['comments'] : ''; ?></textarea>                                
                </p>
                <fieldset>
                    <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                    <input type="hidden" name="clearance_id" id="clearance_id" value="<?php echo $detail['id']; ?>" />
                    <input class="submit-gray" type="reset" value="Cancel" />
                </fieldset>
        </form>
                    <?php } ?>
                    </div>
                    <?php 							
					if($billFunc->isApprover($_SESSION['uid']) || ($billFunc->isThreadShow($_SESSION['uid'],$detail['id']) && isset($detail['isThread']) && ($detail['isThread'] == 0))){ ?>
                            <div id="threadDiv" style="display:none;">
                                <form action="" name="threadfrm" id="threadfrm" method="post" onsubmit="return validateThreadfrm();">                                    
                                    <p>
                                        <label><?php echo $buttonName; ?><span class="red">*</span></label>
                                        <textarea name="remarks" class="input-short" id="remarks"></textarea>                                
                                    </p>
                                    <input type="hidden" name="clearance_id" id="clearance_id" value="<?php echo $detail['id']; ?>" />
                                    <input type="submit" class="submit-green" class="input-short" name="threadsubmit" id="threadsubmit" value="Submit" />
                                </form>
                            </div>
                    <?php  } ?>                   
                             <?php } } ?>            
        </div> <!-- End .module-body -->
    </div>  <!-- End .module -->
    
  
</div>
    