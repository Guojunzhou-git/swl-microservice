<?php
namespace swlms\common;
use swlms\common\protocal\Protocal;

class Response{
    final public static function success(Protocal $protocal, $data){
        return [
            'data' => $data,
            'code' => 0,
            'msg' => 'ok',
        ];
    }

    final public static function error(Protocal $protocal, $code, $msg, $data=[]){
        return [
            'data' => $data,
            'code' => $code,
            'msg' => $msg,
        ];
    }
}