<?php

/**
 * This class is for sending an contact email from the contact page on you site
 */

class ContactPage
{
    public function __construct()
    {
        // Check if all inputs are entered when button is pressed.
        if (isset($_POST['submit-contact'])) {
            if (!empty($_POST['name-contact'])) {
                if (!empty($_POST['email-contact'])) {
                    if (!empty($_POST['subject-contact'])) {
                        if (!empty($_POST['message-contact'])) {
                            // Send a mail to the set site domain email address.
                            MailController::siteContact_mail($_POST['name-contact'], $_POST['email-contact'], $_POST['subject-contact'], $_POST['message-contact']);
                            // Send a mail to the user confirming that the mail has been send.
                            MailController::userContact_mail($_POST['email-contact']);
                        } else FormController::form_message('Please enter a message!', 'warning', null, 'contact');
                    } else FormController::form_message('Please enter a subject!', 'warning', null, 'contact');
                } else FormController::form_message('Please enter your own mail!', 'warning', null, 'contact');
            } else FormController::form_message('Please enter your name!', 'warning', null, 'contact');
        }
    }
}