<?php
namespace swlms\provider;
use swlms\common\Service;
use swlms\common\ServerException;
use swlms\common\protocal\Protocal;

class UserService extends Service{
    public function getUserInfo(Protocal $protocal, $params){
        if(isset($params['user_id'])){
            return [
                'id' => $params['user_id'],
                'username' => 'swlms',
                'time' => date('Y-m-d H:i:s'),
            ];
        }else{
            throw new ServerException(ServerException::USER_SERVICE_USER_ID_NOT_PROVIDED_ERROR);
        }
    }
}