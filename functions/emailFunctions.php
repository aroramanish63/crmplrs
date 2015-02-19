<?php

require_once(BASE_PATH . "PHPMailer/class.phpmailer.php");

class emailFunctions extends commonFxn {

    public $mail;

    public function __construct() {
        $this->mail = new PHPMailer();
        //$this->mail->IsSMTP();
        //$this->mail->SMTPAuth=false;
        //$this->mail->SMTPSecure="tls";
        //$this->mail->Port=25;
        //$this->mail->Host="localhost"; //"103.10.189.48";
        //$this->mail->Username="support@askpcexperts.com";
        //$this->mail->Password="H24!@#IU*&//";
        $this->mail->IsSMTP();
        $this->mail->SMTPAuth = TRUE;
        $this->mail->SMTPSecure = "tls";
        //$this->mail->SMTPDebug = TRUE;
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = "587";
        $this->mail->Username = "developer.cyfuture@gmail.com";
        $this->mail->Password = "cyf@123100";
        $this->mail->SetFrom("developer.cyfuture@gmail.com");
        $this->mail->WordWrap = 50;

        //$this->mail->SetFrom("support@askpcexperts.com", "Askpcexperts");
        $this->mail->IsHTML(true);
    }

    public function sendEmail($to, $subject, $message, $cc = array(), $bcc = array()) {
        for ($i = 0; $i < count($to); $i++)
            $this->mail->AddAddress($to[$i]);
        for ($i = 0; $i < count($cc); $i++)
            $this->mail->AddCc($cc[$i]);
        for ($i = 0; $i < count($bcc); $i++)
            $this->mail->AddBcc($bcc[$i]);

        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        try {
            if (!$this->mail->send()) {
                return false;
            }
        }
        catch (Exception $ex) {

        }
        $this->mail->ClearAllRecipients();
        return true;
    }

    /*
     * function for save details before sending emails.
     */

    public function saveMailbeforeSend($userGroup) {
        if ($userGroup != '') {

            $subj = 'For Clearance Request.';
            if ($userGroup == 3) {
                $message = $this->verifierMessage();
            }
            else if ($userGroup == 4) {
                $message = $this->approverMessage();
            }
            else if ($userGroup == 5) {
                $message = $this->financeMessage();
            }
            $getEmail = $this->getEmailByusergroup($userGroup);
            if (is_array($getEmail) && count($getEmail) > 0) {
                foreach ($getEmail as $email) {
//                        $to = $email['email'];
                    $to = array($email['email']);
                    $this->sendEmail($to, $subj, $message);
                }
//                    echo 'Mail Send';
            }
        }
    }

    /*
     * function for set mail configuration
     */

    function getMailConfig($mail) {
        if (is_a($mail, 'PHPMailer')) {
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = 25;
            $mail->Host = "103.10.189.48";
            $mail->Username = "support@go4hosting.com";
            $mail->Password = "H24!@#IU*&//";
        }
    }

    public function getEmailByusergroup($id) {
        $returnArray = array();
        $resultSet = mysql_query("select email from $this->userTable where user_group = '$id'") or die(mysql_error());
        if (mysql_num_rows($resultSet) > 0) {
            while ($row = mysql_fetch_assoc($resultSet)) {
                $returnArray[] = $row;
            }
            return $returnArray;
        }
    }

    public function onComplaintRegistered($fields) {
        if (is_array($fields) && count($fields) > 0) {
            $message = '';
            $message .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'
                    . 'Dear ' . $fields['cname'] . ',<br><br>'
                    . 'Thanks you for contacting Punjab Land Records Society.'
                    . '<br><br>'
                    . 'Your support ticket number is ' . $fields['ticket_no'] . '<br/>';
            if (array_key_exists('txt_content', $fields)) {
                $message .= '<br/>Kindly find below the response regarding your query:';
                $message .= $fields['txt_content'];
            }
            $message .= '<br><br>Sincerely,<br>PLRS Customer Care Team<br>';
            $to = $fields['cemail'];
            $subj = "Complaint Registered Successfully";
            $this->sendEmail(array($to), $subj, $message);
        }
    }

    public function onComplaintClose($fields) {
        if (is_array($fields) && count($fields) > 0) {
            $message = '';
            $message .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'
                    . 'Hi,' . $fields[0] . '<br><br>'
                    . 'We have successfully close your complaint. Please find details below:'
                    . '<br><br>'
                    . 'Name:' . $fields[0] . '<br/>'
                    . 'Email:' . $fields[1] . '<br/>'
                    . 'Complaint Ticket No.:' . $fields[2] . '<br/>'
                    . '<br><br>With Regards,<br>PLRS Team<br>';
            $to = $fields[1];
            $subj = "Complaint Closed Successfully";
            $this->sendEmail(array($to), $subj, $message);
        }
    }

    public function onFeedback($fields) {
        if (is_array($fields) && count($fields) > 0) {
            $message = '';
            $message .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'
                    . 'Hi,' . $fields[0] . '<br><br>'
                    . 'We have successfully close your ' . $fields[4] . '. Please find details below:'
                    . '<br><br>'
                    . 'Name:' . $fields[0] . '<br/>'
                    . 'Email:' . $fields[1] . '<br/>'
                    . $fields[4] . ' Ticket No.:' . $fields[2] . '<br/>'
                    . $fields[4] . ' Remarks:' . $fields[3] . '<br/>'
                    . '<br><br>With Regards,<br>PLRS Team<br>';
            $to = $fields[1];
            $subj = $fields[4] . " Closed Successfully";
            $this->sendEmail(array($to), $subj, $message);
        }
    }

//    public function sendmailtoadmin($username, $email) {
//        $html = '';
//        $subject = 'PLRSCRM User Deactivated';
//
//        $sentfrom = 'plrscrm';
//        $sentname = 'plrscrm';
//
//        $mail = new PHPMailer();
//        $mail->IsSMTP();                           // tell the class to use SMTP
//        $mail->SMTPAuth = true;                  // enable SMTP authentication
//        $mail->SMTPSecure = 'tls';
//        $mail->Port = 25;                    // set the SMTP server port
//        $mail->Host = "mail.cloudoye.in";
//        $mail->Username = "admin@cloudoye.in";
//        $mail->Password = "Sghdwsw$3231";
//        // SMTP server password
//        $mail->IsHTML(true);
//        $mail->SetFrom($sentfrom, $sentname);
//
//        $mail->AddAddress("harpreet.kaur@cyfuture.com");
//
//        $mail->Subject = $subject;
//        $mail->SMTPDebug = 2;
//        $html = 'User with username : ' . $username . ' and Email : ' . $email . ' has been deactivated due to wrong login attempts!';
//
//        $mail->Body = $html;
//        //$mail->WordWrap = 50;
//
//        if ($mail->Send()) {
//            //echo '<!-- Mail sent -->';
//        }
//    }
}
