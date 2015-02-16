<div class="container_12">

    <!-- Dashboard icons -->
    <div class="grid_7" style="min-height: 400px">
        <?php
        $ViewUser = '';

        if (isset($_SESSION['role']['userManagement']) || isset($_SESSION['role']['userGroup']) || isset($_SESSION['role']['userRole'])) {
            ?>
            <a href="<?php echo SITE_URL ?>?page=userManagement" class="dashboard-module">
                <img src="images/Crystal_Clear_user.gif" width="64" height="64" title="User Management" alt="User Management" />
                <span>User Management</span>
            </a>
        <?php } ?>

        <?php if (isset($_SESSION['role']['viewComplaints']) || isset($_SESSION['role']['addComplaints']) || isset($_SESSION['role']['editComplaints'])) { ?>
            <a href="<?php echo SITE_URL ?>?page=viewComplaints" class="dashboard-module">
                <img src="images/Crystal_Clear_file.gif" width="64" height="64" alt="Complaint Management" />
                <span>Complaint <br/> Management</span>
            </a>
        <?php } ?>
        <?php if (isset($_SESSION['role']['exportreport'])) { ?>
            <a href="<?php echo SITE_URL ?>?page=exportreport" class="dashboard-module">
                <img src="images/Crystal_Clear_stats.gif" width="64" height="64" alt="Reports" />
                <span>Reports</span>
            </a>
        <?php } ?>
        <?php if (isset($_SESSION['role']['userProfile'])) { ?>
            <a href="<?php echo SITE_URL ?>?page=userProfile" class="dashboard-module">
                <img src="images/Crystal_Clear_settings.gif" width="64" height="64" alt="Profile" />
                <span>Profile</span>
            </a>
        <?php } ?>
        <div style="clear: both"></div>
    </div> <!-- End .grid_7 -->
    <div class="grid_5">
        <div class="module">
            <h2><span>Complaints overview</span></h2>

            <div class="module-body">
                <?php
                $sql = "SELECT pct.complaint_type,count(pc.id) as cnt FROM `plrs_complaint` as pc join plrs_complaint_type as pct on pct.id = pc.complaint_type group by pc.complaint_type";
                $complaint_type = $commonObj->query($sql);
                if (mysql_num_rows($complaint_type) > 0) {
                    require BASE_PATH . "libchart/libchart/classes/libchart.php";
                    $chart = new PieChart(450, 250);
                    $dataSet = new XYDataSet();
                    while ($row = mysql_fetch_assoc($complaint_type)) {
                        $dataSet->addPoint(new Point($row['complaint_type'] . ' (' . $row['cnt'] . ')', $row['cnt']));
                    }
                    $chart->setDataSet($dataSet);

                    $chart->setTitle("User Complaints");
                    $chart->render(BASE_PATH . "libchart/demo/generated/demo3.png");
                    ?>
                    <img alt="Pie chart"  src="./libchart/demo/generated/demo3.png" style="border: 1px solid gray;"/>
                <?php } ?>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div> <!-- End .grid_5 -->

</div>