<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$commonObj->load_class('userFunctions');
$userFunc = new userFunctions();
?>
<style type="text/css">
    .input-short{
        width:19%;
    }
</style>
<div class="container_12">
    <?php
    $Adduserbtn = '<a title="Add User" href="' . SITE_URL . '?page=addUser"><input class="submit-green" style="float:right" type="button" value="Add" /></a>';
    ?>
    <div class="bottom-spacing">
        <div>
            <form name="searchfrm" id="searchfrm" method="post" action="" onsubmit="return validatefilter();">
                <p>
                    <label style="float:left;margin-right: 10px;" for="u_group">User Group: </label>&nbsp;&nbsp;
                    <select name="u_group" id="u_group" class="input-short" style="float:left;margin-right: 10px">
                        <option value="">Select User Group</option>
                        <?php
                        $selected = '';
                        $u_group = $userFunc->getUserGroup();
                        if (is_array($u_group) && count($u_group) > 0) {
                            foreach ($u_group as $type) {
                                if (isset($_REQUEST['u_group']) && ($type['id'] === $_REQUEST['u_group'])) {
                                    $selected = 'selected="selected"';
                                }
                                else {
                                    $selected = '';
                                }
                                echo '<option value="' . $type['id'] . '" ' . $selected . '>' . $type['group_name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label style="float:left;margin-right: 10px;">User Status.:</label>
                    <select style="float:left;margin-right: 10px;" name="status" id="status" class="input-short">
                        <option value="">Select Status</option>
                        <option value="1" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '1')) ? 'selected="selected"' : ''; ?>>Active</option>
                        <option value="0" <?php echo (isset($_REQUEST['status']) && ($_REQUEST['status'] == '0')) ? 'selected="selected"' : ''; ?>>Inactive</option>
                    </select>
                    &nbsp;&nbsp;
                    <input type="submit" name="btnsearch" value="Search" id="btnsearch" class="submit-green">
                    <?php echo ($_SESSION['role']['addUser']) ? $Adduserbtn : ''; ?>
                </p>

            </form>
        </div>
    </div>
    <div style="clear: both"></div>
    <?php
    echo $userFunc->getSessionMessage();
    $userFunc->unsetSessionMessage();
    ?>
    <div class="module">
        <h2><span>Users</span></h2>
        <div class="module-table-body">
            <table id="myTable" class="tablesorter">
                <thead>
                    <tr>
                        <th style="width:5%">S.No.</th>
                        <th style="width:10%">Username</th>
                        <th style="width:15%">User Group</th>
                        <th style="width:15%">Name</th>
                        <th style="width:13%">Email</th>
                        <th style="width:8%">Mobile No</th>
                        <th style="width:13%">Address</th>
                        <th style="width:5%">Action</th>
                        <th style="width:5%">Status</th>
                        <?php echo isset($_SESSION['role']['resetPassword']) ? '<th style="width:10%">Reset Password</th>' : ''; ?>
                        <!--<th style="width:15%">Action</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['btnsearch'])) {
                        $post_array = $_POST;
                        $listingarr = $userFunc->getUserListingBySearch($post_array);
                    }
                    else
                        $listingarr = $userFunc->getUserListing();

                    if (is_array($listingarr)) {
                        $i = 1;
                        foreach ($listingarr as $list) {
                            $ugroup = $userFunc->getUsergroupandUsername($list['id']);
                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . $list['username'] . '</td>';
                            echo '<td>' . $ugroup[0]['group_name'] . '</td>';
                            echo '<td>' . $list['name'] . '</td>';
                            echo '<td>' . $list['email'] . '</td>';
                            echo '<td>' . $list['mobile_no'] . '</td>';
                            echo '<td>' . $list['address'] . '</td>';
                            if (isset($_SESSION['role']['editUser']) && ($_SESSION['role']['editUser'] == true)) {
                                echo ($list['user_group'] != 1) ? '<td><a href="' . SITE_URL . '?page=editUser&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'bin.gif" width="16" title="Edit" height="16" alt="Edit" /></a></td>' : (($_SESSION['user_group'] == 1) ? '<td><a href="' . SITE_URL . '?page=editUser&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'bin.gif" width="16" title="Edit" height="16" alt="Edit" /></a></td>' : '');
                                echo ($list['user_group'] == 1) ? (($list['status'] == '1') ? '<td>&nbsp;</td>' : '<td><img src="' . IMAGE_URL . 'minus-circle.gif" width="16" title="In-active" height="16" alt="status" /></td>') : (($list['status'] == '1') ? '<td><img src="' . IMAGE_URL . 'tick-circle.gif" width="16" id="actives_' . $list['id'] . '" style="cursor:pointer;" onclick=\'statusChange(this.id,"' . $list['id'] . '","' . get_class($userFunc) . '")\'  title="Active" height="16" alt="status" /></a></td>' : '<td><img src="' . IMAGE_URL . 'minus-circle.gif" id="inactives_' . $list['id'] . '" style="cursor:pointer;" onclick=\'statusChange(this.id,"' . $list['id'] . '","' . get_class($userFunc) . '")\' width="16" title="In-active" height="16" alt="status" /></td>');
                            }
                            echo isset($_SESSION['role']['resetPassword']) ? '<td><a href="' . SITE_URL . '?page=resetPassword&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'key_go.png" width="16" title="Reset Password" height="16" alt="Reset Password" /></a></td>' : '';
//                                       echo  '<td>
//                                                    <a href=""><img src="'.IMAGE_URL.'pencil.gif" width="16" title="Edit User" height="16" alt="edit" /></a>
//                                                    <a href=""><img src="'.IMAGE_URL.'bin.gif" width="16" title="Delete User" height="16" alt="delete" /></a>
//                                                </td>';
                            echo '</tr>';
                            $i++;
                        }
                    }
                    else
                        echo '<tr><td colspan="15" style="text-align:center">' . $userFunc->getMessage() . '</td>';
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