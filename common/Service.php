<?php
namespace swlms\common;
use swlms\common\protocal\HttpProtocal;

class Service{
    public function beforeAction(HttpProtocal $hp){
        return true;
    }

    public function afterAction(HttpProtocal $hp){
        return true;
    }
}