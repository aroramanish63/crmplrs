<?php
if (!defined('BASE_PATH'))
    die('Access Denied.');
$commonObj->load_class('userFunctions');
$userFunc = new userFunctions();
?>
<div class="container_12">
    <?php
    $Addusergrpbtn = '<fieldset>
                <a title="Add User Group" href="' . SITE_URL . '?page=adduserGroup"><input class="submit-green" style="float:right" type="button" value="Add" /></a>
            </fieldset>';
    echo ($_SESSION['role']['adduserGroup']) ? $Addusergrpbtn : '';
    ?>

    <div style="clear: both"></div>
    <?php
    echo $userFunc->getSessionMessage();
    $userFunc->unsetSessionMessage();
    ?>
    <div class="module">
        <h2><span>User Group</span></h2>
        <div class="module-table-body">
            <table id="myTable" class="tablesorter">
                <thead>
                    <tr>
                        <th style="width:5%">S.No.</th>
                        <th style="width:15%">Group Name</th>
                        <th style="width:21%">Description</th>
                        <th style="width:13%">Action</th>
                        <th style="width:13%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $listingarr = $userFunc->getUserGroup();
                    if (is_array($listingarr)) {
                        $i = 1;
                        foreach ($listingarr as $list) {
                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . $list['group_name'] . '</td>';
                            echo '<td>' . $list['group_description'] . '</td>';
                            echo '<td><a href="' . SITE_URL . '?page=edituserGroup&idu=' . $list['id'] . '"><img src="' . IMAGE_URL . 'bin.gif" width="16" title="Edit" height="16" alt="Edit" /></a></td>';
                            echo ($list['status'] == '1') ? '<td><img src="' . IMAGE_URL . 'tick-circle.gif" width="16" title="Active" height="16" alt="status" /></td>' : '<td><img src="' . IMAGE_URL . 'minus-circle.gif" width="16" title="In-active" height="16" alt="status" /></td>';
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