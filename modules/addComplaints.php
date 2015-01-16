<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');

$complaintFunc = $commonObj->load_class_object('complaintFunctions');

if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    if ($complaintFunc->addComplaint()) {
        $complaintFunc->redirectUrl('viewComplaints');
    }
}
?>
<script type="text/javascript">
    /**
     * function for go to back page
     */
    function back() {
        window.location = '<?php echo SITE_URL ?>?page=viewComplaints';
    }
</script>
<style type="text/css">
    .leftsection{
        width: 40%;
        float: left;

    }
    .leftsection .input-short, .rightsection .input-short { width: 70% !important; }
    .rightsection{
        width: 40%;
        float: right;

    }
</style>
<div class="container_12">
    <!-- Form elements -->
    <?php
    if (count($complaintFunc->getErrors()) > 0) {
        echo '<span class="notification n-error">';
        foreach ($complaintFunc->getErrors() as $val) {
            echo $val;
            echo '<br/>';
        }
        echo '</span>';
    }
    ?>
    <div class="module">
        <h2><span>Add Complaint</span></h2>

        <div class="module-body">
            <form action="" onsubmit="return validatecomplaintfrm();" method="post" name="abillfrm" id="abillfrm">
                <fieldset>
                    <legend><h3>Personal Information</h3></legend>
                    <div class="mainsection">
                        <div class="leftsection">
                            <p>
                                <label>Name <span class="red">*</span></label>
                                <input type="text" name="cname" class="input-short" id="cname" value="<?php echo (isset($_REQUEST['cname'])) ? $_REQUEST['cname'] : ''; ?>" />
                            </p>
                            <p>
                                <label>Email <span class="red">*</span></label>
                                <input type="text" name="cemail" class="input-short" id="cemail" value="<?php echo (isset($_REQUEST['cemail'])) ? $_REQUEST['cemail'] : ''; ?>" />
                            </p>
                        </div>
                        <div class="rightsection">
                            <p>
                                <label>Contact No. <span class="red">*</span></label>
                                <input type="text" name="contactno" class="input-short" maxlength="10" onkeypress="return checknum(event);" id="contactno" value="<?php echo (isset($_REQUEST['contactno'])) ? $_REQUEST['contactno'] : ''; ?>" />
                            </p>
                            <p>
                                <label>Address <span class="red">*</span></label>
                                <textarea name="caddress" class="input-short" id="caddress"><?php echo (isset($_REQUEST['caddress'])) ? $_REQUEST['caddress'] : ''; ?></textarea>
                            </p>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend><h3>Complaint Information</h3></legend>
                    <p>
                        <label for="fromdate">Complaint Type <span class="red">*</span></label>
                        <select name="complainttype" id="complainttype" class="input-short">
                            <option value="">Select Complaint type</option>
                            <?php
                            $selected = '';
                            $complaint_type = $complaintFunc->getPLRSComplaintType();
                            if (is_array($complaint_type) && count($complaint_type) > 0) {
                                foreach ($complaint_type as $type) {
                                    if (isset($_REQUEST['complainttype']) && ($type['id'] === $_REQUEST['complainttype'])) {
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
                    </p>
                    <p>
                        <label>Complaint Description <span class="red">*</span></label>
                        <textarea name="cdescription" class="input-short" id="cdescription"><?php echo (isset($_REQUEST['cdescription'])) ? $_REQUEST['cdescription'] : ''; ?></textarea>
                    </p>
                </fieldset>
                <fieldset>
                    <input class="submit-gray" type="button" value="Back" onclick="back();" />
                    <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                </fieldset>
            </form>
        </div> <!-- End .module-body -->
    </div>  <!-- End .module -->
</div>