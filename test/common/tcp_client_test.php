<?php
use swlms\common\client\TcpClient;

define('MYROOT', dirname(__DIR__).DIRECTORY_SEPARATOR.'../');
include_once(MYROOT.'/vendor/autoload.php');
$client = new TcpClient();
$client->connect();