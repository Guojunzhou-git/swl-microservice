<?php
use swlms\common\protocal\HttpProtocal;
use swlms\common\ServerException;
use Ramsey\Uuid\Uuid;
define('MYROOT', dirname(__DIR__).DIRECTORY_SEPARATOR.'../');
include_once(MYROOT.'/vendor/autoload.php');
$data = [
    'action' => '/user/getuserinfo',
    'data' => [
        'user_id' => 1,
    ],
    'request_id' => Uuid::uuid1()->toString(),
    'request_microtime' => microtime(1),
    'debug' => 1,
];
$http_protocal = new HttpProtocal();
if($http_protocal->verify($data)){
    $http_protocal->load();
    var_dump($http_protocal);
}else{
    throw new ServerException(ServerException::SERVER_HTTP_PROTOCAL_VERIFY_ERROR, json_encode($http_protocal->getErrors()));
}