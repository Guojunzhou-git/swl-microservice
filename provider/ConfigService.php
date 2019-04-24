<?php
namespace swlms\provider;
use swlms\common\Service;
use swlms\common\ServerException;
use swlms\common\protocal\Protocal;

class ConfigService extends Service{
    public function regist(Protocal $protocal){
        return json_encode($protocal);
    }
}