<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$maintaining = 0;

if ($maintaining) {
    include_once 'maintaining.php';
    die;
}

// FRONT CONTROLLER

// 1. Common settings
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
session_start();

// 2. Include system files
define('ROOT', dirname(__FILE__));
//define('DOMAIN', 'http://stage.kl.com.ua');
define('DOMAIN', 'http://192.168.1.100:8080');
require_once (ROOT . '/components/Autoload.php');

// 3. Call Router
$router = new Router();
$router->run();
