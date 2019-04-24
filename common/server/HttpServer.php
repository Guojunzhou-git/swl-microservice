<?php
namespace swlms\common\server;
use swlms\common\router\HttpRouter;

class HttpServer{
    public $http_server;
    public $config;
    public function __construct($config=[], $ip='0.0.0.0', $port=10000){
        $this->config = $config;
        $this->http_server = new \swoole_http_server($ip, $port);
        $this->http_server->on('start', [$this, 'onStart']);
        $this->http_server->on('request', [$this, 'onRequest']);
    }

    public function onStart($server){
        echo 'swoole_http_server start at '.$server->host.':'.$server->port.'...'.PHP_EOL;
    }

    public function onRequest($request, $response){
        $handle_result = HttpRouter::handleRequest($request);
        $response->header('Content-Type', 'application/json');
        $response->end(json_encode($handle_result));
    }

    public function startServer(){
        $this->http_server->start();
    }
}
