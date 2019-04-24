<?php
namespace swlms\provider;
use swlms\common\Service;
use swlms\common\ServerException;

class UserService extends Service{
    public function getUserInfo($hp, $params){
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