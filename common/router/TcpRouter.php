<?php
namespace swlms\common\router;
use swlms\common\protocal\TcpProtocal;
use swlms\common\ServerException;
use swlms\common\Response;

class TcpRouter{
    public static function handleRequest($tcp_message){
        $tcp_protocal = new TcpProtocal();
        try{
            $tcp_message = json_decode($tcp_message, true);
            if($tcp_protocal->verify($tcp_message)){
                $tcp_protocal->load();
                $action = $tcp_protocal->action;
                list($non, $service_name, $action_name) = explode('/', $action);
                unset($non);
                $service_class = 'swlms\\provider\\'.ucfirst($service_name).'Service';
                echo $service_class.PHP_EOL;
                if(class_exists($service_class)){
                    $service = new $service_class;
                }else{
                    throw new ServerException(ServerException::SERVER_SERVICE_NOT_EXIST_ERROR);
                }
                if(method_exists($service, $action_name)){
                    $before_result = $service->beforeAction($tcp_protocal);
                    if(true !== $before_result){
                        throw new ServerException(ServerException::SERVER_SERVICE_BEFORE_ACTION_ERROR);
                    }
                    $action_result = $service->$action_name($tcp_protocal);
                    $after_result = $service->afterAction($tcp_protocal);
                    if(true !== $after_result){
                        throw new ServerException(ServerException::SERVER_SERVICE_AFTER_ACTION_ERROR);
                    }
                    return Response::success($tcp_protocal, $action_result);
                }else{
                    throw new ServerException(ServerException::SERVER_ACTION_NOT_EXIST_ERROR);
                }
            }else{
                throw new ServerException(ServerException::SERVER_HTTP_PROTOCAL_VERIFY_ERROR, json_encode($tcp_protocal->getErrors()));
            }
        }catch (ServerException $se){
            return Response::error($tcp_protocal, $se->getCode(), $se->getMessage());
        }
    }
}