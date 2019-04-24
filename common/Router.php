<?php
namespace swlms\common;
use Swoole\Http\Request;
use swlms\common\protocal\HttpProtocal;
use swlms\common\Response;

class Router{
    public static function handleRequest(Request $request){
        $http_protocal = new HttpProtocal();
        try{
            if($http_protocal->verify($request->post)){
                $http_protocal->load();
                $action = $http_protocal->action;
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
                    $before_result = $service->beforeAction($http_protocal);
                    if(true !== $before_result){
                        throw new ServerException(ServerException::SERVER_SERVICE_BEFORE_ACTION_ERROR);
                    }
                    $action_result = $service->$action_name($http_protocal, $http_protocal->data);
                    $after_result = $service->afterAction($http_protocal);
                    if(true !== $after_result){
                        throw new ServerException(ServerException::SERVER_SERVICE_AFTER_ACTION_ERROR);
                    }
                    return Response::success($http_protocal, $action_result);
                }else{
                    throw new ServerException(ServerException::SERVER_ACTION_NOT_EXIST_ERROR);
                }
            }else{
                throw new ServerException(ServerException::SERVER_HTTP_PROTOCAL_VERIFY_ERROR, json_encode($http_protocal->getErrors()));
            }
        }catch (ServerException $se){
            return Response::error($http_protocal, $se->getCode(), $se->getMessage());
        }
    }
}