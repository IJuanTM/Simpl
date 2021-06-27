<?php

/**
 * This class is an example use of a register class to check the users
 * input and then register the user in the user controller.
 */

class RegisterPage
{
    public function __construct()
    {
        // Check if all inputs are entered when button is pressed.
        if (isset($_POST['submit-register'])) {
            if (!empty($_POST['email-register'])) {
                ApplicationController::sanitize($_POST['email-register']);
                if (!empty($_POST['password-register'])) {
                    ApplicationController::sanitize($_POST['password-register']);
                    if (!empty($_POST['password-check'])) {
                        ApplicationController::sanitize($_POST['password-check']);
                        if ($_POST['password-check'] == $_POST['password-register']) {
                            UserController::userRegister($_POST['email-register'], $_POST['password-register']);
                            MailController::userRegister_mail($_POST['email-register']);
                        } else FormController::form_message('The entered passwords do not match!', 'error', null, 'register');
                    } else FormController::form_message('Please repeat your password!', 'warning', null, 'register');
                } else FormController::form_message('Please enter a password!', 'warning', null, 'register');
            } else FormController::form_message('Please enter your email!', 'warning', null, 'register');
        }
    }
}