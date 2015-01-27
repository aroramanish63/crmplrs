<?php

if (!defined('BASE_PATH'))
    exit('No direct script access allowed');

class commonClass {

    private $host;
    private $dbuser;
    private $dbpass;
    private $dbname;
    private $message;
    private $messageType = ''; // success, information, attention, error
    private $pagelimit = 30;
    public $connectionid;
    public $inputErrormsg = array();
    public $refObject;
    public $nextLevel = '';
    public $extensionarr = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'docx', 'xls', 'xlsx');

    public function __construct() {
        $this->host = DB_HOST;
        $this->dbuser = DB_USER;
        $this->dbpass = DB_PASS;
        $this->dbname = DB_NAME;
        $this->dbConnection();
    }

    private function dbConnection() {
        if ($this->host != '' && $this->dbuser != '' && $this->dbname != '') {
            $this->connectionid = mysql_connect($this->host, $this->dbuser, $this->dbpass);
            if ($this->connectionid) {
                mysql_select_db($this->dbname, $this->connectionid) or die(mysql_error());
            }
            else {
                echo die('Connection Error');
            }
            return $this->connectionid;
        }
        else {
            echo die('Database parameters not found.');
        }
    }

    /* ---------------Login Function Start-------- */

    public function userNameExist($username) {
        if ($this->connectionid) {
            if ($username != '') {
                $userSql = "select username from tbl_user where `username` = '" . mysql_real_escape_string($username) . "' and `status` = '1'";
                $resultSet = mysql_query($userSql) or die(mysql_error());
                if (mysql_num_rows($resultSet) > 0) {
                    return true;
                }
                else {
                    $this->setMessage('Whoops! We didn\'t recognise your username or password. Please try again.');
                }
            }
            else {
                $this->setMessage('Whoops! We didn\'t recognise your username. Please try again.');
            }
        }
        else {
            $this->setMessage('Database not connected.');
        }
    }

    public function getUsergroupandUsername($uid) {
        if ($uid != '') {
            $returnThis = array();
            $userSql = "select tu.username,tug.group_name from tbl_user as tu left join tbl_usergroup as tug on tu.user_group = tug.id where tu.id = '" . mysql_real_escape_string($uid) . "' and tu.status = '1'";
            $resultSet = mysql_query($userSql) or die(mysql_error());
            if (mysql_num_rows($resultSet) > 0) {
                while ($row = mysql_fetch_array($resultSet, MYSQL_ASSOC)) {
                    $returnThis[] = $row;
                }
                return $returnThis;
            }
            else {
                $this->setMessage('User details not found.');
            }
        }
        else {
            $this->setMessage('Invalid user id.');
        }
    }

    public function checkLogin($username, $pass) {
        if ($this->connectionid) {
            if ($username != '' && $pass != '') {
                $userSql = "select * from tbl_user where `username` = '" . mysql_real_escape_string($username) . "' and `password` = '" . mysql_real_escape_string($pass) . "' and `status` = '1'";
                $resultSet = mysql_query($userSql) or die(mysql_error());
                if (mysql_num_rows($resultSet) > 0) {
                    $row = mysql_fetch_array($resultSet);
                    return $row;
                }
                else {
                    $this->setMessage('Invalid username or password.');
                }
            }
            else
                $this->setMessage('Please enter username or password.');
        }
        else {
            $this->setMessage('Database not connected.');
        }
    }

    public function logout($sessionarr) {
        if (is_array($sessionarr)) {
            foreach ($sessionarr as $key => $value) {
                unset($_SESSION[$key]);
            }
            return;
        }
    }

    /* ---------------Login Function End--------------- */

    public function setErrors($errors) {
        $this->inputErrormsg = $errors;
    }

    public function getErrors() {
        if (count($this->inputErrormsg) > 0) {
            return $this->inputErrormsg;
        }
    }

    /* ------Message Functions Start----- */

    public function getMessageType() {
        return $this->messageType;
    }

    public function setSessionMessage($messageTxt, $messageType = '') {
        $_SESSION['msgtxt'] = $messageTxt;
        if ($messageType != '')
            $_SESSION['msgtype'] = $messageType;
    }

    public function getSessionMessage() {
        if (isset($_SESSION['msgtxt']) && isset($_SESSION['msgtype'])) {
            return '<span id="msgBox" class="notification n-' . $_SESSION['msgtype'] . '">' . $_SESSION['msgtxt'] . '</span>';
        }
        else if (isset($_SESSION['msgtxt']) && !isset($_SESSION['msgtype'])) {
            return $_SESSION['msgtxt'];
        }
        else
            return false;
    }

    public function unsetSessionMessage() {
        unset($_SESSION['msgtxt']);
        unset($_SESSION['msgtype']);
    }

    public function setMessage($messageTxt, $messageType = '') {
        $this->message = $messageTxt;
        if ($messageType != '')
            $this->messageType = $messageType;
    }

    public function getMessage() {
        if ($this->message != '' && $this->messageType != '') {
            return '<span id="msgBox" class="notification n-' . $this->messageType . '">' . $this->message . '</span>';
        }
        else if ($this->message != '' && $this->messageType == '') {
            return $this->message;
        }
        else
            return false;
    }

    /* ------Message Functions End----- */

    public function pagination($total_pages, $targetpage, $page) {
        $adjacents = 3;
        if ($page == 0)
            $page = 1;     //if no page var is given, default to 1.
        $prev = $page - 1;       //previous page is page - 1
        $next = $page + 1;       //next page is page + 1
        $limit = $this->pagelimit;
        $lastpage = ceil($total_pages / $limit);  //lastpage is = total pages / items per page, rounded up.
        $lpm1 = $lastpage - 1;
        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<div class=\"pagination\"><span>Page:</span>";
            //previous button
            if ($page > 1)
                $pagination.= "<a href=\"$targetpage&p=1\" class=\"button\"><span><img src=\"images/arrow-stop-180-small.gif\" height=\"9\" width=\"12\" alt=\"First\" /> First</span></a><a href=\"$targetpage?p=$prev\" class=\"button\"><span><img src=\"images/arrow-180-small.gif\" height=\"9\" width=\"12\" alt=\"Previous\" /> Prev</span></a> ";
            else
                $pagination.= " ";

            //pages
            if ($lastpage < 7 + ($adjacents * 2)) { //not enough pages to bother breaking it up
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination.= "<span class=\"current\">$counter</span>";
                        $pagination.= "<span>|</span>";
                    }
                    else {
                        $pagination.= "<a href=\"$targetpage&p=$counter\">$counter</a>";
                        $pagination.= "<span>|</span>";
                    }
                }
            }
            elseif ($lastpage > 5 + ($adjacents * 2)) { //enough pages to hide some
                //close to beginning; only hide later pages
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page) {
                            $pagination.= "<span class=\"current\">$counter</span>";
                            $pagination.= "<span>|</span>";
                        }
                        else {
                            $pagination.= "<a href=\"$targetpage&p=$counter\">$counter</a>";
                            $pagination.= "<span>|</span>";
                        }
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$targetpage&p=$lpm1\">$lpm1</a>";
                    $pagination.= "<span>|</span>";
                    $pagination.= "<a href=\"$targetpage&p=$lastpage\">$lastpage</a>";
                }
                //in middle; hide some front and some back
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<a href=\"$targetpage&p=1\">1</a>";
                    $pagination.= "<span>|</span>";
                    $pagination.= "<a href=\"$targetpage&p=2\">2</a>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page) {
                            $pagination.= "<span class=\"current\">$counter</span>";
                            $pagination.= "<span>|</span>";
                        }
                        else {
                            $pagination.= "<a href=\"$targetpage&p=$counter\">$counter</a>";
                            $pagination.= "<span>|</span>";
                        }
                    }

                    $pagination.= "<a href=\"$targetpage&p=$lpm1\">$lpm1</a>";
                    $pagination.= "<span>|</span>";
                    $pagination.= "<a href=\"$targetpage&p=$lastpage\">$lastpage</a>";
                }
                //close to end; only hide early pages
                else {
                    $pagination.= "<a href=\"$targetpage&p=1\">1</a>";
                    $pagination.= "<span>|</span>";
                    $pagination.= "<a href=\"$targetpage&p=2\">2</a>";
                    $pagination.= "<span>|</span>";
                    $pagination.= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                            $pagination.= "<span class=\"currentpage\">$counter</span>";
                            $pagination.= "<span>|</span>";
                        }
                        else {
                            $pagination.= "<a href=\"$targetpage&p=$counter\">$counter</a>";
                            $pagination.= "<span>|</span>";
                        }
                    }
                }
            }

            //next button
            if ($page < $counter - 1)
                $pagination.= "<a href=\"$targetpage&p=$next\" class=\"button\"><span>Next <img src=\"images/arrow-000-small.gif\" height=\"9\" width=\"12\" alt=\"Next\" /></span></a>";
            else
                $pagination.= " ";
            $pagination.= "<div style=\"clear: both;\"></div></div>\n";

            return $pagination;
        }
    }

    public function getAnytablenumrows($table_name) {
        if ($this->connectionid) {
            if ($table_name != '') {
                $query = "SELECT COUNT(*) as num FROM `$table_name`";
                $resultset = mysql_query($query);
                if (mysql_num_rows($resultset)) {
                    $total_page = mysql_fetch_array($resultset);
                    $total_pages = $total_page['num'];
                    return $total_pages;
                }
            }
        }
        else
            $this->setMessage('Database not connected.');
    }

    public function getDatePickerJs() {
        $returnString .= '<link rel="stylesheet" type="text/css" href="' . CSS_URL . 'jsDatePick_ltr.min.css" />';
        $returnString .= '<script type="text/javascript" src="' . JS_URL . 'jsDatePick.jquery.min.1.3.js"></script>';
        echo $returnString;
    }

    public function getDatePicker($startDatefieldId, $endDatefieldId) {
        if ($startDatefieldId != '' && $endDatefieldId != '') {
            $returnString = '';
            $returnString .= '<script type="text/javascript">
                                    window.onload = function(){
				new JsDatePick({
					useMode:2,
					target:"' . $startDatefieldId . '",
					dateFormat:"%d-%m-%Y",
					limitToToday:true,
				});
				new JsDatePick({
					useMode:2,
					target:"' . $endDatefieldId . '",
					dateFormat:"%d-%m-%Y",
					limitToToday:true,
				});
			};
                                </script>';
            echo $returnString;
        }
    }

    //function for include class
    public function &load_class($class, $directory = 'functions') {
        foreach (array(BASE_PATH) as $path) {
            if (file_exists($path . $directory . '/' . $class . '.php')) {
                $name = $class;

                if (class_exists($name) === FALSE) {
                    require($path . $directory . '/' . $class . '.php');
                }

                break;
            }
        }
        // Is the request a class extension?  If so we load it too
        if (file_exists(BASE_PATH . $directory . '/' . $class . '.php')) {
            $name = $class;

            if (class_exists($name) === FALSE) {
                require(BASE_PATH . $directory . '/' . $class . '.php');
            }
        }

        if ($name === FALSE) {
            exit('Unable to locate the specified class: ' . $class . '.php');
        }

        return $class;
    }

    public function countTablerows($resource = '') {
        if ($resource != '') {
            return mysql_num_rows($resource);
        }
    }

    public function createSelectOption($optionarr, $fieldval, $fieldtitle, $status, $selected = '') {
        if (is_array($optionarr)) {
            $returnString = '';
            $select = '';
            foreach ($optionarr as $val) {
                if ($selected != '' && ($selected == $val[$fieldval])) {
                    $select = 'selected="selected"';
                }
                else {
                    $select = '';
                }

                if ($val['status'] != '' && $val['status'] == $status)
                    $returnString .= '<option value="' . $val[$fieldval] . '" ' . $select . '>' . $val[$fieldtitle] . '</option>';
                else
                    $returnString .= '<option value="' . $val[$fieldval] . '"  ' . $select . '>' . $val[$fieldtitle] . '</option>';
            }
            return $returnString;
        }
    }

    public function real_escape_string($str) {
        if ($str != '') {
            return mysql_real_escape_string($str);
        }
    }

    public function selectWhereIn($tableName, $fieldNames = '', $where = array(), $orderByColumn = '', $desc = FALSE, $limit = '', $offSet = '') {
        if ($this->connectionid) {
            $conditions = array();
            $condition = "";
            $fields = "";
            $sql = "  SELECT ";
            //where condition
            if (is_array($where) && count($where) > 0) {
                foreach ($where as $key => $value) {
                    if ($key != '')
                        $conditions[] = $key . " IN('" . str_replace(",", "', '", mysql_real_escape_string($value)) . "')";
                }
                $condition = "WHERE " . implode(" AND ", $conditions);
            }
            //fieldname condition
            if ($fieldNames == '' || $fieldNames == '*') {
                $fields = "*";
            }
            elseif (is_array($fieldNames)) {
                $fields = "`" . implode("`, `", $fieldNames) . "`";
            }
            else {
                $fields = (string) ("`" . $fieldNames . "`");
            }
            $sql.="$fields FROM $tableName $condition";
            //order by column
            if (is_array($orderByColumn) && count($orderByColumn) > 0) {
                $sql.=" ORDER BY " . implode(", ", $orderByColumn);
            }
            elseif ($orderByColumn != '') {
                $sql.=" ORDER BY " . $orderByColumn;
            }
            //descending selection
            if ($desc) {
                $sql.=" DESC ";
            }
            //offset and limits
            if ($limit != '')
                $sql.=
                        " LIMIT $limit";
            if ($limit != '' && $offSet != '')
                $sql.=
                        ", $limit";
            $result = mysql_query($sql) or die(mysql_error());
            $returnThis = array();
            while ($rows = mysql_fetch_assoc($result)) {
                $returnThis[] = $rows;
            }
            return $returnThis;
        }
        else {
            $this->setMessage('DB Connection error.');
        }
    }

    public function select($tableName, $fieldNames = '', $where = array(), $groupBy = '', $orderByColumn = '', $desc = FALSE, $limit = -1, $offSet = 0) {
        if ($this->connectionid) {
            $conditions = array();
            $condition = "";
            $fields = "";
            $sql = "SELECT ";
            //where condition
            if (is_array($where) && count($where) > 0) {
                foreach ($where as $key => $value) {
                    if ($key != '')
                        $conditions[] = $key . "='" . mysql_real_escape_string($value) . "'";
                }
                $condition = "WHERE " . implode(" AND ", $conditions);
            }
            //fieldname condition
            if ($fieldNames == '' || $fieldNames == '*') {
                $fields = "*";
            }
            elseif (is_array($fieldNames)) {
                $fields = "`" . implode("`,`", $fieldNames) . "`";
            }
            else {
                $fields = (string) ("`" . $fieldNames . "`");
            }
            $sql.="$fields FROM $tableName $condition";
            //group by condition
            if (isset($groupBy) && $groupBy != '') {
                $sql.=" GROUP BY " . $groupBy;
            }

            //order by column
            if (is_array($orderByColumn) && count($orderByColumn) > 0) {
                $sql.=" ORDER BY " . implode(",", $orderByColumn);
            }
            elseif ($orderByColumn != '') {
                $sql.=" ORDER BY " . $orderByColumn;
            }
            //descending selection
            if ($desc) {
                $sql.=" DESC ";
            }
            //offset and limits
            if ($limit != -1)
                $sql.= " LIMIT $limit";

            if ($limit != -1 && $offSet != 0)
                $sql.=" ,$offSet" . " ";
            $sql.=" ; ";
//            echo $sql; die;
            $result = mysql_query($sql);
            $returnThis = array();
            if ($this->countTablerows($result) > 0) {
                while ($rows = mysql_fetch_assoc($result)) {
                    $returnThis[] = $rows;
                }
                return $returnThis;
            }
        }
        else {
            $this->setMessage('DB Connection error.');
        }
    }

    public function redirectUrl($page = '') {
        if ($page != '') {
            exit(header('Location:' . SITE_URL . '?page=' . $page));
        }
        else {
            header('Location:' . SITE_URL);
            exit();
        }
    }

    public function getGroupNamebyLevel($level) {
        if ($level != '') {
            $levelname = $this->select('tbl_usergroup', 'group_name', array('level' => $level));
            if (count($levelname) > 0) {
                return $levelname[0]['group_name'];
            }
            else {
                $this->setMessage('No record found');
            }
        }
    }

    public function get_extension($uploadfile = '') {
        if ($uploadfile != '') {
            $ext = strtolower(substr($uploadfile, strpos($uploadfile, '.') + 1));
            return $ext;
        }
    }

    public function &load_class_object($class, $directory = 'functions') {
        static $_classes = array();

        // Does the class exist?  If so, we're done...
        if (isset($_classes[$class])) {
            return $_classes[$class];
        }

        $name = FALSE;

        // Look for the class first in the local application/libraries folder
        // then in the native system/libraries folder
        foreach (array(BASE_PATH) as $path) {
            if (file_exists($path . $directory . '/' . $class . '.php')) {
                $name = $class;

                if (class_exists($name) === FALSE) {
                    require($path . $directory . '/' . $class . '.php');
                }

                break;
            }
        }

        if ($name === FALSE) {
            exit('Unable to locate the specified class: ' . $class . '.php');
        }

        $_classes[$class] = new $name();

        return $_classes[$class];
    }

}

?>