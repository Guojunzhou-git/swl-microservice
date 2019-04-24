<?php
namespace swlms\common\server;
use swlms\common\router\TcpRouter;

class TcpServer{
    public $http_server;
    public $config;
    public function __construct($config=[], $ip='0.0.0.0', $port=8150){
        $this->config = $config;
        $this->http_server = new \swoole_server($ip, $port);
        $this->http_server->on('connect', [$this, 'onConnect']);
        $this->http_server->on('receive', [$this, 'onReceive']);
        $this->http_server->on('close', [$this, 'onClose']);
    }

    public function onConnect($server, $client){
        echo 'New tcp client connected: '.PHP_EOL;
        echo 'server: '.json_encode($server).PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo PHP_EOL;
    }

    public function onReceive($server, $client, $from_id, $data){
        echo 'A tcp client send msg to server: '.PHP_EOL;
        echo 'server: '.json_encode($server).PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo 'from_id: '.$from_id.PHP_EOL;
        echo 'data: '.$data.PHP_EOL;
        echo PHP_EOL;
        $handle_result = TcpRouter::handleRequest($data);
        $server->send($client, json_encode($handle_result));
        $server->close($client);
    }

    public function onClose($server, $client){
        echo 'A tcp client disconnected: '.PHP_EOL;
        echo 'server: '.json_encode($server).PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo PHP_EOL;
    }

    public function startServer(){
        $this->http_server->start();
    }
}
