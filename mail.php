<?php
$name = trim($_POST['contact-name']);
$phone = trim($_POST['contact-phone']);
$email = trim($_POST['contact-email']);
$message = trim($_POST['contact-message']);
if ($name == "") {
    $msg['err'] = "\n Name can not be empty!";
    $msg['field'] = "contact-name";
    $msg['code'] = FALSE;
} else if ($phone == "") {
    $msg['err'] = "\n Phone number can not be empty!";
    $msg['field'] = "contact-phone";
    $msg['code'] = FALSE;
} else if (!preg_match("/^[0-9 \\-\\+]{4,17}$/i", trim($phone))) {
    $msg['err'] = "\n Please put a valid phone number!";
    $msg['field'] = "contact-phone";
    $msg['code'] = FALSE;
} else if ($email == "") {
    $msg['err'] = "\n Email can not be empty!";
    $msg['field'] = "contact-email";
    $msg['code'] = FALSE;
} else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $msg['err'] = "\n Please put a valid email address!";
    $msg['field'] = "contact-email";
    $msg['code'] = FALSE;
} else if ($message == "") {
    $msg['err'] = "\n Message can not be empty!";
    $msg['field'] = "contact-message";
    $msg['code'] = FALSE;
} else {
    $to = 'ranirizkianiwork@gmail.com';
    $subject = 'Contact Query';
    $_message = '<html><head></head><body>';
    $_message .= '<p>Name: ' . $name . '</p>';
    $_message .= '<p>Message: ' . $phone . '</p>';
    $_message .= '<p>Email: ' . $email . '</p>';
    $_message .= '<p>Message: ' . $message . '</p>';
    $_message .= '</body></html>';

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From:  rani <ranirizkianiwork@gmail.com>' . "\r\n";
    $headers .= 'cc: contact@example.com' . "\r\n";
    $headers .= 'bcc: contact@example.com' . "\r\n";
    mail($to, $subject, $_message, $headers, '-f contact@example.com');

    $msg['success'] = "\n Email has been sent successfully.";
    $msg['code'] = TRUE;
}
echo json_encode($msg);

/**
 * Class Mailer
 *
 * A wrapper class for the PHPMailer package
 */
class Mailer extends \PHPMailer\PHPMailer\PHPMailer
{
    /**
     * PHPMailer constructor.
     *
     * Automatically configure SMTP credentials and adjust X-Mailer header
     *
     * @param null $exceptions
     */
    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);

        $this->XMailer = "Rani's Portfolio";
    }

    /**
     * Automatically signs emails with a DKIM signature if enabled
     *
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send()
    {
        // must match the domain in the "From"
        $this->DKIM_domain = "raniportfolio.com"

        // private key path
        $this->DKIM_private = "/path/to/dkim/private.key";

        // dns selector (this matches with TXT record with hostname: whoeveryouare._domainkey.mydomain.com)
        $this->DKIM_selector = 'whoeveryouare';

        // private key passphrase (has none)
        $this->DKIM_passphrase = '';

        //Suppress listing signed header fields in signature, defaults to true for debugging purpose
        $this->DKIM_copyHeaderFields = true; // SHOULD BE FALSE IN PRODUCTION

        // who is signing this email
        $this->DKIM_identity = $this->From;
        

        return parent::send();
    }
}
?>