<?php

/**
 * darthvader666uk/cinema-times
 * 
 * https://www.cineworld.co.uk/uk/data-api-service/v1/10108/trailers/byCinemaId/8031?_=1578064777652
 * https://www.cineworld.co.uk/uk/data-api-service/v1/quickbook/10108/film-events/in-cinema/8031/at-date/2020-01-03?attr=&lang=en_GB
 * https://www.cineworld.co.uk/uk/data-api-service/v1/quickbook/10108/attributes?jsonp&lang=en_GB
 */

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
