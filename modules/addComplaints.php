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
                    <legend><h3>Caller Information</h3></legend>
                    <p>
                        <label>Select Caller <span class="red">*</span></label>
                        <select name="caller" id="caller" class="input-short" onchange="getCallercountries(this.value, 'country');">
                            <option value="">Select Caller</option>
                            <?php
                            $selected = '';
                            $caller_type = $complaintFunc->getCallerType();
                            if (is_array($caller_type) && count($caller_type) > 0) {
                                foreach ($caller_type as $callers) {
                                    if (isset($_REQUEST['caller']) && ($callers['id'] === $_REQUEST['caller'])) {
                                        $selected = 'selected="selected"';
                                    }
                                    else {
                                        $selected = '';
                                    }
                                    echo '<option value="' . $callers['id'] . '" ' . $selected . '>' . $callers['caller_type'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </p>
                    <p>
                        <label>Select Country <span class="red">*</span></label>
                        <select name="country" disabled="disabled" id="country" class="input-short" onchange="document.getElementById('country_id').value = this.value;">
                            <option value="">Select Country</option>
                            <?php
                            $selected = '';
                            $countries = $complaintFunc->getCountries();
                            if (is_array($countries) && count($countries) > 0) {
                                foreach ($countries as $country) {

                                    if (isset($_REQUEST['country']) && ($country['id'] === $_REQUEST ['country'] )) {
                                        $selected = 'selected="selected"';
                                    }
                                    else {
                                        $selected = '';
                                    }
                                    echo '<option value="' . $country['id'] . '" ' . $selected . '>' . $country ['country_name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="country_id" id="country_id" value="" />
                    </p>
                </fieldset>
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
                            <p>
                                <label>Contact No. <span class="red">*</span></label>
                                <input type="text" name="contactno" class="input-short" maxlength="10" onkeypress="return checknum(event);" id="contactno" value="<?php echo (isset($_REQUEST['contactno'])) ? $_REQUEST['contactno'] : ''; ?>" />
                            </p>
                            <p>
                                <label>City <span class="red">*</span></label>
                                <input type="text" name="city" class="input-short" id="city" value="<?php echo (isset($_REQUEST['city'])) ? $_REQUEST['city'] : ''; ?>" />
                            </p>
                        </div>
                        <div class="rightsection">
                            <p>
                                <label>District <span class="red">*</span></label>
                                <select name="district" id="district" class="input-short" onchange="getTehsilbyAjax(this.value, 'tehsil', '<?php echo get_class($complaintFunc); ?>');">
                                    <option value="">Select District</option>
                                    <?php
                                    $selected = '';
                                    $district_list = $complaintFunc->getDistricts();
                                    if (is_array($district_list) && count($district_list) > 0) {
                                        foreach ($district_list as $district) {
                                            if (isset($_REQUEST['district']) && ($district['id'] === $_REQUEST['district'])) {
                                                $selected = 'selected="selected"';
                                            }
                                            else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . $district['id'] . '" ' . $selected . '>' . $district['district_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <label>Tehsil <span class="red">*</span></label>
                                <select name="tehsil" id="tehsil" class="input-short">
                                    <option value="">Select Tehsil</option>
                                    <?php
                                    $selected = '';
                                    $tehsil_list = $complaintFunc->getTehsils();
                                    if (is_array($tehsil_list) && count($tehsil_list) > 0) {
                                        foreach ($tehsil_list as $tehsil) {
                                            if (isset($_REQUEST['tehsil']) && ($tehsil['id'] === $_REQUEST['tehsil'])) {
                                                $selected = 'selected="selected"';
                                            }
                                            else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . $tehsil['id'] . '" ' . $selected . '>' . $tehsil['tehsil_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
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
                        <textarea name="cdescription" class="input-short" id="cdescription"><?php echo (isset($_REQUEST['cdescription'])) ? $_REQUEST['cdescription'] : ''; ?> </textarea>
                    </p>
                    <p>
                        <input type="checkbox" style="float: left;margin-right:5px;" name="is_sms" value="1" id="is_sms" onclick="document.getElementById('txt_content_p').style.display = 'block';" />
                        <label style="float: left;margin-right:10px;">SMS</label>
                        <input type="checkbox" style="float: left;margin-right:5px;" name="is_email" value="2" id="is_email" onclick="document.getElementById('txt_content_p').style.display = 'block';" />
                        <label style="float: left;">Email</label>
                    </p>
                    <div style="clear:both"></div>
                    <p id="txt_content_p" style="display:none;"><label>Content<span class="red">*</span></label><input type="text" class="input-short" name="txt_content" id="txt_content" /></p>
                </fieldset>
                <fieldset>
                    <!--<input class="submit-gray" type="button" value="Back" onclick="back();" />-->
                    <input class="submit-green" type="submit" name="auserSubmit" value="Submit" />
                </fieldset>
            </form>
        </div> <!-- End .module-body -->
    </div>  <!-- End .module -->
</div>