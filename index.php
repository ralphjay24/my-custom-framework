<?php
// Directory separator is set up here because separators are different on Linux and Windows operating systems
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
$page = $_GET['page'];
require_once(ROOT . DS . 'bootstrap' . DS . 'bootstrap.php');


