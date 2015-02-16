<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?php echo defined('CRM_TITLE') ? CRM_TITLE : 'CRM'; ?></title>

        <!-- CSS Reset -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>reset.css" media="screen" />

        <!-- Fluid 960 Grid System - CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>grid.css" media="screen" />

        <!-- IE Hacks for the Fluid 960 Grid System -->
        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="ie6.css" tppabs="http://www.xooom.pl/work/magicadmin/<?php echo CSS_URL; ?>ie6.css" media="screen" /><![endif]-->
                  <!--[if IE 7]><link rel="stylesheet" type="text/css" href="ie.css" tppabs="http://www.xooom.pl/work/magicadmin/<?php echo CSS_URL; ?>ie.css" media="screen" /><![endif]-->

        <!-- Main stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>styles.css" media="screen" />

        <!-- WYSIWYG editor stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>jquery.wysiwyg.css" media="screen" />

        <!-- Table sorter stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>tablesorter.css" media="screen" />

        <!-- Thickbox stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>thickbox.css" media="screen" />

        <!-- Themes. Below are several color themes. Uncomment the line of your choice to switch to different color. All styles commented out means blue theme. -->
        <!--<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>theme-blue.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>theme-red.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>theme-yellow.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>theme-green.css" media="screen" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>theme-graphite.css" media="screen" />

        <!-- JQuery engine script-->
        <script type="text/javascript" src="<?php echo JS_URL; ?>jquery-1.3.2.min.js"></script>

        <!-- JQuery WYSIWYG plugin script -->
        <script type="text/javascript" src="<?php echo JS_URL; ?>jquery.wysiwyg.js"></script>

        <!-- JQuery tablesorter plugin script-->
        <script type="text/javascript" src="<?php echo JS_URL; ?>jquery.tablesorter.min.js"></script>

        <!-- JQuery pager plugin script for tablesorter tables -->
        <script type="text/javascript" src="<?php echo JS_URL; ?>jquery.tablesorter.pager.js"></script>

        <!-- JQuery password strength plugin script -->
        <script type="text/javascript" src="<?php echo JS_URL; ?>jquery.pstrength-min.1.2.js"></script>

        <!-- JQuery thickbox plugin script -->
        <script type="text/javascript" src="<?php echo JS_URL; ?>thickbox.js"></script>
        <script type="text/javascript" src="<?php echo JS_URL; ?>commonjs.js"></script>

    </head>
    <body>
        <!-- Header -->
        <div id="header">
            <span id="URL_SITE" title="<?php echo SITE_URL; ?>"></span>
            <!-- Header. Status part -->
            <div id="header-status">
                <div class="container_12">
                    <div class="grid_8">
                        &nbsp;
                    </div>
                    <div class="grid_4">
                        <a href="<?php echo SITE_URL ?>logout.php" title="logout" id="logout">
                            Logout
                        </a>
                        <span style="position: relative;top:10px;left: 125px;">Welcome <?php echo ($_SESSION['name'] != '') ? ucfirst($_SESSION['name']) : ''; ?></span>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End #header-status -->
            <!-- Header. Main part -->
            <div id="header-main">
                <div class="container_12">
                    <div class="grid_12">
                        <div id="logo"><a href="<?php echo SITE_URL; ?>"><img alt="PLRS logo" src="images/logo-plrs-inner.png" /></a></div>
                        <div class="headernav" <?php echo isset($_SESSION['role']['userManagement']) ? 'style="margin-right: 70px;"' : 'style="margin-right: 100px;"'; ?>>
                            <ul id="drop-nav">
                                <li><a href="<?php echo SITE_URL; ?>">Dashboard</a></li>
                                <?php
                                if (isset($_SESSION['role']['userManagement']) || isset($_SESSION['role']['userGroup']) || isset($_SESSION['role']['userRole'])) {
                                    ?>
                                    <li>
                                        <a href="javascript:void(0);">User Management</a>
                                        <ul>
                                            <?php echo (isset($_SESSION['role']['userManagement'])) ? '<li><a href="' . SITE_URL . '?page=userManagement">Users</a></li>' : ''; ?>
                                            <?php echo (isset($_SESSION['role']['userGroup'])) ? '<li><a href="' . SITE_URL . '?page=userGroup">User Group</a></li>' : ''; ?>
                                            <?php echo (isset($_SESSION['role']['userRole'])) ? '<li><a href="' . SITE_URL . '?page=userRole">User Roles</a></li>' : ''; ?>
                                        </ul>
                                    </li>
                                    <?php
                                }

                                if (isset($_SESSION['role']['viewComplaints']) || isset($_SESSION['role']['addComplaints']) || isset($_SESSION['role']['editComplaints'])) {
                                    ?>
                                    <li><a href="javascript:void(0);">Complaint Management</a>
                                        <ul>
                                            <?php echo (isset($_SESSION['role']['viewComplaints'])) ? '<li><a href="' . SITE_URL . '?page=viewComplaints">View Complaints</a></li>' : ''; ?>
                                            <?php if ($commonObj->isCallCentreStaff($_SESSION['uid'])) { ?>
                                                <li><a href="<?php echo SITE_URL . '?page=closeComplaints'; ?>">Close Enquiries</a></li>
                                                <li><a href="<?php echo SITE_URL . '?page=forwardedComplaints'; ?>">Forwarded Complaints</a></li>
                                            <?php } ?>
                                            <li><a href="<?php echo SITE_URL . '?page=reportsComplaints'; ?>">Complaints Report</a></li>
                                        </ul>
                                    </li>
                                    <?php
                                }

                                if (isset($_SESSION['role']['paymode']) || isset($_SESSION['role']['viewBanks'])) {
                                    ?>
                                    <li><a href="#">Payment Management</a>
                                        <ul>
                                            <?php echo (isset($_SESSION['role']['paymode'])) ? '<li><a href="' . SITE_URL . '?page=paymode">Payment Mode</a></li>' : ''; ?>
                                            <?php echo (isset($_SESSION['role']['viewBanks'])) ? '<li><a href="' . SITE_URL . '?page=viewBanks">Banks</a></li>' : ''; ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php echo (isset($_SESSION['role']['userProfile'])) ? '<li><a href="' . SITE_URL . '?page=userProfile">Profile</a></li>' : ''; ?>
                                <li><a href="#">Links</a>
                                    <ul>
                                        <li><a href="http://210.212.41.167/frmSelectDistrict.aspx" target="_blank">Fard</a></li>
                                        <li><a href="http://202.164.37.185/" target="_blank">Stamp Duty Calculator</a></li>
                                        <li><a href="http://punjabrevenue.nic.in/fmanu.htm" target="_blank">Manuals</a></li>
                                        <li><a href="http://punjabrevenue.nic.in/fstate.htm" target="_blank">State Acts</a></li>
                                        <li><a href="http://punjabrevenue.nic.in/fglands.htm" target="_blank">Govt. Lands</a></li>
                                        <li><a href="http://www.mapsofindia.com/maps/punjab/districts/" target="_blank">Map of Punjab</a></li>
                                        <li><a href="http://pbplanning.gov.in/districts.htm" target="_blank">Districts</a></li>
                                        <li><a href="http://vlist.in/state/03.html" target="_blank">Villages</a></li>
                                        <li><a href="http://www.examresultinfo.com/threads/1309-www-plrs-org-in-Punjab-Land-Records-Society-Fard-PLRS-khata-khatauni-Khasra-Mutation-Report" target="_blank">How to use PLRS website</a></li>
                                        <li><a href="http://www.examresultinfo.com/threads/1310-www-plrs-org-in-Punjab-Land-Records-Request-for-Correction-of-Records-amp-Mutation-PLRS-Online-Application-Form" target="_blank">PLRS Online Form</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo SITE_URL; ?>plrsfaqs.pdf" target="_blank">FAQs</a></li>
                            </ul>
                        </div>


                    </div><!-- End. .grid_12-->
                    <div style="clear: both;"></div>
                </div><!-- End. .container_12 -->
            </div> <!-- End #header-main -->
            <div style="clear: both;"></div>
            <!-- Sub navigation -->
            <!--            <div id="subnav">
                            <div class="container_12">
                                <div class="grid_12">
                                    <ul>
                                        <li><a href="#">link 1</a></li>
                                        <li><a href="#">link 2</a></li>
                                        <li><a href="#">link 3</a></li>
                                        <li><a href="#">link 4</a></li>
                                        <li><a href="#">link 5</a></li>
                                    </ul>

                                </div> End. .grid_12
                            </div> End. .container_12
                            <div style="clear: both;"></div>
                        </div>  End #subnav -->
        </div> <!-- End #header -->