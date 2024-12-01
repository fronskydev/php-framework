<?php

namespace app\Mailer;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    protected PHPMailer $mailer;

    /**
     * Constructor of the class.
     *
     * Instantiates a new PHPMailer instance and assigns it to the "mailer" property.
     */
    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
    }


    /**
     * Send an email with the given parameters.
     *
     * @param array|string $to The recipient's email address or an array of email addresses.
     * @param string $subject The subject of the email.
     * @param string $body The body (content) of the email.
     * @param string $replyToMail (Optional) The email address for replying to the email.
     * @param string $replyToName (Optional) The name associated with the reply-to email address.
     * @param array $variables (Optional) An array of key-value pairs for replacing variables in the email body.
     * @param array $attachments (Optional) An array of file paths to be attached to the email.
     *
     * @return string Returns "Success" if the email is sent successfully, Exception message otherwise.
     */
    public function sendEmail(array|string $to, string $subject, string $body, string $replyToMail = "", string $replyToName = "", array $variables = [], array $attachments = []): string
    {
        try {
            $mailer = $this->mailer;
            $mailer->isSMTP();
            if ($_ENV["MAIL_MAILER"] === "smtp") {
                $mailer->Host = $_ENV["MAIL_HOST"];
                $mailer->Port = $_ENV["MAIL_PORT"];
                $mailer->SMTPAuth = true;
                $mailer->Username = $_ENV["MAIL_USERNAME"];
                $mailer->Password = $_ENV["MAIL_PASSWORD"];
                $mailer->SMTPSecure = $_ENV["MAIL_ENCRYPTION"];
            } else {
                $mailer->isMail();
            }

            $mailer->setFrom($_ENV["MAIL_FROM_ADDRESS"], $_ENV["MAIL_FROM_NAME"]);
            if ($replyToMail !== "") {
                if ($replyToName !== "") {
                    $mailer->addReplyTo($replyToMail, $replyToName);
                } else {
                    $mailer->addReplyTo($replyToMail);
                }
            }
            $mailer->addAddress($to);
            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            foreach ($variables as $key => $value) {
                $body = str_replace("<?= \$$key; ?>", $value, $body);
            }

            $mailer->Body = $body;
            foreach ($attachments as $attachment) {
                $mailer->addAttachment($attachment);
            }

            $mailer->send();
            return "Success";
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}