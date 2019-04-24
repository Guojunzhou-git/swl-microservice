<?php
use swlms\common\server\TcpServer;

define('MYROOT', dirname(__DIR__).DIRECTORY_SEPARATOR.'../');
include_once(MYROOT.'/vendor/autoload.php');
$server = new TcpServer();
$server->startServer();