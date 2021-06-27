<?php

/**
 * LoginPage is a basic login page for a simple email and password login
 * page with warning alerts when a user has an incorrect submit.
 */

class LoginPage
{
    public function __construct()
    {
        // Check if all inputs are entered when button is pressed.
        if (isset($_POST['submit-login'])) {
            if (!empty($_POST['email-login'])) {
                if (!empty($_POST['password-login'])) UserController::userLogin($_POST['email-login'], $_POST['password-login']);
                else FormController::form_message('Please enter your password!', 'warning', null, 'login');
            } else FormController::form_message('Please enter your email!', 'warning', null, 'login');
        }
    }
}