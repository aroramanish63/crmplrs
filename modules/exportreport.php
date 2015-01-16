<?php 
if(!defined('BASE_PATH')) die('Access Denied.');
$commonObj->load_class('complaintFunctions');
$complaintFunc = new complaintFunctions();
$complaintFunc->getDatePickerJs();
$complaintFunc->getDatePicker('startDate', 'endDate');
?>
<script type="text/javascript">
    /**
 * Comment
 */
function validatereportfrm() {
    var complaint = document.getElementById('complaint');
    var startDate = document.getElementById('startDate');
    var endDate = document.getElementById('endDate');
    
    if(complaint.value == '' || complaint.value.replace(/\s+$/, '') == ''){
        alert('Please select Complaint.');
        complaint.focus();
        return false;
    }    
    if(startDate.value == '' || startDate.value.replace(/\s+$/, '') == ''){
        alert('Please select start date.');
        startDate.focus();
        return false;
    }
    if(endDate.value == '' || endDate.value.replace(/\s+$/, '') == ''){
        alert('Please select end date.');
        endDate.focus();
        return false;
    }
    window.reportfrm.submit();
}
</script>
<div class="container_12">
    <!-- Form elements -->  
                <?php 
                if($complaintFunc->getMessage()){
                    echo $complaintFunc->getMessage();
                }
                ?>                     
                <?php 
                if(count($complaintFunc->getErrors()) > 0){
                    echo '<span class="notification n-error">';
                    foreach($complaintFunc->getErrors() as $val){
                        echo $val;
                        echo '<br/>';
                    }
                    echo '</span>';
                }
                ?>
                <div class="module">
                     <h2><span>Report Export</span></h2>
                        
                     <div class="module-body">
                         <form action="export.php" method="post" name="reportfrm" id="reportfrm" enctype="multipart/form-data" onsubmit="return validatereportfrm();"> 
                             <p>
                                <label>Complaints <span class="red">*</span></label>
                                <select name="complaint" id="complaint" class="input-short" onchange="selectCtype(this);">
                                    <option value="">Select Complaints</option>
                                    <option value="dist">Distributor Complaints</option>
                                    <option value="retail">Retail Store Complaints</option>
                                </select>
                             </p> 
                             <div id="ctypediv_dist" style="display:none">
                                <p>
                                    <label>Complaint Type</label>
                                     <?php 
                                $complainttypearr = $complaintFunc->select($complaintFunc->complainttypeTable, array('id','complaint_type'), array('status'=>'1','distributor_complaint'=>'1'));   ?>
                                <select name="complaintType_dist" id="complaintType" class="input-short">
                                    <?php                                         
                                        if(is_array($complainttypearr) && count($complainttypearr) > 0){
                                            echo '<option value="all">All Complaint Type</option>';
                                            foreach($complainttypearr as $types){                                                
                                                echo '<option value="'.$types['id'].'">'.$types['complaint_type'].'</option>';
                                            }
                                        }
                                        else{
                                            echo '<option value="">Select Complaint Type</option>';
                                        }
                                    ?>
                                </select>
                                </p>                                
                            </div>
                            <div id="ctypediv_retail" style="display:none">
                                <p>
                                    <label>Complaint Type</label>
                                     <?php 
                                $complainttypearr = $complaintFunc->select($complaintFunc->complainttypeTable, array('id','complaint_type'), array('status'=>'1','consumer_complaint'=>'1'));   ?>
                                <select name="complaintType_retail" id="complaintType" class="input-short">
                                    <?php                                         
                                        if(is_array($complainttypearr) && count($complainttypearr) > 0){
                                            echo '<option value="all">All Complaint Type</option>';
                                            foreach($complainttypearr as $types){                                                
                                                echo '<option value="'.$types['id'].'">'.$types['complaint_type'].'</option>';
                                            }
                                        }
                                        else{
                                            echo '<option value="">Select Complaint Type</option>';
                                        }
                                    ?>
                                </select>
                                </p>                                
                            </div>
                            <div id="datediv">
                                <p>
                                    <label>From Date <span class="red">*</span></label>
                                    <input type="text" class="input-short" readonly="readonly" name="fromdate" id="startDate" />
                                </p>
                                <p>
                                    <label>To Date <span class="red">*</span></label>
                                    <input type="text" class="input-short" readonly="readonly" name="todate" id="endDate" />
                                </p>
                            </div>                            
                            <fieldset>
                                <input class="submit-green" type="submit" name="auserSubmit" value="Export" />                                 
                            </fieldset>
                        </form>
                     </div> <!-- End .module-body -->
                </div>  <!-- End .module -->
</div>
<script type="text/javascript">
function enableFilter(selid){
    if(selid != ''){        
        if($(selid).val() == 'date'){
            $('#datediv').css('display','block');
            $('#ctypediv').css('display','none');
        }
        else if($(selid).val() == 'ctype') {
            $('#datediv').css('display','none');
            if($('#complaint').val() != ''){
                if($('#complaint').val() == 'dist'){
                    $('#ctypediv_retail').css('display','none');
                    $('#ctypediv_dist').css('display','block');
                }
                else if($('#complaint').val() == 'retail'){
                        $('#ctypediv_retail').css('display','block');
                        $('#ctypediv_dist').css('display','none');
                }                
            }
            else{ 
                $(selid).val('');
                alert('select complaint.');
                return false;
            }
        }
    }
}
    
    function selectCtype(complaints){
        if($(complaints).val() != ''){
                if($(complaints).val() == 'dist'){
                    $('#ctypediv_retail').css('display','none');
                    $('#ctypediv_dist').css('display','block');
                }
                else if($(complaints).val() == 'retail'){
                        $('#ctypediv_retail').css('display','block');
                        $('#ctypediv_dist').css('display','none');
                }       
        }
        else{
                $('#ctypediv_retail').css('display','none');
                $('#ctypediv_dist').css('display','none');
        }
    }
</script>