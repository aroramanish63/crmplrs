<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');

$billFunc = $commonObj->load_class_object('billFunctions');

if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {   
    $billFunc->addBills();        
}
?>
<script type="text/javascript">
    /**
     * validate form
     */
    function validateuserfrm() {
		var verifier = document.getElementById('verifier');
                var bdescription = document.getElementById('bdescription');
                var attachphoto = document.getElementById('upload_bills');       

		if (verifier.value == '' || verifier.value.replace(/\s+$/, '') == '') {
            alert('Please select verifier.');
            verifier.focus();
            return false;
        }
		
        if (bdescription.value == '' || bdescription.value.replace(/\s+$/, '') == '') {
            alert('Please enter description.');
            bdescription.focus();
            return false;
        }
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
        window.abillfrm.submit();
    }

    function checkEmail(elementid) {
        var email = document.getElementById(elementid);
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(email.value)) {
            return false;
        }
        else {
            return true;
        }
    }
</script>
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
    <div class="module">
        <h2><span>Add Bill Form</span></h2>

        <div class="module-body">
            <form action="" onsubmit="return validateuserfrm();" method="post" name="abillfrm" id="abillfrm" enctype="multipart/form-data">
                <p>
                    <label>Select Verifier <span class="red">*</span></label>
                    <select name="verifier" id="verifier" class="input-short">
                        <option value="">Select Verifier</option>
                        <?php 
                            $resultSet = mysql_query("select * from `tbl_user` where `user_group` = '3'") or die(mysql_error());
                            if(mysql_num_rows($resultSet) > 0){
                                while ($row = mysql_fetch_assoc($resultSet)){
                                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <label>Bill Description <span class="red">*</span></label>
                    <textarea name="bdescription" class="input-short" id="bdescription"><?php echo (isset($_REQUEST['bdescription'])) ? $_REQUEST['bdescription'] : ''; ?></textarea>                                
                </p>
                <p>
                    <label>Upload Bills <span class="red">*</span></label>
                    <input type="file" name="upload_bills[]" id="upload_bills" multiple="multiple" />
                </p>                                                                                                                          
                <fieldset>
                    <input class="submit-green" type="submit" name="auserSubmit" value="Submit" /> 
                    <input class="submit-gray" type="reset" value="Cancel" />
                </fieldset>
            </form>
        </div> <!-- End .module-body -->
    </div>  <!-- End .module -->
</div>