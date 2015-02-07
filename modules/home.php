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
                <img src="images/Crystal_Clear_file.gif" width="64" height="64" alt="edit" />
                <span>Complaint <br/> Management</span>
            </a>
        <?php } ?>
        <?php if (isset($_SESSION['role']['exportreport'])) { ?>
            <a href="<?php echo SITE_URL ?>?page=exportreport" class="dashboard-module">
                <img src="images/Crystal_Clear_stats.gif" width="64" height="64" alt="edit" />
                <span>Reports</span>
            </a>
        <?php } ?>
        <?php if (isset($_SESSION['role']['userProfile'])) { ?>
            <a href="<?php echo SITE_URL ?>?page=userProfile" class="dashboard-module">
                <img src="images/Crystal_Clear_settings.gif" width="64" height="64" alt="edit" />
                <span>Profile</span>
            </a>
        <?php } ?>
        <div style="clear: both"></div>
    </div> <!-- End .grid_7 -->
    <div class="grid_5">
        <div class="module">
            <h2><span>Account overview</span></h2>

            <div class="module-body">

                <!-- load api -->
                <script type="text/javascript" src="http://www.google.com/jsapi"></script>

                <script type="text/javascript">
                    //load package
                    google.load('visualization', '1', {packages: ['corechart']});
                </script>

                <script type="text/javascript">
                    function drawVisualization() {
                        // Create and populate the data table.
                        var data = google.visualization.arrayToDataTable([
                            ['PL', 'Ratings'],
<?php
while ($row = $result->fetch_assoc()) {
    extract($row);
    echo "['{$name}', {$ratings}],";
}
?>
                        ]);

                        // Create and draw the visualization.
                        new google.visualization.PieChart(document.getElementById('visualization')).
                                draw(data, {title: "Tiobe Top Programming Languages for June 2012"});
                    }

                    google.setOnLoadCallback(drawVisualization);
                </script>

            </div>
        </div>
        <div style="clear:both;"></div>
    </div> <!-- End .grid_5 -->

</div>