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

    function sendEmail($to, $subject, $message, $cc = array(), $bcc = array()) {
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

    public function verifierMessage() {
        $returnString = '';
        $returnString .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'
                . 'Hi,<br><br>'
                . 'It is to inform you that, you received a request in clearance system. Please do the needful as soon as possible.'
                . '<br><br>'
                . '<br><br>With Regards,<br>Admin<br>';

        return $returnString;
    }

    public function approverMessage() {
        $returnString = '';
        $returnString .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'
                . 'Hi,<br><br>'
                . 'It is to inform you that, you received a request in clearance system. Please do the needful as soon as possible.'
                . '<br><br>'
                . '<br><br>With Regards,<br>Verifier<br>';

        return $returnString;
    }

    public function financeMessage() {
        $returnString = '';
        $returnString .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'
                . 'Hi,<br><br>'
                . 'It is to inform you that, you received a request in clearance system. Please do the needful as soon as possible.'
                . '<br><br>'
                . '<br><br>With Regards,<br>Approver<br>';

        return $returnString;
    }

    public function onComplaintRegistered($fields) {
        if (is_array($fields) && count($fields) > 0) {
            $message = '';
            $message .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'
                    . 'Hi,' . $fields[0] . '<br><br>'
                    . 'We have successfully registered your complaint. Please find details below:'
                    . '<br><br>'
                    . 'Name:' . $fields[0] . '<br/>'
                    . 'Email:' . $fields[1] . '<br/>'
                    . 'Complaint Ticket No.:' . $fields[2] . '<br/>'
                    . '<br><br>With Regards,<br>PLRS Team<br>';
            $to = $fields[1];
            $subj = "Complaint Registered Successfully";
            $this->sendEmail($to, $subj, $message);
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
            $this->sendEmail($to, $subj, $message);
        }
    }

    public function onFeedback($fields) {
        if (is_array($fields) && count($fields) > 0) {
            $message = '';
            $message .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'
                    . 'Hi,' . $fields[0] . '<br><br>'
                    . 'We have successfully close your complaint. Please find details below:'
                    . '<br><br>'
                    . 'Name:' . $fields[0] . '<br/>'
                    . 'Email:' . $fields[1] . '<br/>'
                    . 'Feedback Ticket No.:' . $fields[2] . '<br/>'
                    . 'Feedback Remarks:' . $fields[2] . '<br/>'
                    . '<br><br>With Regards,<br>PLRS Team<br>';
            $to = $fields[1];
            $subj = "Complaint Closed Successfully";
            $this->sendEmail($to, $subj, $message);
        }
    }

}
