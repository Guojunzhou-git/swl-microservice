<?php
use swlms\common\server\HttpServer;

define('MYROOT', dirname(__DIR__).DIRECTORY_SEPARATOR.'../');
include_once(MYROOT.'/vendor/autoload.php');
$server = new HttpServer();
$server->startServer();