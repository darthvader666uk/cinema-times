<?php
if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])){
    define('ROOT', $_SERVER['DOCUMENT_ROOT']."/");
} else {
	define('ROOT', $_SERVER['DOCUMENT_ROOT']."/cinema/");
}

/**
 * define root one level behind the document root
 */
define('DOC_ROOT', ROOT);
define('CACHE_DIR', ROOT . 'uploads/');

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Make sure functions are load first
 */
include(ROOT.'includes/functions.php');

/**
 * Now include the rest of the site
 */
include(ROOT.'includes/header.php');
include(ROOT.'includes/main.php');
include(ROOT.'includes/footer.php');
