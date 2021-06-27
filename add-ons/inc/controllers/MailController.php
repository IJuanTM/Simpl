<?php

class MailController
{
    public static function siteContact_mail($user_name, $user_mail, $subject, $message)
    {
        /**
         * This is the mail the site will receive from the contact form.
         * For example support@site.nl will receive the name, mail, subject and message given by the user in the contact form.
         */
        $site_message = '
            <i><b>' . 'Date: ' . '</b>' . DATE . '</i><br>' . '
            <i><b>' . 'Time: ' . '</b>' . TIME . '</i><br>' . '
            <p>' . nl2br($message) . '</p>' . '
            <b>' . 'Sender:' . '</b><br>' . '
            <i>' . $user_name . '</i>
        ';
        /**
         * Get site mail constant
         */
        $receiver = 'support@mail.com';
        MailController::send_mail($user_name, $receiver, $user_mail, $subject, $site_message);
    }

    public static function send_mail($sender_name, $receiver, $sender_mail, $subject, $message)
    {
        /**
         * Set all the headers and then send the mail
         */
        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To: ' . $receiver;
        $headers[] = 'From: ' . $sender_name . '<' . $sender_mail . '>';
        mail($receiver, $subject, $message, implode("\r\n", $headers));
        FormController::form_message('Mail has been successfully send!', 'success', 1, 'home');
    }

    public static function userContact_mail($receiver)
    {
        /**
         * This is the response mail the user will receive to confirm.
         * The name, sender and subject is set here.
         * For example no-reply, no-reply@mail.com and 'Your mail has been received'.
         */
        $contact_message = MailController::get_mail('user_contact');
        /**
         * Get site mail constants and set the subject
         */
        $site_name = 'no-reply';
        $site_mail = 'no-relpy@mail.com';
        $subject = 'Thanks for your message!';
        MailController::send_mail($site_name, $receiver, $site_mail, $subject, $contact_message);
    }

    public static function get_mail($name): bool|string
    {
        return file_get_contents(MAILS . $name . '.phtml');
    }

    public static function userRegister_mail($receiver)
    {
        /**
         * This mail is send to the user upon registering his/her account.
         * The mail is send to the given email and has a random generated code send with it.
         * This code has to be given on the validation page which the user is send to after registering.
         */
        $register_message = MailController::get_mail('user_register');
        /**
         * Get site mail constants and set the subject
         */
        $site_name = 'no-reply';
        $site_mail = 'no-relpy@mail.com';
        $subject = 'Registration confirmation.';
        MailController::send_mail($site_name, $receiver, $site_mail, $subject, $register_message);
    }
}