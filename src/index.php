<?php
ob_start();
session_start();

// Set the directory of the index.php as the BASEDIR
define('BASEDIR', realpath(__DIR__));

// Set the default timezone, change this to your liking or add code that changes it automatically
date_default_timezone_set("Europe/Amsterdam");

// Require the config file
require_once BASEDIR . '/inc/config.php';

// Require the autoloader
require_once BASEDIR . '/autoloader.php';

// Make a new object from the ApplicationController class
new ApplicationController();