<?php

/**
 * UserController has everything to do with logging in and registering on the page.
 * As well as a code validation to have the user validate their account by email.
 */

class UserController
{
    /**
     * @param $email // User email from form
     * @param $password // User password from form
     *
     * This method is for logging in on your website and to generate the right
     * messages according to the sitiuation and give the user the right feedbadk.
     * And ofcourse a check with the database to check if the user actually exists
     * and if the given password matches the one in the database.
     */

    public static function userLogin($email, $password)
    {
        $db = new Database();
        $db->query('SELECT password, email FROM user WHERE email = :email');
        $db->bind(':email', $email);
        $db->execute();
        if (!empty($db->single()['email'])) {
            if (password_verify($password, $db->single()['password'])) {
                $db->query('SELECT * FROM user WHERE email = :email');
                $db->bind(':email', $email);
                $record = $db->resultset()[0];
                $_SESSION['id'] = $record['user_id'];
                $_SESSION['email'] = $record['email'];
                $_SESSION['user_role'] = (int)$record['user_role'];
                if ($_SESSION["user_role"] === 0) FormController::form_message('Logged in as Admin.', 'info', 1, 'home');
                elseif ($_SESSION["user_role"] === 1) FormController::form_message('Login Successful! Welcome!', 'success', 1, 'home');
                else {
                    FormController::form_message('Error! No userrole is set for this account! Please contact an admin!', 'error', null, 'home');
                    unset($_SESSION["user_role"]);
                }
            } else FormController::form_message('E-mail or password is not correct!', 'warning', null, 'login');
        } else FormController::form_message('This e-mail is not registered!', 'warning', null, 'login');
    }

    /**
     * @param $email // User email from form
     * @param $password // User password from form
     *
     * This method is for registering on your website.
     * Here the system pushes a new record to the database and checks if this one already exists.
     * As well as gives the right response to the user according to the situation.
     */

    public static function userRegister($email, $password)
    {
        $db = new Database();
        $db->query('SELECT * FROM user WHERE email = :email');
        $db->bind(':email', $email);
        $db->execute();
        if ($db->rowCount() > 0) FormController::form_message('This E-mail already exists! Try logging in!', 'warning', 1, 'register');
        else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT, ['whirlpool']);
            $code = UserController::generateCode();
            $db->query('INSERT INTO user (email, password, user_role, code) VALUES(:email, :password_hash, 1, :code)');
            $db->bind(':email', $email);
            $db->bind(':password_hash', $password_hash);
            $db->bind(':code', $code);
            $db->execute();
            FormController::form_message('Success! Your account has been created!', 'success', 1, 'login');
        }
    }

    /**
     * @return string // Return code
     *
     * Here a random 4 digid code is generated
     */

    public static function generateCode(): string
    {
        $code = '';
        for ($i = 1; $i <= 4; $i++) {
            $code .= strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
            if ($i != 4) $code .= '-';
        }
        return $code;
    }

    /**
     * @param $user_id // Check code depending on user_id
     * @return string // Return test
     *
     * Method to get the code from the database and check this one on your website.
     */

    public static function getCode($user_id): string
    {
        $db = new Database();
        $db->query('SELECT code FROM user WHERE user_id = :user_id');
        $db->bind(':user_id', $user_id);
        if ($db->execute() && $db->single()['code']) return 'test';
        else return 'Code not found';
    }
}