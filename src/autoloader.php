<?php
spl_autoload_register(function ($className) {
    $filename = 'inc';
    if (str_contains($className, 'Controller')) $filename .= '/controllers/';
    elseif (str_contains($className, 'Model')) $filename .= '/models/';
    elseif (str_contains($className, 'Page')) $filename = 'page/';
    else $filename .= '/lib/';
    $filename .= $className . '.php';
    if (file_exists($filename)) require_once $filename;
    else {
        require_once ERROR_404_PAGE;
        header("Refresh: 2; url=" . PageController::url(REDIRECT) . "");
    }
});