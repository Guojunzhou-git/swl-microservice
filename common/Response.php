<?php
namespace swlms\common;
use swlms\common\protocal\HttpProtocal;

class Response{
    final public static function success(HttpProtocal $hp, $data){
        return [
            'data' => $data,
            'code' => 0,
            'msg' => 'ok',
        ];
    }

    final public static function error(HttpProtocal $hp, $code, $msg, $data=[]){
        return [
            'data' => $data,
            'code' => $code,
            'msg' => $msg,
        ];
    }
}