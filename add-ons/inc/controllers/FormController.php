<?php

/**
 * FormController is the class where things regarding html forms are coded.
 * For example the given alert message to give feedback to the user after a form
 * submit has been called.
 */

class FormController
{
    public static string $alert;

    public static function form_message($message, $type, $refresh, $location): string
    {
        static::$alert = '<div class="--simpl-alert ' . $type . '" role="alert">' . $message . '</div>';
        header("Refresh: " . $refresh . "; url=" . PageController::url($location) . "");
        return static::$alert;
    }
}