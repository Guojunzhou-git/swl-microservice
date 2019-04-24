<?php
namespace swlms\common;
use Exception;

class ServerException extends Exception{
    const SERVER_HTTP_PROTOCAL_VERIFY_ERROR = 0xFF0000;
    const SERVER_SERVICE_NOT_EXIST_ERROR = 0xFF0001;
    const SERVER_ACTION_NOT_EXIST_ERROR = 0xFF0002;
    const SERVER_SERVICE_BEFORE_ACTION_ERROR = 0xFF0003;
    const SERVER_SERVICE_AFTER_ACTION_ERROR = 0xFF0004;

    const USER_SERVICE_USER_ID_NOT_PROVIDED_ERROR = 0xEE0000;

    public static $error_msg = [
        self::SERVER_HTTP_PROTOCAL_VERIFY_ERROR => 'server_http_protocal_verify_error',
        self::SERVER_SERVICE_NOT_EXIST_ERROR => 'server_service_not_exist_error',
        self::SERVER_ACTION_NOT_EXIST_ERROR => 'server_action_not_exist_error',
        self::SERVER_SERVICE_BEFORE_ACTION_ERROR => 'server_service_before_action_error',
        self::SERVER_SERVICE_AFTER_ACTION_ERROR => 'server_service_after_action_error',

        self::USER_SERVICE_USER_ID_NOT_PROVIDED_ERROR => 'UserService_user_id_not_provided_error',
    ];

    public function __construct($code=0, $message=''){
        if(!$message){
            $message = isset(self::$error_msg[$code]) ? self::$error_msg[$code] : 'unknown error';
        }
        parent::__construct($message, $code);
    }
}