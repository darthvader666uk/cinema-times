<?php
/**
 * define root one level behind the document root
 */
define('ROOT', $_SERVER['DOCUMENT_ROOT']."/tools/");
define('DOC_ROOT', ROOT);
define('CACHE_DIR', ROOT . 'uploads/');

/**
 * Include dumpr for diagnostics
 */
require_once ROOT . '/dumpr.php';

// /**
//  * Autoloading
//  */
// require_once ROOT . '/SplClassLoader.php';
// $autoloader = new SplClassLoader('classes', ROOT . '/');
// $autoloader->register();

?>