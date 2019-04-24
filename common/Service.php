<?php
namespace swlms\common;
use swlms\common\protocal\Protocal;

class Service{
    public function beforeAction(Protocal $protocal){
        return true;
    }

    public function afterAction(Protocal $protocal){
        return true;
    }
}