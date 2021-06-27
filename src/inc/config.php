<?php
/**
 * Website page name.
 */

// Set the title of the page
const PAGENAME = 'Simpl Framework';

/**
 * Default redirect page to send the user back to when entering a non-existing page for instance.
 */

// Set the default redirect page
const REDIRECT = 'home';

// Set the current date and time constants
define('DATE', date('Y-m-d'));
define('TIME_FULL', date('H:i:s'));
define('TIME', date('H:i'));

// Set needed folders for page loading
const VIEW = 'view/';
const PARTS = VIEW . 'parts/';
const ERRORS = PARTS . 'errors/';

// Set img, ico and svg directories
const IMG = '/img/';
const ICO = IMG . 'ico/';
const SVG = IMG . 'svg/';

// Set needed index directories
const META = PARTS . '/index/meta.phtml';
const CSS = PARTS . '/index/css.phtml';
const JS = PARTS . '/index/js.phtml';

// Set the directories of the error pages
const ERROR_403_PAGE = ERRORS . '403.phtml';
const ERROR_404_PAGE = ERRORS . '404.phtml';
const ERROR_500_PAGE = ERRORS . '500.phtml';

// Server information
define('INFO', 'Server info: ' . apache_get_version());